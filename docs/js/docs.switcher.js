(function (doc) {
    const switchers = doc.querySelectorAll('.ez-docs-switcher');
    const toggleListExpandedState = (event) => {
        event.currentTarget.classList.toggle('ez-docs-switcher__selected-item--expanded');
    };

    switchers.forEach((switcher) => {
        const selectedItem = switcher.querySelector('.ez-docs-switcher__selected-item');

        selectedItem.addEventListener('click', toggleListExpandedState, false);
    });
})(window.document);
