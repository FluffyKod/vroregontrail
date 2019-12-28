const dp_months = ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'];

// HELPER FUNCTIONS
function checkEventPathForClass (path, selector) {
  for (let i = 0; i < path.length; i++){
    if (path[i].classList && path[i].classList.contains(selector)) {
      return true;
    }
  }
  return false;
}

function formatDate(d){
  let day = d.getDate();
  if (day < 10){
    day = '0' + day;
  }

  let month = d.getMonth() + 1;
  if (month < 10){
    month = '0' + month;
  }

  let year = d.getFullYear();

  return day + ' / ' + month + ' / ' + year;
}

class Datepicker {
  constructor(date_picker_element, selected_date_element, dates_element, mth_element, next_mth_element, prev_mth_element, days_element) {
    this.date_picker_element = date_picker_element;
    this.selected_date_element = selected_date_element;
    this.dates_element = dates_element;
    this.mth_element = mth_element;
    this.next_mth_element = next_mth_element;
    this.prev_mth_element = prev_mth_element;
    this.days_element = days_element;

    this.date = new Date();
    this.day = this.date.getDate();
    this.month = this.date.getMonth();
    this.year = this.date.getFullYear();

    this.selectedDate = this.date;
    this.selectedDay = this.day;
    this.selectedMonth = this.month;
    this.selectedYear = this.year;

    this.mth_element.textContent = dp_months[this.month] + ' ' + this.year;

    this.selected_date_element.textContent = formatDate(this.date);
    this.selected_date_element.dataset.value = this.selectedDate;

    this.populateDates();
  }

  toggleDatePicker(e) {
    if (!checkEventPathForClass(e.path, 'dates')){
      this.dates_element.classList.toggle('active');
    }
  }

  populateDates(){
    this.days_element.innerHTML = '';

    // Get the amount of days in the month
    let days_in_month = 32 - new Date(this.year, this.month, 32).getDate();

    for (let i = 0; i < days_in_month; i++){
      const day_element = document.createElement('div');
      day_element.classList.add('day');
      day_element.textContent = i + 1;

      if (this.selectedDay == (i + 1 )&& this.selectedYear == this.year && this.selectedMonth == this.month){
        day_element.classList.add('selected')
      }

      var _this = this;
      day_element.addEventListener('click', function(e) {
        _this.selectedDate = new Date(_this.year + '-' + (_this.month + 1) + '-' + (i + 1));
        _this.selectedDay = (i + 1);
        _this.selectedMonth = _this.month;
        _this.selectedYear = _this.year;

        _this.selected_date_element.textContent = formatDate(_this.selectedDate);
        _this.selected_date_element.dataset.value = _this.selectedDate;

        _this.populateDates();
      });

      this.days_element.appendChild(day_element);
    }
  }

  goToNextMonth(e) {
    // Go to next month
    this.month++;

    // If last month was december, change to januari next year
    if (this.month > 11){
      this.month = 0;
      this.year++;
    }

    this.mth_element.textContent = dp_months[this.month] + ' ' + this.year;
    this.populateDates();
  }

  goToPrevMonth(e) {
    // Go to prev month
    this.month--;

    // If last month was januari, change to december last year
    if (this.month < 0){
      this.month = 11;
      this.year--;
    }

    this.mth_element.textContent = dp_months[this.month] + ' ' + this.year;
    this.populateDates();
  }

}

// Start datepicker
const start_date_picker_element = document.querySelector('#start-datepicker.date-picker');
const start_selected_date_element = document.querySelector('#start-datepicker.date-picker .selected-date');
const start_dates_element = document.querySelector('#start-datepicker.date-picker .dates');
const start_mth_element = document.querySelector('#start-datepicker.date-picker .dates .month .mth');
const start_next_mth_element = document.querySelector('#start-datepicker.date-picker .dates .month .next-mth');
const start_prev_mth_element = document.querySelector('#start-datepicker.date-picker .dates .month .prev-mth');
const start_days_element = document.querySelector('#start-datepicker.date-picker .dates .days');

let start_datepicker = new Datepicker(start_date_picker_element, start_selected_date_element, start_dates_element, start_mth_element, start_next_mth_element, start_prev_mth_element, start_days_element);

// EVENT LISTENERS
start_datepicker.date_picker_element.addEventListener('click', function(e) {
  start_datepicker.toggleDatePicker(e);
})

start_next_mth_element.addEventListener('click', function(e) {
  start_datepicker.goToNextMonth(e);
});

start_prev_mth_element.addEventListener('click', function(e){
  start_datepicker.goToPrevMonth(e);
});


// End datepciker
const end_date_picker_element = document.querySelector('#end-datepicker.date-picker');
const end_selected_date_element = document.querySelector('#end-datepicker.date-picker .selected-date');
const end_dates_element = document.querySelector('#end-datepicker.date-picker .dates');
const end_mth_element = document.querySelector('#end-datepicker.date-picker .dates .month .mth');
const end_next_mth_element = document.querySelector('#end-datepicker.date-picker .dates .month .next-mth');
const end_prev_mth_element = document.querySelector('#end-datepicker.date-picker .dates .month .prev-mth');
const end_days_element = document.querySelector('#end-datepicker.date-picker .dates .days');

let end_datepicker = new Datepicker(end_date_picker_element, end_selected_date_element, end_dates_element, end_mth_element, end_next_mth_element, end_prev_mth_element, end_days_element);

// EVENT LISTENERS
end_datepicker.date_picker_element.addEventListener('click', function(e) {
  end_datepicker.toggleDatePicker(e);
})

end_next_mth_element.addEventListener('click', function(e) {
  end_datepicker.goToNextMonth(e);
});

end_prev_mth_element.addEventListener('click', function(e){
  end_datepicker.goToPrevMonth(e);
});
