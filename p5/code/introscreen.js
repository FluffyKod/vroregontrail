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
    onComplete: function() {
      setTimeout(blink, 2000)
    }
}, '-=1')

function blink() {
    if ($('#main-choice').hasClass('blink')) {
        $('#main-choice').toggle();
        setTimeout(blink, 700)
    }
}

function fader() {
  $('#overlay').animate({
      opacity: 1
  }, 3000, function() {

      setTimeout(function() {
        paused = false;
      }, 2000)

      $('#overlay').animate({
          opacity: 0
      }, 5000)

      if (hasSound == true) {
        $('#audio-holder').animate({
            volume: 0.3
        }, 3000)
      } else {
        $('#audio-holder').prop('volume', 0);
      }
  })

  $('#audio-holder').animate({
      volume: 0.
  }, 3000)
}

function transition() {
  $('#overlay').animate({
      opacity: 1
  }, 3000, function() {

      $('#game-over').removeClass('active');
      $('#game-img').css('opacity', 1);
      $('#grandparent').css('z-index', 2);

      setTimeout(function() {
        paused = false;
      }, 2000)

      $('#overlay').animate({
          opacity: 0
      }, 5000)

      // CHANGE IF STSRT NEW CHAPTER
      if (player.completed.length == 1 && player.area == 'bog' && player.x == -1 && player.y == 23 ) {
        player.background = backgrounds.bogGeneral;
        player.music = music.swamp;
        $('#audio-holder').attr('src', player.music)
      }

      // Change music
      $('#audio-holder').attr('src', player.music)

      if (hasSound == true) {
        $('#audio-holder').animate({
            volume: 0.3
        }, 3000)
      } else {
        $('#audio-holder').prop('volume', 0);
      }

      // SHow toggle admin
      document.getElementById('toggle-admin').style.opacity = 1;

  })
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

    transition();
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

// $('#continue-next-chapter').click(function(e) {
//   let newArea = player.area;
//   let startX = player.x;
//   let startY = player.y;
//
//   let newAssets = changeArea(newArea);
//
//   // Change background and music
//   fade(newAssets[1], function() {
//
//     // Set player to start coordinates for that chapter
//     changeRoom(newArea, startX, startY);
//     changeBackgroundImage(newAssets[0]);
//     resetTextbox();
//     changeBoxColor()
//     $('#endscreen').removeClass('active');
//     $('#intro-screen').addClass('hidden');
//     $('#game-img').css('opacity', 1);
//     $('#grandparent').css('z-index', 2);
//
//     savePlayer();
//
//     setTimeout(function() {
//       paused = false;
//
//     }, 2000)
//
//   })
// })
