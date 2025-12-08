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
            const containerId = button.dataset.target;
            scrollContainerLeft(containerId);
        });
    });

    rightButtons.forEach(button => {
        button.addEventListener('click', () => {
            const containerId = button.dataset.target;
            scrollContainerRight(containerId);
        });
    });
});

function scrollContainerLeft(containerId) {
    const target = document.getElementById(containerId);
    if (target) {
        target.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    }
}

function scrollContainerRight(containerId) {
    const target = document.getElementById(containerId);
    if (target) {
        target.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    }
}
