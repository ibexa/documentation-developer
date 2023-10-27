(function (global, doc, ibexa) {
    global.addEventListener('load', (event) => {
        const richtext = new ibexa.BaseRichText();

        // Enable editor in all ibexa-data-source divs
        doc.querySelectorAll('.ibexa-data-source').forEach(
            (ibexaDataSource) => {
                const richtextContainer = ibexaDataSource.querySelector(
                    '.ibexa-data-source__richtext'
                );

                if (richtextContainer.classList.contains('ck')) {
                    return;
                }

                const CKEditor = richtext.init(richtextContainer);
            }
        );
    });
})(window, window.document, window.ibexa);
