$(window).ready(function() {
    $('#audio-holder').prop('volume', 0);

    $('#audio-holder').animate({
        volume: 1
    }, 4000)
})

function runFadeWithMusic() {
  $('#audio-holder').animate({
        volume: 0
    }, 2000, function() {
        // Change music
        $('#audio-holder').attr('src', './taverna.mp3')
        $('#audio-holder').animate({
            volume: 1
        }, 3000)
    })

    $('.fade').animate({
        top: 0
    }, 2000, function() {
        $('.dim').css('background', 'black');

        $('.dim').animate({
            opacity: 0
        }, 3000, function() {
            $('.dim').css('background', 'white')
            $('.dim').css('opacity', 1)
        })

        $('.fade').animate({
            top: '-200%'
        }, 1000)
    })
}
