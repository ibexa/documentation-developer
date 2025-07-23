(function (global, doc) {
    const filtersContainer = doc.querySelector('.release-notes-filters');

    if (!filtersContainer) {
        return;
    }

    const filterItemsWidget = filtersContainer.querySelector('.release-notes-filters__widget');
    const filterItemsBtn = filterItemsWidget.querySelector('.release-notes-filters__btn');
    const filterItemsBtnIcon = filterItemsBtn.querySelector('.release-notes-filters__btn-icon');
    const filterItemsContainer = filterItemsWidget.querySelector('.release-notes-filters__items');
    const filterItems = filterItemsContainer.querySelectorAll('.release-notes-filters__item input[type="checkbox"]');
    const visibleItemsContainer = filtersContainer.querySelector('.release-notes-filters__visible-items');
    const visibleItems = visibleItemsContainer.querySelectorAll('.release-notes-filters__visible-item');
    const releaseNotesNodes = doc.querySelectorAll('.release-note');
    const releaseNotesItems = [...releaseNotesNodes].map((releaseNotesNode) => {
        const tagsNodes = releaseNotesNode.querySelectorAll('.release-note__tags .pill');
        const tagsItems = [...tagsNodes].map((tagNode) => `filter-${tagNode.dataset.filter}`);

        return {
            node: releaseNotesNode,
            tags: tagsItems,
        };
    });
    const handleClickOutside = ({ target }) => {
        if (filterItemsWidget.contains(target)) {
            return;
        }

        filterItemsWidget.classList.toggle('release-notes-filters__widget--expanded', false);
        removeClickOutsideEventListener();
    };
    const addClickOutsideEventListener = () => {
        doc.body.addEventListener('click', handleClickOutside, false);
    };
    const removeClickOutsideEventListener = () => {
        doc.body.removeEventListener('click', handleClickOutside, false);
    };

    filterItemsBtn.addEventListener('click', () => {
        filterItemsWidget.classList.toggle('release-notes-filters__widget--expanded');
        addClickOutsideEventListener();
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
            filterItemsBtnIcon.classList.toggle('release-notes-filters__btn-icon--selected', checkedItems.length > 0);
        }, false);
    });

    visibleItems.forEach((visibleItem) => {
        const visibleItemsRemoveBtn = visibleItem.querySelector('.release-notes-filters__visible-item-remove');
        const tagName = visibleItem.dataset.filter;

        visibleItemsRemoveBtn.addEventListener('click', () => {
            const itemCheckbox = filterItemsContainer.querySelector(`#${tagName}`);

            itemCheckbox.click();
        });
    });

})(window, window.document);
