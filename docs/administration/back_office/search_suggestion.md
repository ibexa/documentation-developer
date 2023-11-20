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

The following example is boosting Product suggestions.
It's a subscriber passing after the default one (thanks to a priority below zero) and adding matching products at a score above the previous Content suggestions.

- If this suggestion source find a count of `result_limit` matching products or more, there is only those products in the suggestion.
- If it finds less than `result_limit` products, those products are on top of the suggestion followed by other suggestion source items to reach the limit.
- If it doesn't find any matching product, only default source suggestion is shown.

``` php
[[= include_file(code_samples/back_office/search/src/EventSubscriber/MySuggestionEventSubscriber.php) =]]
```

!!! tip

    You can list listeners and subscribers with the following command:
    ``` shell
    php bin/console debug:event BuildSuggestionCollectionEvent
    ```

## Replace the default suggestion source

To replace the default suggestion source, [decorate]([[= symfony_doc =]]/service_container/service_decoration.html) the built-in `BuildSuggestionCollectionEvent` subscriber with your own:

```yaml
services:
    #…
    App\EventSubscriber\MySuggestionEventSubscriber:
        decorates: Ibexa\Search\EventDispatcher\EventListener\ContentSuggestionSubscriber
```
