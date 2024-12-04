function scrollToDetails(event) {
    event.preventDefault();
    document.querySelector('#details').scrollIntoView(
        {
            behavior: 'smooth'
        }
    );
}