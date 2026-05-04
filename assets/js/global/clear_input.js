/*
    Author: Khoo Lay Bin
    Date: 2026-1-8
    Description: Create a global clear button script for all txt box, text area, search bar, ...
*/


document.addEventListener('input', function (event) {
    const input = event.target;
    input.parentElement.classList.toggle('has-text', input.value.length > 0);
});


document.addEventListener('click', function (event) {
    const clearBtn = event.target.closest('.clear-btn');

    if (!clearBtn) return;

    const input = document.getElementById(clearBtn.getAttribute('data-target'));

    if (!input) return;

    input.value = '';
    input.parentElement.classList.remove('has-text');
    input.focus();
});
