(function (global, doc) {
    let match;
    const search_query = (match = doc.location.search.match(/sq=(.*?)(&|$)/)) ? match[1] : '';
    const parsed_search_query = decodeURI(search_query.replaceAll('+', ' '));
    const search_page = (match = doc.location.search.match(/p=(\d*?)(&|$)/)) ? match[1] : 1;
    const parsed_search_page = parseInt(search_page);
    let version = doc.location.pathname.split('/')[2];
    if (!/^\d+\.\d+$/.test(version) && version !== 'latest') {
        version = 'master';
    }
    const search = instantsearch({
        indexName: 'ezplatform',
        searchClient: algoliasearch('2DNYOU6YJZ', '21ce3e522455e18e7ee16cf7d66edb4b'),
        initialUiState: {
            ezplatform: {
                query: parsed_search_query,
                refinementList: {version: [version]},
                page: parsed_search_page,
            },
        },
    });

    doc.getElementById('searchbox').addEventListener('keyup', function (event) {
        const url = new URL(window.location);
        url.searchParams.set('sq', event.target.value.trim());
        if (url.href != window.location.href) {
            url.searchParams.set('p', 1);
            window.history.pushState({}, '', url);
        }
    })

    doc.getElementById('pagination').addEventListener('click', function (event) {
        const page = doc.getElementsByClassName('ais-Pagination-item--selected').length ? parseInt(doc.getElementsByClassName('ais-Pagination-item--selected')[0].innerText) : 1
        const url = new URL(window.location);
        url.searchParams.set('p', page);
        window.history.pushState({}, '', url);
    })

    window.onpopstate = (event) => {
        window.location.reload();
    };

    search.addWidgets([
        instantsearch.widgets.configure({
            hitsPerPage: 10,
        }),
        instantsearch.widgets.stats({
            container: '#stats',
            templates: {
                text: `<h1>
                Search results ({{#helpers.formatNumber}}{{nbHits}}{{/helpers.formatNumber}})
            </h1>`,
            },
        }),
        instantsearch.widgets.searchBox({
            container: '#searchbox',
        }),
        instantsearch.widgets.hits({
            container: '#hits',
            templates: {
                item: (hit) => {
                    const hierarchy = Object.entries(hit.hierarchy).filter(([, value]) => value);
                    const breadcrumbsKeys = hierarchy.map(([key]) => key);
                    const entryNameKey = breadcrumbsKeys.pop();

                    const headerHTML = `<h3 class="instantsearch__entry-header">
                        ${instantsearch.highlight({
                            attribute: `hierarchy.${entryNameKey}`,
                            highlightedTagName: 'mark',
                            hit: hit
                        })}
                    </h3>`;

                    let breadcrumbsHTML = '';
                    let contentHTML = '';

                    if (hit.content && hit._highlightResult.content.matchedWords.length && (!hit._highlightResult.content.fullyHighlighted || 1 < hit._highlightResult.content.matchedWords.length)) {
                        contentHTML = `<div class="instantsearch__entry-content">
                            ${instantsearch.highlight({
                                attribute: `content`,
                                highlightedTagName: 'mark',
                                hit: hit
                            }).replaceAll('&amp;', '&')}
                        </div>`;
                    }

                    breadcrumbsKeys?.forEach((breadcrumbKey) => {
                        breadcrumbsHTML += `<span class="instantsearch__entry-breadcrumbs-item">
                            ${instantsearch.highlight({
                                attribute: `hierarchy.${breadcrumbKey}`,
                                highlightedTagName: 'mark',
                                hit: hit
                            })}
                        </span>`
                    });

                    return resultHTML = `<a class="instantsearch__entry" href="${hit.url}">
                        <div class="instantsearch__entry-breadcrumbs">
                            ${breadcrumbsHTML}
                        </div>
                        ${headerHTML}
                        ${contentHTML}
                    </a>`;
                },
            },
        }),
        instantsearch.widgets.pagination({
            container: '#pagination',
            padding: 2,
            templates: {
                first: `<svg class="tile-icon" width="16" height="16">
                    <use fill="var(--ibexa-dusk-black)" xlink:href="../images/ez-icons.svg#caret-double-back"></use>
                </svg>`,
                previous: `<svg class="tile-icon" width="20" height="20">
                    <use fill="var(--ibexa-dusk-black)" xlink:href="../images/ez-icons.svg#caret-back"></use>
                </svg>`,
                next: `<svg class="tile-icon" width="20" height="20">
                    <use fill="var(--ibexa-dusk-black)" xlink:href="../images/ez-icons.svg#caret-next"></use>
                </svg>`,
                last: `<svg class="tile-icon" width="16" height="16">
                    <use fill="var(--ibexa-dusk-black)" xlink:href="../images/ez-icons.svg#caret-double-next"></use>
                </svg>`,
            },
        }),
        instantsearch.widgets.refinementList({
            container: document.querySelector('#version'),
            attribute: 'version',
        }),
    ]);

    search.start();
})(window, window.document);
