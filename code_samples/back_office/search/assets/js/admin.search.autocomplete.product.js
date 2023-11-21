(function (global, doc, ibexa, Routing) {
    const renderItem = (result, searchText) => {
        const globalSearch = doc.querySelector('.ibexa-global-search');
        const {highlightText} = ibexa.helpers.highlight;
        const autocompleteHighlightTemplate = globalSearch.querySelector('.ibexa-global-search__autocomplete-list').dataset.templateHighlight;
        const {getContentTypeIconUrl, getContentTypeName} = ibexa.helpers.contentType;

        const autocompleteItemTemplate = globalSearch.querySelector('.ibexa-global-search__autocomplete-product-template').dataset.templateItem;

        return autocompleteItemTemplate
            .replace('{{ productHref }}', Routing.generate('ibexa.product_catalog.product.view', {productCode: result.productCode}))
            .replace('{{ productName }}', highlightText(searchText, result.name, autocompleteHighlightTemplate))
            .replace('{{ productCode }}', result.productCode)
            .replace('{{ productTypeIconHref }}', getContentTypeIconUrl(result.productTypeIdentifier))
            .replace('{{ productTypeName }}', result.productTypeName);
    };

    ibexa.addConfig('autocomplete.renderers.product', renderItem, true);
})(window, document, window.ibexa, window.Routing);
