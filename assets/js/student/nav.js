/* 
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: Student desktop navigation bar (toggle dark bg for hero section when scrolling)
*/

document.addEventListener('DOMContentLoaded', function () {

    const nav = document.querySelector('.desktop-nav-container');
    const hero = document.querySelector('.slider-box');


    if (!hero) {
        nav.classList.add('scrolled');
        return;
    }

    window.addEventListener('scroll', function () {
        nav.classList.toggle('scrolled', hero.getBoundingClientRect().bottom < 100);
    }, true);

});

