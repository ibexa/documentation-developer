(function(global, doc, ibexa) {
    const richtext       = new ibexa.BaseRichText();

    // Enable editor in all ibexa-data-source divs
    doc.querySelectorAll('.ibexa-data-source').forEach((ibexaDataSource) => {
        const richtextContainer = ibexaDataSource.querySelector(".ibexa-data-source__richtext");
        const alloyEditor    = richtext.init(richtextContainer);
    });
})(window, window.document, window.ibexa);
