// Get month name from a number
function toMonthName(monthNumber) {
  const date = new Date();
  date.setMonth(monthNumber - 1);

  return date.toLocaleString([], {
    month: 'long',
  });
}

// Get number of days in a month
const getDays = (year, month) => {
  return new Date(year, month, 0).getDate();
};

// Retrieve reservations days in api
async function retrieve_calendar_data(year, month){
  return fetch('/api/get/reservations?' + new URLSearchParams({
    'id': Object.keys(reservations_date).toString(),
    'year': year,
    'month': month
  }))
  .then(response => {
    return response.json()})
  .then(response_json =>{
    result = response_json['hydra:member'];
    result = result.reduce(function (result, a) {
      result[a.habitat_id] = result[a.habitat_id] || [];
      result[a.habitat_id].push(a);
      return result; 
    }, Object.create(null));
    return result
  })
}

// Update days in calendar
async function update_calendar(){
  let data = await retrieve_calendar_data(year, month);
  display_calendar_data(data);
  month_name.innerHTML = toMonthName(month);

  let previous_selected_month_days = day_in_month;
  day_in_month = getDays(year, month);

  if(day_in_month > previous_selected_month_days){
    for(let i=previous_selected_month_days + 1; i < day_in_month + 1 ; i++){
      days.children[i].style.display = null;
    }
  }else {
    for(let i=day_in_month + 1; i < 32 ; i++){
      days.children[i].style.display="none";
    }
  }
}

// Display days in calendar
function display_calendar_data(data){
  habitats.forEach(habitat=>{
    let habitat_id = habitat.id.split('-')[1];
    let booked_days = [];

    if(habitat_id in data){
      let habitat_reservations = data[habitat.id.split('-')[1]];
      habitat_reservations.forEach(key=>{
        let date_start = key['date_debut'].split('T')[0];
        let month_start = parseInt(date_start.split('-')[1]);
        let day_start = month_start != month ? 1 : parseInt(date_start.split('-')[2]);
        let date_end = key['date_fin'].split('T')[0];
        let month_end = parseInt(date_end.split('-')[1]);
        let day_end = month_end != month ? day_in_month : parseInt(date_end.split('-')[2]);
        
        for(let i=day_start; i < day_end; i++){
          booked_days[i] = true;
        }
      })
    }
    for(let i=1; i < day_in_month; i++){
      habitat.children[i].style.backgroundColor = i in booked_days ? 'red' : null;
    }
  })
}

const d = new Date();
let year = d.getFullYear();
let month = d.getMonth() + 1;
let day_in_month = getDays(year, month); 
let month_name = document.querySelector('#month-name');
let days = document.querySelector('#days');
let habitats = document.querySelectorAll('[id^="habitat-"]');
let main_container = document.querySelector('#main-container');
main_container.addEventListener('click', (e) => {

  if (e.target == document.querySelector('#previous-month')){
    year = month == 1 ? year - 1 : year;
    month = month == 1 ? 12 : month - 1;
    update_calendar();
  }

  if (e.target == document.querySelector('#next-month')){
    year = month == 12 ? year + 1 : year;
    month = month == 12 ? 1 : month + 1;
    update_calendar();
  }
})
update_calendar();


