Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        var week = Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
        if (week == 53){
          return 1;
        } else {
          return week;
        }
    }

let today = (new Date());
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let currentWeek = today.getWeek();

let months = ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'];

let monthAndYear = document.getElementById('monthAndYear');

showCalendar(currentMonth, currentYear);

function showCalendar(month, year){
  let firstDay = new Date(year, month).getDay();
  let daysInMonth = 32 - new Date(year, month, 32).getDate();

  let tbl = document.getElementById('calendar-body');

  tbl.innerHTML = '';

  monthAndYear.innerHTML = months[month] + ' ' + year;

  let date = 1;

  for(let i = 0; i < 7; i++){
    let row = document.createElement('tr');

    for(let j = -1; j < 7; j++){
      let cell = document.createElement('td');

      if (date > daysInMonth){
          break;
      }

      // Add week
      if (j === -1){
        let cellText = document.createElement('p');

        let rowWeek = (new Date(year, month, date)).getWeek();
        cellText.innerText = rowWeek;

        // It is the current week
        if (rowWeek === currentWeek && year == currentYear){
          cellText.classList = 'current';
        }

        cell.appendChild(cellText);
        row.appendChild(cell);
        continue;
      }

      if (j == 0 || j == 6){
        date++;
        continue;
      }

      if(i === 0 && j < firstDay){
        let cellText = document.createElement('p');
        cellText.innerText = '';
        cell.appendChild(cellText);
        row.appendChild(cell);
        continue;

      }
      else {
        let cellText = document.createElement('p');
        cellText.innerText = date;

        // Check if current day
        if (today.getFullYear() === year && today.getMonth() == month && today.getDate() == date) {
          cellText.classList = 'current_day';
        }

        cell.appendChild(cellText)
        row.appendChild(cell);
      }

      date++;
    }

    tbl.appendChild(row);
  }

}

function calendar_previous(){
  currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
  currentMonth = currentMonth === 0 ? 11: currentMonth - 1;
  showCalendar(currentMonth, currentYear);
}

function calendar_next(){
  currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;
  showCalendar(currentMonth, currentYear);
}
