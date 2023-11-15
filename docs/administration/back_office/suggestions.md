---
description: Customize search suggestions configuration and sources.
---

# Customize search suggestions

In the Back Office, when typing some text in the search bar, some suggestions about what you could be looking for are made directly under this bar.

## Configuration

By default, the suggestions start to be made when the typed text is at least 3 characters long, and 5 suggestions are made. This can be changed by setting the following parameters:

```yaml
parameters:
    ibexa.site_access.config.default.search.suggestion.min_query_length: 3
    ibexa.site_access.config.default.search.suggestion.result_limit: 5
```

## Add a suggestion source

You can a suggestion source by listening or subscribing to the `Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent`.
During this event, you can add, remove or replace suggestions. Then, the suggestion collection will be sorted by score and truncated to [`result_limit`](#configuration) items. 

``` php
[[= include_file(code_samples/back_office/suggestions/src/EventSubscriber/MySuggestionEventSubscriber.php) =]]
```
