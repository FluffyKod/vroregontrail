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

    $('#overlay').css('background', 'black');
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

$('#toggle-sound').click(function() {
  hasSound = (hasSound == true) ? false : true;

  if (hasSound == true) {
    $('#audio-holder').prop('volume', 0.3);
  } else {
    $('#audio-holder').prop('volume', 0);
  }
})
