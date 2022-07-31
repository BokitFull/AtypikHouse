import { French } from "flatpickr/dist/l10n/fr.js"
const flatpickr = require("flatpickr");

document.querySelector("#date-picker").flatpickr({
  locale: French,
  mode: 'range',
  showMonths: 2,
  static:true,
  startDate: "today",
  minDate: "today"
});
document.querySelector('.flatpickr-calendar').style.right = '-4px';

async function getRegions(nom){
  return fetch('https://geo.api.gouv.fr/regions?' + new URLSearchParams({
    'nom': nom,
    'limit': 2,
    'format': 'json',
  }))
  .then(response => {
    return response.json()
  })
}

async function getDepartements(nom){
  return fetch('https://geo.api.gouv.fr/departements?' + new URLSearchParams({
    'nom': nom,
    'limit': 3,
    'format': 'json',
  }))
  .then(response => {
    return response.json()
  })
}

async function getCommunes(nom){
  return fetch('https://geo.api.gouv.fr/communes?' + new URLSearchParams({
    'nom': nom,
    'limit': 3,
    'format': 'json',
  }))
  .then(response => {
    return response.json()})
}

function updateDestinations(regions, departements, communes){
  let destinationsElement = document.createElement('ul');
  let data = {'regions': regions, 'departements': departements, 'communes': communes};
  for (let [key, value] of Object.entries(data)){
    if(Array.isArray(value) && value.length){
      value.forEach(function(obj){
          destinationsElement.innerHTML += `
              <li data-label=${obj.nom} data-type=${key}>
                <span>${obj.nom}</span>
              </li>
          `})
        } 
      };
  result_cp.innerHTML = ''
  result_cp.appendChild(destinationsElement);
}

let mainContainer = document.querySelector('#main-container');
let result_cp = document.querySelector('#result-cp');
let destinationsInputName = document.querySelector('#destinations-name');
let destinationsInputHidden = document.querySelector('[name=destinations]');

mainContainer.addEventListener('input', async (e)=>{
  if(e.target.id == 'destinations-name'){
    if(e.target.value.length > 2){
      let regions = await getRegions(e.target.value);
      let departements = await getDepartements(e.target.value);
      let communes = await getCommunes(e.target.value);
      updateDestinations(regions.concat(departements, communes));
      result_cp.style.display = 'block';
    }
  }
})

mainContainer.addEventListener('click', async (e)=>{
  if(e.target.id != 'result_cp'){
    result_cp.style.display = 'none';
  }
  if(e.target.parentElement.parentElement.id == 'result-cp') {
    destinationsInputName.value = e.target.dataset.label;
    destinationsInputHidden.value = e.target.dataset.label + ';' + e.target.dataset.type;
  } else if(e.target.parentElement.parentElement.parentElement.id == 'result-cp') {
    destinationsInputName.value = e.target.innerHTML;
    destinationsInputHidden.value = e.target.parentElement.dataset.label + ';' + e.target.parentElement.dataset.type;
  }
})


