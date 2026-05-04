/*
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: Admin, Organizer, Collaborator sidebar js - expand or minimize sidebar
*/


function switchSidebar() {
    const s = document.getElementById('side_nav');
    s.classList.toggle('small');
}

document.addEventListener('DOMContentLoaded', function () {
    const arrows = document.querySelectorAll('.arrow');

    
    if (window.innerWidth < 768) {
        document.getElementById('side_nav').classList.add('small');
    }

    
    arrows.forEach(a => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const box = this.closest('.dropdown_box');
            const menu = box.querySelector('.sub_menu');

            this.classList.toggle('open');
            menu.classList.toggle('show');
        });
    });
});
