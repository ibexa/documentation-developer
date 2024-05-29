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
    const observer = new MutationObserver((mutationList) => {
        mutationList.forEach((mutation) => {
            const addedNode = mutation.addedNodes[0];

            if (!addedNode || addedNode.querySelector(':scope > a')) {
                return;
            }

            const headerElement = addedNode.querySelector('h3');
            const linkElement = headerElement.querySelector('a');

            if (!linkElement) {
                return;
            }

            const newLinkElement = linkElement.cloneNode(true);
            const linkChildren = linkElement.childNodes;
            const contentChildren = addedNode.cloneNode(true).childNodes;

            newLinkElement.innerHTML = '';
            newLinkElement.append(...contentChildren);

            const newLinkHeader = newLinkElement.querySelector('h3');

            newLinkHeader.innerHTML = '';
            newLinkHeader.append(...linkChildren);

            addedNode.innerHTML = '';
            addedNode.append(newLinkElement);
        });
    });

    window.setTimeout(() => {
        searchInput.setAttribute('placeholder', 'Search');
    }, 500);

    searchInput.addEventListener('focus', () => {
        searchInput.classList.add('focus-visible');
        searchInput.setAttribute('data-focus-visible-added', '');
        searchToggle.checked = true;

        overlay.addEventListener('click', blurSearch);
    });

    searchResults.addEventListener('click', () => {
        blurSearch();
    });

    observer.observe(searchResultsEntries, {
        childList: true,
        subtree: true,
    });
})(window, window.document);
