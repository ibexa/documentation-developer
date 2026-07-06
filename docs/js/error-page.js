(function (global, doc) {
    const errorPageContainer = doc.querySelector('.page-not-found');

    if (!errorPageContainer) {
        return;
    }

    // Find the correct version
    let currentVersion = '6.0';
    const branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        currentVersion = branchNameRegexp[1];
    }

    // Replace all links in the TOC and in the error page content
    doc.querySelectorAll('.md-sidebar--primary .md-nav__item a, .page-not-found a').forEach(link => {
        link.href = link.href.replace(/\/en\/([a-z0-9-_.]*)\//, `/en/${currentVersion}/`);
    });

    // Use the 404 URL path in initial search query
    const searchLink = document.querySelector('#search-link');
    const suffix = window.location.href.split('/en/' + currentVersion + '/')[1];

    const searchQuery = suffix.replaceAll('/', ' ').replaceAll('_', ' ');
    searchLink.href = searchLink.href.replace('?sq=', '?sq=' + encodeURIComponent(searchQuery));

})(window, window.document);
