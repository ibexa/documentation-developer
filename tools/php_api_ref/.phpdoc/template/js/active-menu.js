(function(global, doc) {
    const fullPath = doc.location.pathname.split('/');
    const pageUrl = fullPath.slice(-2).join('/');
    let activeElement = doc.querySelector(`a[href="${pageUrl}"]`);

    activeElement = activeElement?.closest('.md-nav__item')?.querySelector('.md-nav__toggle');

    while(activeElement) {
        const navItem = activeElement.closest('.md-nav__item');

        activeElement.checked = true;

        if (navItem) {
            navItem.classList.add('md-nav__item--active');

            activeElement = navItem.closest('.md-nav').closest('.md-nav__item')?.querySelector('.md-nav__toggle');
        }
    }
})(window, window.document);
