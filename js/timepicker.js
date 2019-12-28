// functions
function formatTime (time) {
  if (time < 10){
    time = '0' + time;
  }

  return time;
}

let d = new Date();

class Timepicker {
  constructor(timepicker_element, hr_element = hr_element, min_element, hr_up, hr_down, min_up, min_down){
    this.timepicker_element = timepicker_element;
    this.hr_element = hr_element;
    this.min_element = min_element;
    this.hr_up = hr_up;
    this.hr_down = hr_down;
    this.min_up = min_up;
    this.min_down = min_down;

    // let this.hour = d.getHours();
    // let this.minute = d.getMinutes();
    this.hour = 12;
    this.minute = 0;

    this.setTime();
  }

  setTime () {
    this.hr_element.value = formatTime(this.hour);
    this.min_element.value = formatTime(this.minute);

    this.timepicker_element.dataset.time = formatTime(this.hour) + ':' + formatTime(this.minute);
  }

  hour_change(e) {
    if (e.target.value > 23) {
      e.target.value = 23;
    } else if (e.target.value < 0){
      e.target.value = '00';
    }

    if (e.target.value == '' ) {
      e.target.value = formatTime(this.hour);
    }

    this.hour = e.target.value;
  }

  minute_change(e) {
    if (e.target.value > 59) {
      e.target.value = 59;
    } else if (e.target.value < 0){
      e.target.value = '00';
    }

    if (e.target.value == '' ) {
      e.target.value = formatTime(this.minute);
    }

    this.minute = e.target.value;
  }

  hour_up() {
    this.hour++;
    if (this.hour > 23) {
      this.hour = 0;
    }
    this.setTime();
  }

  hour_down() {
    this.hour--;
    if (this.hour < 0) {
      this.hour = 23;
    }
    this.setTime();
  }

  minute_up() {
    this.minute++;

    if (this.minute > 59) {
      this.minute = 0;
      this.hour_up();
    }

    this.setTime();
  }

  minute_down() {
    this.minute--;
    if (this.minute < 0) {
      this.minute = 59;
      this.hour_down();
    }
    this.setTime();
  }
}

// First timepicker
const start_timepicker_element = document.querySelector('#start-timepicker.timepicker');

const start_hr_element = document.querySelector('#start-timepicker.timepicker .hour .hr');
const start_min_element = document.querySelector('#start-timepicker.timepicker .minute .min');

const start_hr_up = document.querySelector('#start-timepicker.timepicker .hour .hr-up');
const start_hr_down = document.querySelector('#start-timepicker.timepicker .hour .hr-down');

const start_min_up = document.querySelector('#start-timepicker.timepicker .minute .min-up');
const start_min_down = document.querySelector('#start-timepicker.timepicker .minute .min-down');

let start_timepicker = new Timepicker(start_timepicker_element, start_hr_element, start_min_element, start_hr_up, start_hr_down, start_min_up, start_min_down);

// EVENT LISTENERS
start_timepicker.hr_up.addEventListener('click', function(e) {
  start_timepicker.hour_up(e);
});
start_timepicker.hr_down.addEventListener('click', function(e) {
  start_timepicker.hour_down(e);
});

start_timepicker.min_up.addEventListener('click', function(e) {
  start_timepicker.minute_up(e);
});
start_timepicker.min_down.addEventListener('click', function(e) {
  start_timepicker.minute_down(e);
});

start_timepicker.hr_element.addEventListener('change', function(e) {
  start_timepicker.hour_change(e);
});
start_timepicker.min_element.addEventListener('change', function(e) {
  start_timepicker.minute_change(e);
});

// Second timepicker
const end_timepicker_element = document.querySelector('#end-timepicker.timepicker');

const end_hr_element = document.querySelector('#end-timepicker.timepicker .hour .hr');
const end_min_element = document.querySelector('#end-timepicker.timepicker .minute .min');

const end_hr_up = document.querySelector('#end-timepicker.timepicker .hour .hr-up');
const end_hr_down = document.querySelector('#end-timepicker.timepicker .hour .hr-down');

const end_min_up = document.querySelector('#end-timepicker.timepicker .minute .min-up');
const end_min_down = document.querySelector('#end-timepicker.timepicker .minute .min-down');

let end_timepicker = new Timepicker(end_timepicker_element, end_hr_element, end_min_element, end_hr_up, end_hr_down, end_min_up, end_min_down);

// EVENT LISTENERS
end_timepicker.hr_up.addEventListener('click', function(e) {
  end_timepicker.hour_up(e);
});
end_timepicker.hr_down.addEventListener('click', function(e) {
  end_timepicker.hour_down(e);
});

end_timepicker.min_up.addEventListener('click', function(e) {
  end_timepicker.minute_up(e);
});
end_timepicker.min_down.addEventListener('click', function(e) {
  end_timepicker.minute_down(e);
});

end_timepicker.hr_element.addEventListener('change', function(e) {
  end_timepicker.hour_change(e);
});
end_timepicker.min_element.addEventListener('change', function(e) {
  end_timepicker.minute_change(e);
});
