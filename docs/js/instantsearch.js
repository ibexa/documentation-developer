(function (global, doc) {
    const getClearedItem = (item) => {
        const REMOVED_PATTERN = '¶';
        const hierarchy = Object.entries(item.hierarchy).reduce((output, [hierarchyIndex, hierarchy]) => {
            return {
                ...output,
                [hierarchyIndex]: hierarchy?.replace(REMOVED_PATTERN, '') ?? null,
            };
        }, {});
        const highlightResultHierarchy = Object.entries(item._highlightResult.hierarchy).reduce((output, [hierarchyIndex, hierarchy]) => {
            return {
                ...output,
                [hierarchyIndex]: {
                    ...hierarchy,
                    value: hierarchy?.value.replace(REMOVED_PATTERN, '') ?? null,
                },
            };
        }, {});

        return {
            ...item,
            hierarchy,
            _highlightResult: {
                ...item._highlightResult,
                hierarchy: highlightResultHierarchy,
            },
        }
    }
    const search_query = document.location.hash.match(/q=(.*?)(&|$)/)[1] ?? '';
    const parsed_search_query = decodeURI(search_query.replace('+', ' '));
    const search_page = document.location.hash.match(/p=(\d*?)(&|$)/)[1] ?? 1;
    const parsed_search_page = parseInt(search_page);
    const version = document.location.pathname.split('/')[2];
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

    document.getElementById('searchbox').addEventListener('keyup', function (event) {
        window.location.hash = '#q=' + encodeURI(event.target.value) + '&p=1';
    })

    document.getElementById('pagination').addEventListener('click', function (event) {
        let page = document.getElementsByClassName('ais-Pagination-item--selected').length ? parseInt(document.getElementsByClassName('ais-Pagination-item--selected')[0].innerText) : 1
        window.location.hash = window.location.hash.includes('p=') ? window.location.hash.replace(/p=\d*/, 'p=' + page) : window.location.hash + '&p=' + page;
    })

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
            transformItems(items) {
                const outputItemsMap = {};

                items.forEach((item) => {
                    const hierarchy = Object.entries(item.hierarchy).filter(([, value]) => value);
                    const breadcrumbsKeys = hierarchy.map(([key]) => key);
                    const groupNameKey = breadcrumbsKeys.shift();
                    const entryNameKey = breadcrumbsKeys.pop();
                    const newItem = {
                        entryNameKey,
                        breadcrumbsKeys,
                        item: getClearedItem(item),
                    };
                    const groupChildren = outputItemsMap[groupNameKey]?.children ?? [];

                    outputItemsMap[groupNameKey] = {
                        groupNameKey,
                        children: [...groupChildren, newItem],
                    };
                });

                return Object.values(outputItemsMap);
            },
            templates: {
                item: (hit) => {
                    const { groupNameKey, children } = hit;
                    const groupItem = children[0].item;
                    const groupHeaderHTML = `<h2 class="instantsearch__group-header">
                        ${instantsearch.highlight({ attribute: `hierarchy.${groupNameKey}`, highlightedTagName: 'mark', hit: groupItem })}
                        (${children.length})
                    </h2>`;
                    let groupContentHTML = '';

                    console.log(children);

                    children.forEach((childHit) => {
                        const { breadcrumbsKeys, entryNameKey, item: entryItem } = childHit;
                        const headerHTML = `<h3 class="instantsearch__entry-header">
                            ${instantsearch.highlight({ attribute: `hierarchy.${entryNameKey}`, highlightedTagName: 'mark', hit: entryItem })}
                        </h3>`;
                        let breadcrumbsHTML = '';
                        let contentHTML = '';

                        if (entryItem.content) {
                            contentHTML = `<div class="instantsearch__entry-content">
                                ${instantsearch.highlight({ attribute: `content`, highlightedTagName: 'mark', hit: entryItem })}
                            </div>`;
                        }

                        breadcrumbsKeys?.forEach((breadcrumbKey) => {
                            breadcrumbsHTML += `<span class="instantsearch__entry-breadcrumbs-item">
                                ${instantsearch.highlight({ attribute: `hierarchy.${breadcrumbKey}`, highlightedTagName: 'mark', hit: entryItem })}
                            </span>`
                        });

                        const childHTML = `<a class="instantsearch__entry" href="${childHit.item.url}">
                            ${headerHTML}
                            ${contentHTML}
                            <div class="instantsearch__entry-breadcrumbs">
                                ${breadcrumbsHTML}
                            </div>
                        </div>`;

                        groupContentHTML += childHTML;
                    });

                    return `<div class="instantsearch">
                        ${groupHeaderHTML}
                        <div class="instantsearch__group">
                            ${groupContentHTML}
                        </div>
                    </div>`;
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
