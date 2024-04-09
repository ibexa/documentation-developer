(function(global, doc, location){
    const toc = doc.querySelector('[data-md-component="toc"]');
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

            location.hash = anchorId;
        },
        { threshold: 0.5 }
    );
    
    anchorElements.forEach((anchorElement) => {
        observer.observe(anchorElement);
    });
})(window, window.document, window.location);
