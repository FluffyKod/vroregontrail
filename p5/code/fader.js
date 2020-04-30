function fade(music = false, continueGame = false) {

  if (music != false) {
    $('#audio-holder').animate({
          volume: 0
      }, 3000, function() {
          // Change music
          player.music = music
          $('#audio-holder').attr('src', music)
          $('#audio-holder').animate({
              volume: 0.3
          }, 3000)
      })
  }

  $('#overlay').animate({
    opacity: 1
  }, 3000, function() {

    if (continueGame) {
      continueGame()
    }

    $('#overlay').animate({
      opacity: 0
    }, 3000)
  })

}

$(window).ready(function() {

    $('#audio-holder').prop('volume', 0);

    $('#audio-holder').animate({
        volume: 0.3
    }, 4000)

    // $('.dim').css('opacity', 1);
    //
    // setTimeout(function() {
    //   paused = false;
    // }, 2000)
    //
    // $('.dim').animate({
    //   opacity: 0
    // }, 6000)
})
