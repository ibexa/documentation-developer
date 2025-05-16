---
description: Customize search suggestion configuration and sources.
---

# Customize search suggestion

In the back office, when you start typing in the search field on the top bar, suggestions about what you could be looking for show up directly under the field.
For more information about using this feature to search for content, see [User Documentation]([[= user_doc =]]/search/search_for_content/).

## Configuration

By default, suggestions start showing up after the user types in at least 3 characters, and 5 suggestions are presented.
This can be changed with the following [scoped](multisite_configuration.md#scope) configuration:

```yaml
ibexa:
    system:
        <scope>:
            search:
                min_query_length: 3
                result_limit: 5
```

## Add custom suggestion source

You can add a suggestion source by listening or subscribing to `Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent`.
During this event, you can add, remove, or replace suggestions by updating its `SuggestionCollection`.
After this event, the suggestion collection is sorted by score and truncated to a number of items set in [`result_limit`](#configuration).

!!! tip

    You can list listeners and subscribers with the following command:

    ``` shell
    php bin/console debug:event BuildSuggestionCollectionEvent
    ```

The following example is boosting product suggestions.
It's a subscriber that passes after the default one (because priority is set to zero), adds matching products at a score above the earlier content suggestions, and avoids duplicates.

- If the suggestion source finds a number of matching products that is equal or greater than the `result_limit`, only those products end up in the suggestion.
- If it finds less than `result_limit` products, those products are on top of the suggestion, followed by items from another suggestion source until the limit is met.
- If it doesn't find any matching products, only items from the default suggestion source are shown.

This example event subscriber is implemented in the `src/EventSubscriber/MySuggestionEventSubscriber.php` file.
It uses [`ProductService::findProducts`](product_api.md#products), and returns the received event after having manipulated the `SuggestionCollection`:

``` php
[[= include_file('code_samples/back_office/search/src/EventSubscriber/MySuggestionEventSubscriber.php') =]]
```

To have the logger injected thanks to the `LoggerAwareTrait`, this subscriber must be registered as a service:

``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 2, 3) =]]
```

To represent the product suggestion data, a `ProductSuggestion` class is created in `src/Search/Model/Suggestion/ProductSuggestion.php`:

``` php
[[= include_file('code_samples/back_office/search/src/Search/Model/Suggestion/ProductSuggestion.php') =]]
```

This representation needs a normalizer to be transformed into a JSON.
`ProductSuggestionNormalizer::supportsNormalization` returns that this normalizer supports `ProductSuggestion`.
`ProductSuggestionNormalizer::normalize` returns an array of scalar values which can be transformed into a JSON object.
Alongside data about the product, this array must have a `type` key, whose value is used later for rendering as an identifier.
In `src/Search/Serializer/Normalizer/Suggestion/ProductSuggestionNormalizer.php`:

``` php
[[= include_file('code_samples/back_office/search/src/Search/Serializer/Normalizer/Suggestion/ProductSuggestionNormalizer.php') =]]
```

This normalizer is added to suggestion normalizers by decorating `ibexa.search.suggestion.serializer` and redefining its list of normalizers:

``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 4, 20) =]]
```

!!! tip

    At this point, it's possible to test the suggestion JSON.
    The route is `/suggestion` with a GET parameter `query` for the searched text.

    For example, log in to the back office to have a session cookie, then access the route through the back office SiteAccess, such as `<yourdomain>/admin/suggestion?query=platform`.
    If you have a product with "platform" in its name, it is returned as the first suggestion.

A JavaScript renderer displays the normalized product suggestion.
This renderer is wrapped in an immediately executed function.
This wrapping function must define a rendering function and register it as a renderer.
It's registered as `autocomplete.renderers.<type>` by using the type identifier defined in the normalizer.

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

``` js hl_lines="9"
[[= include_file('code_samples/back_office/search/assets/js/admin.search.autocomplete.product.js') =]]
```

To be loaded in the back office layout, this file must be added to Webpack entry `ibexa-admin-ui-layout-js`.
At the end of `webpack.config.js`, add it by using `ibexaConfigManager`:

``` javascript
//…
[[= include_file('code_samples/back_office/search/append_to_webpack.config.js') =]]
```

The renderer, `renderItem` function from `admin.search.autocomplete.product.js`, loads an HTML template from a wrapping DOM node [dataset](https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset).
This wrapping node exists only once and the renderer loads the template several times.

The example template for this wrapping node is stored in `templates/themes/admin/ui/global_search_autocomplete_product_template.html.twig` (notice the CSS class name used by the renderer to reach it):

``` html+twig hl_lines="2 3 9"
[[= include_file('code_samples/back_office/search/templates/themes/admin/ui/global_search_autocomplete_product_template.html.twig') =]]
```

- At HTML level, it wraps the product item template in its dataset attribute `data-template-item`.
- At Twig level, it includes the item template, replaces Twig variables with the strings used by the JS renderer,
  and passes it to the [`escape` filter](https://twig.symfony.com/doc/3.x/filters/escape.html) with the HTML attribute strategy.

To be present, this wrapping node template must be added to the `admin-ui-global-search-autocomplete-templates` group of tabs components:

``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 21, 28) =]]
```

The template for the product suggestion item follows, named `templates/themes/admin/ui/global_search_autocomplete_product_item.html.twig`:

``` html+twig
[[= include_file('code_samples/back_office/search/templates/themes/admin/ui/global_search_autocomplete_product_item.html.twig') =]]
```

## Replace default suggestion source

To replace the default suggestion source, [decorate]([[= symfony_doc =]]/service_container/service_decoration.html) the built-in `BuildSuggestionCollectionEvent` subscriber with your own:

```yaml
services:
    #…
    App\EventSubscriber\MySuggestionEventSubscriber:
        decorates: Ibexa\Search\EventDispatcher\EventListener\ContentSuggestionSubscriber
```
