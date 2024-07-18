(function (doc) {
    const CLASS_EXPANDED_LIST = 'switcher__selected-item--expanded';
    const switchers = doc.querySelectorAll('.switcher');
    const toggleListExpandedState = (event) => {
        event.currentTarget.classList.toggle(CLASS_EXPANDED_LIST);
    };
    const collapseList = (event, switcher, selectedItem) => {
        if (!switcher.contains(event.target)) {
            selectedItem.classList.remove(CLASS_EXPANDED_LIST);
        }
    };
    const initSwitcher = (switcher) => {
        const selectedItem = switcher.querySelector('.switcher__selected-item');

        if (!selectedItem) {
            return;
        }

        selectedItem.addEventListener('click', toggleListExpandedState, false);

        doc.body.addEventListener('click', (event) => collapseList(event, switcher, selectedItem), false);
    }

    switchers.forEach(initSwitcher);

    doc.addEventListener('switcher-added', (event) => {
        initSwitcher(event.detail.switcher);
    });
})(window.document);
