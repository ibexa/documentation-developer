'use strict';

let index = lunr.Index;
const builder = new lunr.Builder;
const searchSections = document.querySelectorAll('.search-container');
const searchResults = document.getElementById('search-results');
const searchInput = document.getElementById('search-input');
const dropdownMenu = document.getElementById('dropdownMenuLink');

configureIndexBuilder();
addIndexes();
index = builder.build();

searchInput.addEventListener('keyup', search);

document.addEventListener('keyup', event => {
    if (event.keyCode === 27) {
        hideResultsBlock();
        this.value = '';
    }
});

document.addEventListener('click', event => {
    if (event.target !== searchResults) {
        hideResultsBlock();
    }

    if (event.target === searchInput && event.target.value.trim()) {
        showResultsBlock();
    }
});

dropdownMenu.addEventListener('click', event => {
    hideResultsBlock();
});

function configureIndexBuilder() {
    builder.ref('id');
    builder.field('name');
    builder.field('body');
    builder.field('root');
    builder.field('url');
}

function addIndexes() {
    searchSections.forEach(searchSection => {
        const name = getEndpointName(searchSection);
        const body = getEndpointBody(searchSection);
        const url = getEndpointUrl(searchSection);

        addIndex(
            name.id,
            name.textContent.trim(),
            body ? body.textContent : '',
            searchSection.dataset.parent,
            `/${url.textContent.slice(1)}`
        );
    });
}

function addIndex(id, name, body, root, url) {
    builder.add({
        id: id,
        name: name,
        body: body,
        root: root,
        url: url
    });
}

function search(event) {
    if (this.value.length > 0 && this.value.trim()) {
        showResultsBlock();
        showResults(
            getResults(this.value)
        );
    } else {
        hideResultsBlock();
    }
}

function getResults(searchValue) {
    const results = executeQuery(searchValue, buildQuery(searchValue));

    if (results.length === 0 && isLogicalAnd(searchValue)) {
        return executeQuery(searchValue, getLogicalAndQueryWithLeadingAndTrailingWildcards());
    }

    if (results.length === 0 && !isLogicalAnd(searchValue)) {
        return executeQuery(searchValue, getQueryWithLeadingAndTrailingWildcards());
    }

    return results;
}

function executeQuery(searchValue, options) {
    return index.query(query => {
        query.term(lunr.tokenizer(parseSearchValue(searchValue)), options);
    });
}

function parseSearchValue(searchValue) {
    if (!isLogicalAnd(searchValue)) {
        return searchValue;
    }

    return searchValue.slice(1,-1);
}

function isLogicalAnd(searchValue) {
    return searchValue.charAt(0) === '"'
        && searchValue.charAt(searchValue.length-1) === '"';
}

function buildLogicalAndQuery() {
    return {
        presence: lunr.Query.presence.REQUIRED
    };
}

function buildQuery(searchValue) {
    if (isLogicalAnd(searchValue)) {
        return buildLogicalAndQuery();
    }

    return {
        wildcard: lunr.Query.wildcard.TRAILING
    }
}

function getQueryWithLeadingAndTrailingWildcards() {
    return {
        wildcard: lunr.Query.wildcard.LEADING | lunr.Query.wildcard.TRAILING
    }
}

function getLogicalAndQueryWithLeadingAndTrailingWildcards() {
    return {
        presence: lunr.Query.presence.REQUIRED,
        wildcard: lunr.Query.wildcard.LEADING | lunr.Query.wildcard.TRAILING
    }
}

function showResults(results) {
    searchResults.innerHTML = '<span class="search-result__close text-gray"><i class="material-icons">close</i></span>';

    if (results.length > 0) {
        results.forEach(result => {
            const endpointSection = document.getElementById(`${result.ref}-section`);
            let resultRow = document.createElement('div');
            resultRow.classList.add('border-bottom');

            const name = getEndpointName(endpointSection);
            const body = getEndpointBody(endpointSection);

            resultRow.innerHTML = `<a href="#${result.ref }" class="search__link py-3 d-block">
                        <p class="font-weight-medium">
                            ${name.textContent.replace(/[.¶]/g, '')} - <span class="text-orange">${endpointSection.dataset.parent}</span>
                        </p>
                        <p>
                            ${getEndpointMethod(endpointSection).outerHTML}
                            ${getEndpointUrl(endpointSection).outerHTML}
                        </p>
                        <p class="mb-0">${body.textContent.trim()}</p>
                    </a>`;

            searchResults.append(resultRow);
            highlight();
        });

        const searchLinks = document.querySelectorAll('.search__link');

        searchLinks.forEach(link => {
            link.addEventListener('click', event =>{
                if (document.body.classList.contains('mobile-menu-expanded')) {
                    document.body.classList.remove('mobile-menu-expanded')
                }

                hideResultsBlock();
            });
        });
    } else {
        searchResults.innerHTML += '<p class="text-gray">No results</p>';
    }
}

function highlight() {
    let words = searchInput.value.replace(/[.*"]/g, '').split(' ');
    $(searchResults).highlight(words);
}

function showResultsBlock() {
    document.body.classList.add('overflow-hidden');
    searchResults.classList.remove('d-none');
}

function hideResultsBlock() {
    document.body.classList.remove('overflow-hidden');
    searchResults.classList.add('d-none');
}

function getEndpointName(section) {
    return section.querySelector('[data-field="name"]');
}

function getEndpointBody(section) {
    return section.querySelector('[data-field="body"]');
}

function getEndpointUrl(section) {
    return section.querySelector('[data-field="url"]');
}

function getEndpointMethod(section) {
    return section.querySelector('[data-field="method"]');
}
