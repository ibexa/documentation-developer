function setSwitcherEvents() {
    const CLASS_EXPANDED_LIST = 'switcher__selected-item--expanded';
    const switchers = window.document.querySelectorAll('.switcher');
    const toggleListExpandedState = (event) => {
        event.currentTarget.classList.toggle(CLASS_EXPANDED_LIST);
    };
    const collapseList = (event, switcher, selectedItem) => {
        if (!switcher.contains(event.target)) {
            selectedItem.classList.remove(CLASS_EXPANDED_LIST);
        }
    };

    switchers.forEach((switcher) => {
        const selectedItem = switcher.querySelector('.switcher__selected-item');

        selectedItem.addEventListener('click', toggleListExpandedState, false);

        window.document.body.addEventListener('click', (event) => collapseList(event, switcher, selectedItem), false);
    });
};
