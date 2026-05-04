/*
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: - Autoplay pinned events on homepage hero section carousel
                 - Mobile swipe left and right
                 - click to change event
                 - set text using goTo function
*/


document.addEventListener('DOMContentLoaded', function () {


    var bgImg = document.getElementById('bg-img');
    var title = document.getElementById('slider-title');
    var clubLogo = document.getElementById('club-logo');
    var clubName = document.getElementById('club-name');
    var link = document.getElementById('slider-link');
    var cards = document.querySelectorAll('.thumb-card');

    var current = 0;
    var total = cards.length;


    setInterval(function () {
        current++;
        if (current >= total) current = 0;
        goTo(current);
    }, 6000);


    for (var i = 0; i < cards.length; i++) {
        cards[i].addEventListener('click', function () {
            goTo(parseInt(this.getAttribute('data-index')));
        });
    }


    var startX = 0;
    var slider = document.getElementById('slider');

    slider.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
    });

    slider.addEventListener('touchend', function (e) {
        var diff = startX - e.changedTouches[0].clientX;
        if (diff > 50) { current++; if (current >= total) current = 0; goTo(current); }
        if (diff < -50) { current--; if (current < 0) current = total - 1; goTo(current); }
    });


    function goTo(index) {
        current = index;
        var card = cards[index];


        bgImg.src = card.getAttribute('data-img');
        title.textContent = card.getAttribute('data-title');
        clubLogo.src = card.getAttribute('data-club-logo');
        clubName.textContent = card.getAttribute('data-club');
        link.href = card.getAttribute('data-link');


        for (var i = 0; i < cards.length; i++) cards[i].classList.remove('active');
        card.classList.add('active');
    }

});