(function (global, doc) {
    const filtersWidget = doc.querySelector('.release-notes-filters');

    if (!filtersWidget) {
        return;
    }

    const filterItemsContainer = filtersWidget.querySelector('.release-notes-filters__items');
    const filterItems = filterItemsContainer.querySelectorAll('.release-notes-filters__item input[type="checkbox"]');
    const visibleItemsContainer = filtersWidget.querySelector('.release-notes-filters__visible-items');
    const visibleItems = visibleItemsContainer.querySelectorAll('.release-notes-filters__visible-item');
    const releaseNotesNodes = doc.querySelectorAll('.release-note');
    const releaseNotesItems = [...releaseNotesNodes].map((releaseNotesNode) => {
        const tagsNodes = releaseNotesNode.querySelectorAll('.release-note__tag');
        const tagsItems = [...tagsNodes].map((tagNode) => `filter-${tagNode.dataset.filter}`);

        return {
            node: releaseNotesNode,
            tags: tagsItems,
        };
    });

    filterItems.forEach((filterItem) => {
        filterItem.addEventListener('change', () => {
            const checkedItems = [...filterItems].filter(({ checked }) => checked).map(({ id }) => id);

            releaseNotesItems.forEach(({ node, tags }) => {
                const isVisible = checkedItems.length === 0 || tags.some((tag) => checkedItems.includes(tag));

                node.classList.toggle('release-note--hidden', !isVisible);
            });
            visibleItems.forEach((visibleItem) => {
                const isVisible = checkedItems.includes(visibleItem.dataset.filter);

                visibleItem.classList.toggle('release-notes-filters__visible-item--hidden', !isVisible);
            });
        }, false);
    });

    visibleItems.forEach((visibleItem) => {
        const visibleItemsRemoveBtn = visibleItem.querySelector('.release-notes-filters__visible-item-remove');
        const tagName = visibleItem.dataset.filter;

        visibleItemsRemoveBtn.addEventListener('click', () => {
            const itemCheckbox = filterItemsContainer.querySelector(`#${tagName}`);

            itemCheckbox.click();
        });
    })

})(window, window.document);
