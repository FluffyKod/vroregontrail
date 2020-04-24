$(window).ready(function() {
    $('#audio-holder').prop('volume', 0);

    $('#audio-holder').animate({
        volume: 1
    }, 4000)
})

function fade(music, continueGame) {

  if (music != false) {
    $('#audio-holder').animate({
          volume: 0
      }, 2000, function() {
          // Change music
          player.music = music
          $('#audio-holder').attr('src', music)
          $('#audio-holder').animate({
              volume: 1
          }, 2000)
      })
  }

  $('.dim').animate({
    opacity: 1
  }, 3000, function() {

    continueGame()

    $('.dim').animate({
      opacity: 0
    }, 3000)
  })

}
