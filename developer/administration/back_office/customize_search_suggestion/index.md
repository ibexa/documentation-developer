# Customize search suggestion

Customize search suggestion configuration and sources.

In the back office, when you start typing in the search field on the top bar, suggestions about what you could be looking for show up directly under the field. For more information about using this feature to search for content, see [User Documentation](../../../../user/search/search_for_content/index.md).

## Configuration

By default, suggestions start showing up after the user types in at least 3 characters, and 5 suggestions are presented. This can be changed with the following [scoped](../../../multisite/multisite_configuration/index.md#scope) configuration:

```yaml
ibexa:
    system:
        <scope>:
            search:
                suggestion:
                    min_query_length: 3
                    result_limit: 5
```

## Add custom suggestion source

You can add a suggestion source by listening or subscribing to `Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent`. During this event, you can add, remove, or replace suggestions by updating its `SuggestionCollection`. After this event, the suggestion collection is sorted by score and truncated to a number of items set in [`result_limit`](#configuration).

> **Tip: Tip**
>
> You can list listeners and subscribers with the following command:
>
> ```bash
> php bin/console debug:event BuildSuggestionCollectionEvent
> ```

The following example is boosting product suggestions. It's a subscriber that passes after the default one (because priority is set to zero), adds matching products at a score above the earlier content suggestions, and avoids duplicates.

- If the suggestion source finds a number of matching products that is equal or greater than the `result_limit`, only those products end up in the suggestion.
- If it finds less than `result_limit` products, those products are on top of the suggestion, followed by items from another suggestion source until the limit is met.
- If it doesn't find any matching products, only items from the default suggestion source are shown.

This example event subscriber is implemented in the `src/EventSubscriber/MySuggestionEventSubscriber.php` file. It uses [`ProductService::findProducts`](../../../product_catalog/product_api/index.md#products), and returns the received event after having manipulated the `SuggestionCollection`:

```php
<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\Search\Model\Suggestion\ProductSuggestion;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MySuggestionEventSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(private ProductServiceInterface $productService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BuildSuggestionCollectionEvent::class => ['onBuildSuggestionCollectionEvent', -1],
        ];
    }

    public function onBuildSuggestionCollectionEvent(BuildSuggestionCollectionEvent $event): BuildSuggestionCollectionEvent
    {
        $suggestionQuery = $event->getQuery();
        $suggestionCollection = $event->getSuggestionCollection();

        $text = $suggestionQuery->getQuery();
        $words = explode(' ', (string) preg_replace('/\s+/', ' ', $text));
        $limit = $suggestionQuery->getLimit();

        try {
            $productQuery = new ProductQuery(null, new Criterion\LogicalOr([
                new Criterion\ProductName(implode(' ', array_map(static fn (string $word): string => "$word*", $words))),
                new Criterion\ProductCode($words),
                new Criterion\ProductType($words),
            ]), [], 0, $limit);
            $searchResult = $this->productService->findProducts($productQuery);

            if ($searchResult->getTotalCount()) {
                $maxScore = 0.0;
                $suggestionsByContentIds = [];
                /** @var \Ibexa\Contracts\Search\Model\Suggestion\ContentSuggestion $suggestion */
                foreach ($suggestionCollection as $suggestion) {
                    $maxScore = max($suggestion->getScore(), $maxScore);
                    $suggestionsByContentIds[$suggestion->getContent()->id] = $suggestion;
                }

                /** @var \Ibexa\ProductCatalog\Local\Repository\Values\Product $product */
                foreach ($searchResult as $product) {
                    $contentId = $product->getContent()->id;
                    if (array_key_exists($contentId, $suggestionsByContentIds)) {
                        $suggestionCollection->remove($suggestionsByContentIds[$contentId]);
                    }

                    $productSuggestion = new ProductSuggestion($maxScore + 1, $product);
                    $suggestionCollection->append($productSuggestion);
                }
            }
        } catch (\Throwable $throwable) {
            $this->logger->error($throwable);
        }

        return $event;
    }
}
```

To have the logger injected thanks to the `LoggerAwareTrait`, this subscriber must be registered as a service:

```yaml
services:
    #…
    App\EventSubscriber\MySuggestionEventSubscriber: ~
```

To represent the product suggestion data, a `ProductSuggestion` class is created in `src/Search/Model/Suggestion/ProductSuggestion.php`:

```php
<?php declare(strict_types=1);

namespace App\Search\Model\Suggestion;

use Ibexa\Contracts\Search\Model\Suggestion\Suggestion;
use Ibexa\ProductCatalog\Local\Repository\Values\Product;

class ProductSuggestion extends Suggestion
{
    private readonly Product $product;

    public function __construct(
        float $score,
        Product $product
    ) {
        parent::__construct($score, $product->getName());
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
```

This representation needs a normalizer to be transformed into a JSON. `ProductSuggestionNormalizer::supportsNormalization` returns that this normalizer supports `ProductSuggestion`. `ProductSuggestionNormalizer::normalize` returns an array of scalar values which can be transformed into a JSON object. Alongside data about the product, this array must have a `type` key, whose value is used later for rendering as an identifier. In `src/Search/Serializer/Normalizer/Suggestion/ProductSuggestionNormalizer.php`:

```php
<?php declare(strict_types=1);

namespace App\Search\Serializer\Normalizer\Suggestion;

use App\Search\Model\Suggestion\ProductSuggestion;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductSuggestionNormalizer implements
    NormalizerInterface,
    NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @return array<string, string|null>
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        /** @var \App\Search\Model\Suggestion\ProductSuggestion $object */
        return [
            'type' => 'product',
            'name' => $object->getName(),
            'productCode' => $object->getProduct()->getCode(),
            'productTypeIdentifier' => $object->getProduct()->getProductType()->getIdentifier(),
            'productTypeName' => $object->getProduct()->getProductType()->getName(),
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ProductSuggestion;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ProductSuggestion::class => true,
        ];
    }
}
```

This normalizer is added to suggestion normalizers by decorating `ibexa.search.suggestion.serializer` and redefining its list of normalizers:

```yaml
services:
    #…
    App\Search\Serializer\Normalizer\Suggestion\ProductSuggestionNormalizer:
        autoconfigure: false

    app.search.suggestion.serializer:
        decorates: ibexa.search.suggestion.serializer
        class: Symfony\Component\Serializer\Serializer
        autoconfigure: false
        arguments:
            $normalizers:
                - '@App\Search\Serializer\Normalizer\Suggestion\ProductSuggestionNormalizer'
                - '@Ibexa\Search\Serializer\Normalizer\Suggestion\ContentSuggestionNormalizer'
                - '@Ibexa\Search\Serializer\Normalizer\Suggestion\LocationNormalizer'
                - '@Ibexa\Search\Serializer\Normalizer\Suggestion\ParentLocationCollectionNormalizer'
                - '@Ibexa\Search\Serializer\Normalizer\Suggestion\SuggestionCollectionNormalizer'
            $encoders:
                - '@serializer.encoder.json'
```

> **Tip: Tip**
>
> At this point, it's possible to test the suggestion JSON. The route is `/suggestion` with a GET parameter `query` for the searched text.
>
> For example, log in to the back office to have a session cookie, then access the route through the back office SiteAccess, such as `<yourdomain>/admin/suggestion?query=platform`. If you have a product with "platform" in its name, it is returned as the first suggestion.

A JavaScript renderer displays the normalized product suggestion. This renderer is wrapped in an immediately executed function. This wrapping function must define a rendering function and register it as a renderer. It's registered as `autocomplete.renderers.<type>` by using the type identifier defined in the normalizer.

```javascript
 (function (global, doc, ibexa, Routing) {
     const renderItem = (result, searchText) => {
         // Compute suggestion item's HTML
         return html;
     }
    ibexa.addConfig('autocomplete.renderers.<type>', renderItem, true);
 })(window, document, window.ibexa, window.Routing);
```

To fit into the back office design, you can take HTML structure and CSS class names from an existing suggestion template `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/ui/global_search_autocomplete_content_item.html.twig`.

To allow template override and ease HTML writing, the example is also loading a template to render the HTML.

Here is a complete `assets/js/admin.search.autocomplete.product.js` from the product suggestion example:

```js
(function (global, doc, ibexa, Routing) {
    const renderItem = (result, searchText) => {
        const globalSearch = doc.querySelector('.ibexa-global-search');
        const { highlightText } = ibexa.helpers.highlight;
        const autocompleteHighlightTemplate = globalSearch.querySelector('.ibexa-global-search__autocomplete-list').dataset
            .templateHighlight;
        const { getContentTypeIconUrl, getContentTypeName } = ibexa.helpers.contentType;

        const autocompleteItemTemplate = globalSearch.querySelector('.ibexa-global-search__autocomplete-product-template').dataset
            .templateItem;

        return autocompleteItemTemplate
            .replace('{{ productHref }}', Routing.generate('ibexa.product_catalog.product.view', { productCode: result.productCode }))
            .replace('{{ productName }}', highlightText(searchText, result.name, autocompleteHighlightTemplate))
            .replace('{{ productCode }}', result.productCode)
            .replace('{{ productTypeIconHref }}', getContentTypeIconUrl(result.productTypeIdentifier))
            .replace('{{ productTypeName }}', result.productTypeName);
    };

    ibexa.addConfig('autocomplete.renderers.product', renderItem, true);
})(window, document, window.ibexa, window.Routing);
```

To be loaded in the back office layout, this file must be added to Webpack entry `ibexa-admin-ui-layout-js`. At the end of `webpack.config.js`, add it by using `ibexaConfigManager`:

```javascript
//…
const ibexaConfigManager = require('./ibexa.webpack.config.manager.js');

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [path.resolve(__dirname, './assets/js/admin.search.autocomplete.product.js')],
});
```

The renderer, `renderItem` function from `admin.search.autocomplete.product.js`, loads an HTML template from a wrapping DOM node [dataset](https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset). This wrapping node exists only once and the renderer loads the template several times.

The example template for this wrapping node is stored in `templates/themes/admin/ui/global_search_autocomplete_product_template.html.twig` (notice the CSS class name used by the renderer to reach it):

```html+twig
<div
    class="ibexa-global-search__autocomplete-product-template"
    data-template-item="{{ include('@ibexadesign/ui/global_search_autocomplete_product_item.html.twig', {
        product_href: "{{ productHref }}",
        product_name: "{{ productName }}",
        product_code: "{{ productCode }}",
        product_type_icon_href: "{{ productTypeIconHref }}",
        product_type_name: "{{ productTypeName }}"
    })|e('html_attr') }}">
</div>
```

- At HTML level, it wraps the product item template in its dataset attribute `data-template-item`.
- At Twig level, it includes the item template, replaces Twig variables with the strings used by the JS renderer, and passes it to the [`escape` filter](https://twig.symfony.com/doc/3.x/filters/escape.html) with the HTML attribute strategy.

To be present, this wrapping node template must be added to the `admin-ui-global-search-autocomplete-templates` group of tabs components:

```yaml
services:
    #…
    ibexa.search.autocomplete.product_template:
        parent: Ibexa\AdminUi\Component\TabsComponent
        arguments:
            $template: '@@ibexadesign/ui/global_search_autocomplete_product_template.html.twig'
            $groupIdentifier: 'global-search-autocomplete-product'
        tags:
            - { name: ibexa.twig.component, group: global-search-autocomplete-templates }
```

The template for the product suggestion item follows, named `templates/themes/admin/ui/global_search_autocomplete_product_item.html.twig`:

```html+twig
<li class="ibexa-global-search__autocomplete-item">
    <a class="ibexa-global-search__autocomplete-item-link ibexa-link" href="{{ product_href }}">
        <div class="ibexa-global-search__autocomplete-item-name">
            {{ product_name }}
            <div class="ibexa-badge">
                {{ product_code }}
            </div>
        </div>
        <div class="ibexa-global-search__autocomplete-item-info">
            <div class="ibexa-global-search__autocomplete-item-content-type-wrapper">
                <svg class="ibexa-icon ibexa-icon--tiny-small">
                    <use xlink:href="{{ product_type_icon_href }}"></use>
                </svg>
                <span  class="ibexa-global-search__autocomplete-item-content-type">
                    {{ product_type_name }}
                </span>
            </div>
        </div>
    </a>
</li>
```

## Replace default suggestion source

To replace the default suggestion source, [decorate](https://symfony.com/doc/7.4/service_container/decoration.html) the built-in `ContentSuggestionSubscriber` subscriber with your own:

```yaml
services:
    #…
    App\EventSubscriber\MySuggestionEventSubscriber:
        decorates: Ibexa\Search\EventDispatcher\EventListener\ContentSuggestionSubscriber
```
