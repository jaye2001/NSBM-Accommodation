

document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.querySelector('#searchBar button');
    searchButton.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent  submit
        // search functionality here
        console.log('Search button clicked');
    });
});
