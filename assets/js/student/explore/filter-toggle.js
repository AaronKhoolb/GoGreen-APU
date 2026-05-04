/*
    Author: Khoo Lay Bin
    Date: 2026-01-22
    Description: explore event page toggle filter
*/

document.addEventListener('DOMContentLoaded', function() {
    var filterBtn = document.getElementById('filter-toggle-btn');
    var filterWrapper = document.getElementById('filter-wrapper');

    if (filterBtn && filterWrapper) {
        filterBtn.onclick = function() {
            filterWrapper.classList.toggle('filter-hidden-mobile');
            filterBtn.classList.toggle('active');
        };
    }
});
