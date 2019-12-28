// Create a function to get the current week
Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        var week = Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);

        // Do a wraparound to 1 when 53 is reached
        if (week == 53){
          return 1;
        } else {
          return week;
        }

        return week;
    }

// Get the curent date, month, year and week
let today = (new Date());
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let currentWeek = today.getWeek();

// Define the swedish month names
let months = ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'];

// Get the HTML element that displays the month and year
let monthAndYear = document.getElementById('monthAndYear');

// Show the calendar
showCalendar(currentMonth, currentYear);

function showCalendar(month, year){
  // Get the weekday that the month starts on
  let firstDay = new Date(year, month).getDay();

  // Get the total number of days in the month
  let daysInMonth = 32 - new Date(year, month, 32).getDate();

  // Get the table HTML element that will hold all the days
  let tbl = document.getElementById('calendar-body');

  // Always begin with a clean slate
  tbl.innerHTML = '';

  // Format the calendar header to display ex. December 2019
  monthAndYear.innerHTML = months[month] + ' ' + year;

  // Start on day 1
  let date = 1;

  // Do maximum 7 rows
  for(let i = 0; i < 7; i++){
    // Create a new row
    let row = document.createElement('tr');

    // Do the 7 weekdays
    for(let j = -1; j < 7; j++){
      // Create a new place for the day in the table
      let cell = document.createElement('td');

      // If we have overshooted the maximum days in the current month, stop creating days
      if (date > daysInMonth){
          break;
      }

      // Add week
      if (j === -1){
        // The first column is -1

        // Create a new text to hold the week numbers
        let cellText = document.createElement('p');

        // Get the week of the current row
        let rowWeek = (new Date(year, month, date)).getWeek();

        // Set the week text to the row week
        cellText.innerText = rowWeek;

        // It is the current week, give the current week text a class to style with css
        if (rowWeek === currentWeek && year == currentYear){
          cellText.classList = 'current';
        }

        // Append the week to the table
        cell.appendChild(cellText);
        row.appendChild(cell);
        continue;
      }

      // Do not display sundays and saturdays
      if (j == 0 || j == 6){
        date++;
        continue;
      }

      // Display empty boxes if the first day is not a monday
      if(i === 0 && j < firstDay){
        let cellText = document.createElement('p');
        cellText.innerText = '';
        cell.appendChild(cellText);
        row.appendChild(cell);
        continue;

      }
      else {
        // Create a new text element to hold the day
        let cellText = document.createElement('p');

        // Set the day
        cellText.innerText = date;

        // Check if it is the current day
        if (today.getFullYear() === year && today.getMonth() == month && today.getDate() == date) {
          // Add class to enable styling in css
          cellText.classList = 'current_day';
        }

        // Add the day to the calendar
        cell.appendChild(cellText)
        row.appendChild(cell);
      }

      // Go to the next day
      date++;
    }

    // Add the whole row of days
    tbl.appendChild(row);
  }

}

// Go back a month
function calendar_previous(){
  // If it is januari and we go back, change to december and go back one year
  currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
  currentMonth = currentMonth === 0 ? 11: currentMonth - 1;

  // Update the calendar
  showCalendar(currentMonth, currentYear);
}

// Go forward a month
function calendar_next(){
  // If it is december and we go forward, change to januari and go forward one year
  currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;

  // Update the calendar
  showCalendar(currentMonth, currentYear);
}
