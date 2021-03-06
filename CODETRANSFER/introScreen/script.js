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

    $('#overlay').css('background', 'black');
    $('#overlay').animate({
        opacity: 1
    }, 3000, function() {
        $('#game-img').css('opacity', 1)
        $('#overlay').animate({
            opacity: 0
        }, 5000)
    })

})




// tl.to('.title-1', 1, {
//     x: 10,
//     opacity: 1,
//     ease: Power2.easeInOut
// })
// .to('.title-2', 1, {
//     x: 150,
//     opacity: 1,
//     ease: Power2.easeInOut
// }, '-=0.5')
// .from('.pattern', 1, {
//     width: 0,
//     opacity: 0,
//     ease: Power2.easeInOut
// }, '-=0.5')