(function(global, doc, eZ, $) {
    const richtext       = new global.eZ.BaseRichText();

    // Enable editor in all ez-data-source divs
    doc.querySelectorAll('.ez-data-source').forEach((ezDataSource) => {
        const richtextContainer = ezDataSource.querySelector(".ez-data-source__richtext");
        const alloyEditor    = richtext.init(richtextContainer);
    });
})(window, window.document, window.eZ, window.jQuery);