(function (global, doc) {
    const btnDown = doc.querySelector('.ibexa-welcome-header__go-down');

    btnDown.addEventListener('click', () => {
        const header = doc.querySelector('.ibexa-welcome-header');

        global.scrollTo({
            top: header.offsetHeight,
            behavior: 'smooth',
        });
    });
})(window, document);
