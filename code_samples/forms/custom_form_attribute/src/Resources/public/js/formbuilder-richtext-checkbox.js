(function (global, doc, eZ) {
    global.addEventListener('load', (event) => {
        const richtext = new eZ.BaseRichText();

        // Enable editor in all ez-data-source divs
        doc.querySelectorAll('.ez-data-source').forEach(
            (ezDataSource) => {
                const richtextContainer = ezDataSource.querySelector(
                    '.ez-data-source__richtext'
                );

                if (!richtextContainer || richtextContainer.hasAttribute('contenteditable')) {
                    return;
                }

                const CKEditor = richtext.init(richtextContainer);
            }
        );
    });
})(window, window.document, window.eZ);