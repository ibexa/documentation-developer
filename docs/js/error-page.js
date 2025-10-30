(function (global, doc) {
    const errorPageContainer = doc.querySelector('.page-not-found');

    if (!errorPageContainer) {
        return;
    }

    // Replace all TOC links with the correct version
    let currentVersion = '5.0';
    const branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        currentVersion = branchNameRegexp[1];
    }

    doc.querySelectorAll('.md-sidebar--primary .md-nav__item a, .page-not-found a').forEach(link => {
        link.href = link.href.replace(/\/en\/([a-z0-9-_.]*)\//, `/en/${currentVersion}/`);
    });

})(window, window.document);
