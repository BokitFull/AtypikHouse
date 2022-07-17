function toMonthName(monthNumber) {
  const date = new Date();
  date.setMonth(monthNumber - 1);

  return date.toLocaleString([], {
    month: 'long',
  });
}

const getDays = (year, month) => {
  return new Date(year, month, 0).getDate();
};
const d = new Date();
let year = d.getFullYear();
let month = d.getMonth() + 1;
let day_in_month = getDays(year, month); 
let calendar = document.querySelector('#calendar');
let month_name = document.querySelector('#month-name');
    month_name.innerHTML = toMonthName(month);
let days = document.querySelector('#days');

for(let i=day_in_month + 1; i < 32 ; i++){
  days.children[i].style.display="none";
}

reservations_date = JSON.parse(reservations_date);
let habitats = document.querySelectorAll('[id^="habitat-"]');

function displayReservations(){
  habitats.forEach(habitat=>{
    Object.keys(reservations_date[habitat.id.split('-')[1]]).forEach(key=>{
      let reservation = reservations_date[habitat.id.split('-')[1]][key];
      let start_date_year = reservation['start'].split('-')[0];
      let start_date_month = reservation['start'].split('-')[1];

      if(start_date_year == year && start_date_month == month){
        let start_date_day = parseInt(reservation['start'].split('-')[2]);
        let end_date_day = parseInt(reservation['end'].split('-')[2]);

        for(let i=start_date_day; i < end_date_day; i++){
          habitat.children[i].style.backgroundColor = "red";
        }
      }
    })
  })
}
displayReservations();

let main_container = document.querySelector('#main-container');
main_container.addEventListener('click', (e) => {

  if (e.target == document.querySelector('#previous-month')){
    let data = new FormData();
    data.append('habitats', reservations_date.keys())
    let response = fetch('/api/habitats/' + habitat)
  }

  if (e.target == document.querySelector('#next-month')){
    
  }
})
    // Object.keys(reservations).forEach(reservations_index=>{
    //   let reservation = reservations[reservations_index];
    //   let start_date_year = reservation['start'].split('-')[0];
    //   let start_date_month = reservation['start'].split('-')[1];
    //   if(start_date_year == year && start_date_month == month){
    //     let start_date_day = reservation['start'].split('-')[2];
    //     let end_date_day = reservation['end'].split('-')[2];

    //     for(let i=start_date_day; i < end_date_day; i++){
    //       habitat.children[i].style.backgroundColor = "red";
    //     }
    //   }
    // })
    

  // for(let reservations of reservations_date[habitat.id.split('-')[1]]){
  //   console.log(reservations)
  //   let start_date_year = reservations['start'].split('-')[0];
  //   let start_date_month = reservations['start'].split('-')[1];

  //   if(start_date_year == year && start_date_month == month){
  //     let start_date_day = reservations['start'].split('-')[2];
  //     let end_date_day = reservations['end'].split('-')[2];

  //     for(let i=start_date_day; i < end_date_day; i++){
  //       habitat.children[i].style.backgroundColor = "red";
  //     }
  //   }
  // }
// })


// const getDays = (year, month) => {
//     return new Date(year, month, 0).getDate();
// };

// const d = new Date();
// const today = new Date;

// let month = d.getMonth();
// let day_in_month = getDays(2021, parseInt(month) - 1); 
// let calendar_days = 42;
// let day = today.getDate();
// let calendar = document.querySelector('#calendar');
// let days = document.querySelector('#days');
// let months = document.querySelector('#months');
// let month_loop = 0;

// function toMonthName(monthNumber) {
//     const date = new Date();
//     date.setMonth(monthNumber - 1);
  
//     // 👇️ using visitor's default locale
//     return date.toLocaleString([], {
//       month: 'long',
//     });
//   }

// let month_name = document.querySelector('#month_name');
// month_name.innerHTML = toMonthName(month);

// for(let i=day_in_month; i < 32 ; i++){
//   days.children[i].style.display="none";
// }

// for(let i=1; i < day_in_month + 1; i++){
//   days.children[i].innerHTML = day;
//   day ++;

//   if (day > day_in_month){
//     month ++;
//     day_in_month = getDays(2021, parseInt(month) - 1); 
//     day = 1
//   }
// }



