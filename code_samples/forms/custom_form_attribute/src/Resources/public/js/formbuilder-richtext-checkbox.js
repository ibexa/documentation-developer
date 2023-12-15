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

                richtext.init(richtextContainer);
            }
        );
    });

    const openUdw = (config) => {
        const openUdwEvent = new CustomEvent('ez-open-udw', { detail: config });

        doc.body.dispatchEvent(openUdwEvent);
    };

    eZ.addConfig('richText.alloyEditor.callbacks.selectContent', openUdw);
})(window, window.document, window.eZ);