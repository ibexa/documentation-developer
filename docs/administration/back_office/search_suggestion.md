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

## Add a suggestion source

You can add a suggestion source by listening or subscribing to the `Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent`.
During this event, you can add, remove, or replace suggestions by updating its `SuggestionCollection`.
After this event, the suggestion collection is sorted by score and truncated to [`result_limit`](#configuration) items.

!!! tip
    
    You can list listeners and subscribers with the following command:
    ``` shell
    php bin/console debug:event BuildSuggestionCollectionEvent
    ```

The following example is boosting Product suggestions.
It's a subscriber passing after the default one (thanks to a priority below zero) and adding matching products at a score above the previous Content suggestions.

- If this suggestion source find a count of `result_limit` matching products or more, there is only those products in the suggestion.
- If it finds less than `result_limit` products, those products are on top of the suggestion followed by other suggestion source items to reach the limit.
- If it doesn't find any matching product, only default source suggestion is shown.

This the event subscriber itself in the file `src/EventSubscriber/MySuggestionEventSubscriber.php`:
``` php
[[= include_file('code_samples/back_office/search/src/EventSubscriber/MySuggestionEventSubscriber.php') =]]
```

To have the logger injected thanks to the `LoggerAwareTrait`, this subscriber must be registered as a service:
``` yaml
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 2, 3) =]]
```


To represent the product suggestion data, a ProductSuggestion class is created in `src/Search/Model/Suggestion/ProductSuggestion.php`:
``` php
[[= include_file('code_samples/back_office/search/src/Search/Model/Suggestion/ProductSuggestion.php') =]]
```

This representation need a normalizer to be transformed into JSON.
`ProductSuggestionNormalizer::supportsNormalization` associates with `ProductSuggestion`.
`ProductSuggestionNormalizer::normalize` return an array of scalar value which can be transformed into a JSON object.
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
    
    At this point, it's possible to test the suggestion JSON. The route is `/suggestion` with a `query` GET parameter worth the searched text.
    Log in your Back Office to have a session cookie, then access to the route through the Back Office siteaccess, such as `http://localhost/admin/suggestion?query=platform`.

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

Here is the complete `assets/js/admin.search.autocomplete.product.js`from the product suggestion example:

TODO: Move template to Twig

``` js
[[= include_file('code_samples/back_office/search/assets/js/admin.search.autocomplete.product.js') =]]
```

To be loaded in Back Office layout, this file must be added to `ibexa-admin-ui-layout-js` entry using Webpack. This is appended to `webpack.config.js`:

``` javascript
//…
[[= include_file('code_samples/back_office/search/append_to_webpack.config.js') =]]
```

## Replace the default suggestion source

To replace the default suggestion source, [decorate]([[= symfony_doc =]]/service_container/service_decoration.html) the built-in `BuildSuggestionCollectionEvent` subscriber with your own:

```yaml
services:
    #…
    App\EventSubscriber\MySuggestionEventSubscriber:
        decorates: Ibexa\Search\EventDispatcher\EventListener\ContentSuggestionSubscriber
```
