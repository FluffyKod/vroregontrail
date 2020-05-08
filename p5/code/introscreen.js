const tl = new TimelineMax();

tl.from('#logo', 3, {
    y: -500,
    onComplete: function() {
        $('#logo').addClass('animate')
    }
})
.to('#overlay', 0.1, {
    opacity: 1
}, '-=0.2')
.to('#overlay', 1, {
    opacity: 0
})
.from('.menu', 2, {
    opacity: 0,
    onComplete: setTimeout(blink, 2000)
}, '-=1')

function blink() {
    if ($('#main-choice').hasClass('blink')) {
        $('#main-choice').toggle();
        setTimeout(blink, 700)
    }
}

$('#main-choice').mouseover(function() {
    $('#main-choice').css('opacity', 1);
    $('#main-choice').removeClass('blink');
})

$('#main-choice').mouseleave(function() {
    $('#main-choice').addClass('blink');
    setTimeout(blink, 700);
})

$('#main-choice').click(function() {
    $('#main-choice').removeClass('blink');

    $('#audio-holder').animate({
          volume: 0
      }, 3000)

    // $('#overlay').css('background', 'black');
    $('#overlay').animate({
        opacity: 1
    }, 3000, function() {

        $('#game-img').css('opacity', 1);
        $('#grandparent').css('z-index', 2);

        setTimeout(function() {
          paused = false;
        }, 2000)

        $('#overlay').animate({
            opacity: 0
        }, 5000)

        // Change music
        $('#audio-holder').attr('src', player.music)

        if (hasSound == true) {
          $('#audio-holder').animate({
              volume: 0.3
          }, 3000)
        } else {
          $('#audio-holder').prop('volume', 0);
        }

    })

})

$('#restart-game').click(function() {
  clearPlayer();
});

$('#toggle-sound').click(function() {
  hasSound = (hasSound == true) ? false : true;
  let musicImgOn = $('#game-asset-folder').text() + 'mini-assets/musicON.png';
  let musicImgOff = $('#game-asset-folder').text() + 'mini-assets/musicOFF.png';

  if (hasSound == true) {
    $('#toggle-sound').attr('src', musicImgOn);
    $('#audio-holder').prop('volume', 0.3);
  } else {
    $('#toggle-sound').attr('src', musicImgOff);
    $('#audio-holder').prop('volume', 0);
  }
})

$("#toggle-admin").click(function() {
  $('#parent').toggleClass('admin');
})

$('#chapter-select-btn').click(function(e) {
  $('.chapter-select').removeClass('hidden');
  $('#chapter-select-btn').addClass('hidden');

  // Go through and show chapters which are released AND unlocked
  for (let chapter = 2; chapter <= 5; chapter++) {
    if (chapter <= completedChapters && player.completed.length >= chapter - 1) {
      $(`#chapter-${chapter}`).removeClass('hidden');
    }
  }

})
