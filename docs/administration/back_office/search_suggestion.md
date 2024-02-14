---
description: Customize search suggestion configuration and sources.
---

# Customize search suggestion

In the Back Office, when typing some text in the search bar, some suggestions about what you could be looking for are made directly under this bar. See [user documentation about content search]([[= user_doc =]]/search/search_for_content) for feature usage.

## Configuration

By default, the suggestions start to be made when the typed text is at least 3 characters long, and 5 suggestions are made.
This can be changed with [SiteAccess aware dynamic configuration](dynamic_configuration.md) by setting the following [scoped](multisite_configuration.md#scope) parameters:

```yaml
parameters:
    ibexa.site_access.config.<scope>.search.suggestion.min_query_length: 3
    ibexa.site_access.config.<scope>.search.suggestion.result_limit: 5
```

## Add custom suggestion source

You can add a suggestion source by listening or subscribing to the `Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent`.
During this event, you can add, remove, or replace suggestions by updating its `SuggestionCollection`.
After this event, the suggestion collection is sorted by score and truncated to [`result_limit`](#configuration) items.

!!! tip

    You can list listeners and subscribers with the following command:
    ``` shell
    php bin/console debug:event BuildSuggestionCollectionEvent
    ```

The following example is boosting Product suggestions.
It's a subscriber passing after the default one (thanks to a priority below zero), adding matching products at a score above the earlier Content suggestions, and avoiding duplicates.

- If this suggestion source find a count of `result_limit` matching products or more, there is only those products in the suggestion.
- If it finds less than `result_limit` products, those products are on top of the suggestion followed by other suggestion source items to reach the limit.
- If it doesn't find any matching product, only default source suggestion is shown.

This example event subscriber is implemented in the file `src/EventSubscriber/MySuggestionEventSubscriber.php`, uses [`ProductService::findProducts`](product_api.md#products), and return the received event after having manipulated it `SuggestionCollection`:
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

This representation need a normalizer to be transformed into JSON.
`ProductSuggestionNormalizer::supportsNormalization` associates with `ProductSuggestion`.
`ProductSuggestionNormalizer::normalize` return an array of scalar values which can be transformed into a JSON object.
Alongside data about the product, this array must have a `type` key which value is an identifier used later for rendering.
In `src/Search/Serializer/Normalizer/Suggestion/ProductSuggestionNormalizer.php`:

``` php
[[= include_file('code_samples/back_office/search/src/Search/Serializer/Normalizer/Suggestion/ProductSuggestionNormalizer.php') =]]
```

This normalizer is added to suggestion normalizers by decorating `ibexa.search.suggestion.serializer` and redefining its list of normalizers:

``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 4, 19) =]]
```

!!! tip

    At this point, it's possible to test the suggestion JSON.
    The route is `/suggestion` with a `query` GET parameter worth the searched text.

    For example, log in your Back Office to have a session cookie, then access to the route through the Back Office siteaccess, such as `http://localhost/admin/suggestion?query=platform`.
    If you have product with "platform" in its name, it will be the first suggestion.

A JavaScript renderer displays the normalized product suggestion.
This renderer is wrapped in function immediately executed.
This wrapping function must define a rendering function and register it as a renderer.
It's registered as `autocomplete.renderers.<type>` using the type identifier defined in the normalizer.

```javascript
 (function (global, doc, ibexa, Routing) {
     const renderItem = (result, searchText) => {
         // Compute suggestion item's HTML
         return html;
     }
    ibexa.addConfig('autocomplete.renderers.<type>', renderItem, true);
 })(window, document, window.ibexa, window.Routing);
```

To fit into the Back Office design, you can take HTML structure and CSS class names from existing suggestion template `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/ui/global_search_autocomplete_content_item.html.twig`.

To allow template override and ease HTML writing, the example is also loading a template to render the HTML.

Here is the complete `assets/js/admin.search.autocomplete.product.js`from the product suggestion example:

``` js hl_lines="8"
[[= include_file('code_samples/back_office/search/assets/js/admin.search.autocomplete.product.js') =]]
```

To be loaded in Back Office layout, this file must be added to Webpack entry `ibexa-admin-ui-layout-js`. At the end of `webpack.config.js`, add it by using the `ibexaConfigManager`:

``` javascript
//…
[[= include_file('code_samples/back_office/search/append_to_webpack.config.js') =]]
```

The renderer, `admin.search.autocomplete.product.js`' `renderItem` function, loads an HTML template from a wrapping DOM node [dataset](https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset).
This wrapping node exists only once and the renderer loads the template several times.

The example template for this wrapping node is stored in `templates/themes/admin/ui/global_search_autocomplete_product_template.html.twig` (notice the CSS class name used by the renderer to reach it):

``` html+twig hl_lines="2 3 9"
[[= include_file('code_samples/back_office/search/templates/themes/admin/ui/global_search_autocomplete_product_template.html.twig') =]]
```

- At HTML level, it wraps the product item template in its dataset attribute `data-template-item`.
- At Twig level, it includes the item template, replaces Twig variables with the strings used by the JS renderer,
  and pass it to the [`escape` filter](https://twig.symfony.com/doc/3.x/filters/escape.html) with the HTML attribute strategy.

To be present, this wrapping node template must be added to the `global-search-autocomplete-templates` group of tabs components:

``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 21, 27) =]]
```

The product suggestion item template itself, as `templates/themes/admin/ui/global_search_autocomplete_product_item.html.twig`:

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
