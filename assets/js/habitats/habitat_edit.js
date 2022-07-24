async function getAdresse(nom){
    return fetch('https://api-adresse.data.gouv.fr/search/?'
     + new URLSearchParams({
      'q': nom,
      'type': 'street',
      'autocomplete': '1',
    })
    )
    .then(response => {
      return response.json()
    })
}

function updateAdresse(adresse){
  let adresseElement = document.createElement('ul');
  if(Array.isArray(adresse.features) && adresse.features.length){
    adresse.features.forEach(function(obj){
        console.log(obj.properties.context)
        adresseElement.innerHTML += `
            <li data-label=${obj.properties.label} data-context=${obj.properties.city};${obj.properties.context.replaceAll(', ', ';')}>
                <span>${obj.properties.label}</span>
            </li>
        `})
  }
  resultAdresse.innerHTML = ''
  resultAdresse.appendChild(adresseElement);
}

let mainContainer = document.querySelector('#main-container');
let resultAdresse = document.querySelector('#result_adresse');
let adresseInputName = document.querySelector('#habitats_adresse');
let adresseInputHidden = document.querySelector('[name=adresse]');

mainContainer.addEventListener('input', async (e)=>{
  if(e.target.id == 'habitats_adresse'){
    if(e.target.value.length > 2){
      let adresse = await getAdresse(e.target.value);
      updateAdresse(adresse);
      resultAdresse.style.display = 'block';
    }
  }
})

mainContainer.addEventListener('click', async (e)=>{
  if(e.target.id != 'result_adresse'){
    resultAdresse.style.display = 'none';
  }
  if(e.target.parentElement.parentElement.id == 'result_adresse') {
    adresseInputName.value = e.target.dataset.label;
    adresseInputHidden.value = e.target.dataset.context;
  } else if(e.target.parentElement.parentElement.parentElement.id == 'result_adresse') {
    adresseInputName.value = e.target.innerHTML;  
    adresseInputHidden.value = e.target.parentElement.dataset.context;
  }
})
