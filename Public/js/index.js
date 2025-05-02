document.addEventListener('DOMContentLoaded', () => {
    const productTypeFilter = document.getElementById('productTypeFilter');
    const productCards = document.querySelectorAll('.card-container .card');

    if (productTypeFilter) {
        productTypeFilter.addEventListener('change', () => {
            const selectedType = productTypeFilter.value;

            productCards.forEach(card => {
                const cardType = card.getAttribute('data-type');

                if (selectedType === '' || cardType === selectedType) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    const leftButtons = document.querySelectorAll('.scroll-btn.left');
    const rightButtons = document.querySelectorAll('.scroll-btn.right');

    leftButtons.forEach(button => {
        button.addEventListener('click', () => {
            const containerId = button.getAttribute('onclick').match(/'([^']+)'/)[1];
            scrollLeft(containerId);
        });
    });

    rightButtons.forEach(button => {
        button.addEventListener('click', () => {
            const containerId = button.getAttribute('onclick').match(/'([^']+)'/)[1];
            scrollRight(containerId);
        });
    });
});

function scrollLeft(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        container.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    }
}

function scrollRight(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        container.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }
}