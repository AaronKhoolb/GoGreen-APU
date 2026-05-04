/*
    Author: Khoo Lay Bin
    Date: 2026-01-15
    Description: explore event page share event link actions
*/

document.querySelectorAll(".share-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        if (navigator.share) {
            navigator.share({
                title: btn.dataset.title,
                text: `${btn.dataset.title}\n${btn.dataset.description}\n\nView event details and register here.`,
                url: btn.dataset.url
            });
        } else {
            navigator.clipboard.writeText(btn.dataset.url);
            alert("Link copied!");
        }
    });
});
