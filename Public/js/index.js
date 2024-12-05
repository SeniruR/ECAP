const cardContainer = document.querySelector('.card-container');
const swipeLeftBtn = document.querySelector('.swipe-left');
const swipeRightBtn = document.querySelector('.swipe-right');

swipeLeftBtn.addEventListener('click', () => {
  cardContainer.scrollLeft -= 300; // Adjust the scroll amount as needed
});

swipeRightBtn.addEventListener('click', () => {
  cardContainer.scrollLeft += 300; // Adjust the scroll amount as needed
});