document.addEventListener('DOMContentLoaded', () => {
    const productTypeFilter = document.getElementById('productTypeFilter');
    const productCards = document.querySelectorAll('.card-container .card');

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
});