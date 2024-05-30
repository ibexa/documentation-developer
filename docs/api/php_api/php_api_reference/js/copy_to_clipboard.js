(function(global, doc, navigator) {
    const copyBtns = doc.querySelectorAll('.copy-to-clipboard');

    copyBtns.forEach((copyBtn) => {
        copyBtn.addEventListener('click', (event) => {
            navigator.clipboard.writeText(event.target.dataset.copyValue);
        });
    });
})(window, window.document, window.navigator);
