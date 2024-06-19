(function(global, doc, location, history) {
    let hasScrolled = false;
    const toc = doc.querySelector('[data-md-component="toc"]');
    const currentPath = location.href.replace(doc.baseURI, '').split('#')[0];

    if (!toc) {
        return;
    }

    const tocEntries = toc.querySelectorAll('.md-nav__link');
    const anchorElements = [...tocEntries].map((tocEntry) => {
        const [, anchorId] = tocEntry.href.split('#');
        const anchorElement = doc.getElementById(anchorId);
        
        anchorElement.tocEntry = tocEntry;

        return anchorElement;
    });
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                entry.target.tocEntry.classList.toggle('md-nav__link--visible', entry.isIntersecting);
            });

            const firstVisibleTocEntry = toc.querySelector('.md-nav__link--visible');
            const activeTocEntry = toc.querySelector('.md-nav__link--active');
            const [, anchorId] = firstVisibleTocEntry.href.split('#');

            activeTocEntry?.classList.remove('md-nav__link--active');
            firstVisibleTocEntry.classList.add('md-nav__link--active');

            if (hasScrolled) {
                history.pushState(null, null, `${currentPath}#${anchorId}`);
            }
        },
        { threshold: 0.5 }
    );
    
    anchorElements.forEach((anchorElement) => {
        observer.observe(anchorElement);
    });

    doc.addEventListener('scroll', () => {
        hasScrolled = true;
    });
})(window, window.document, window.location, window.history);
