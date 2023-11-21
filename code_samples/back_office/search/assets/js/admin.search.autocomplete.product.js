(function (global, doc, ibexa, Routing) {
    const renderItem = (result, searchText) => {
        const globalSearch = doc.querySelector('.ibexa-global-search');
        const {highlightText} = ibexa.helpers.highlight;
        const autocompleteHighlightTemplate = globalSearch.querySelector('.ibexa-global-search__autocomplete-list').dataset.templateHighlight;
        const {getContentTypeIconUrl, getContentTypeName} = ibexa.helpers.contentType;

        const template = `
<li class="ibexa-global-search__autocomplete-item">
    <a class="ibexa-global-search__autocomplete-item-link ibexa-link" href="{{ productHref }}">
        <div class="ibexa-global-search__autocomplete-item-name">
            {{ productName }}
            <div class="ibexa-badge">
                {{ productCode }}
            </div>
        </div>
        <div class="ibexa-global-search__autocomplete-item-info">
            <div class="ibexa-global-search__autocomplete-item-content-type-wrapper">
                <svg class="ibexa-icon ibexa-icon--tiny-small">
                    <use xlink:href="{{ productTypeIconHref }}"></use>
                </svg>
                <span  class="ibexa-global-search__autocomplete-item-content-type">
                    {{ productTypeName }}
                </span>
            </div>
        </div>
    </a>
</li>
`;

        return template
            .replace('{{ productHref }}', Routing.generate('ibexa.product_catalog.product.view', {productCode: result.productCode}))
            .replace('{{ productName }}', highlightText(searchText, result.name, autocompleteHighlightTemplate))
            .replace('{{ productCode }}', result.productCode)
            .replace('{{ productTypeIconHref }}', getContentTypeIconUrl(result.productTypeIdentifier))
            .replace('{{ productTypeName }}', result.productTypeName);
    };

    ibexa.addConfig('autocomplete.renderers.product', renderItem, true);
})(window, document, window.ibexa, window.Routing);
