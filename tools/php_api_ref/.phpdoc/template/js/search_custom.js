(function(global, doc) {
    const searchInput = doc.querySelector('#search_input');
    const searchToggle = doc.querySelector('#__search');
    const searchResults = doc.querySelector('.phpdocumentor-search-results');
    const searchResultsEntries = searchResults.querySelector('.phpdocumentor-search-results__entries');
    const overlay = doc.querySelector('.md-search__overlay');
    const blurSearch = () => {
        searchInput.value = null;
        searchToggle.checked = false;

        searchResults.classList.add('phpdocumentor-search-results--hidden');
        searchInput.classList.remove('focus-visible');
        searchInput.removeAttribute('data-focus-visible-added');
        overlay.removeEventListener('click', blurSearch);
    };

    searchInput.addEventListener('focus', () => {
        searchInput.classList.add('focus-visible');
        searchInput.setAttribute('data-focus-visible-added', '');
        searchToggle.checked = true;

        overlay.addEventListener('click', blurSearch);
    });

    searchResults.addEventListener('click', () => {
        blurSearch();
    });
})(window, window.document);
