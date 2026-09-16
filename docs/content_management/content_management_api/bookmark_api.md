---
description: You can use the PHP API to view the favourites list, and add or remove content from it.
---

# Bookmark API

[`BookmarkService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html) enables you to add and remove content from favourites, and read favourite assignments.

!!! tip "Bookmark REST API"

    To learn how to manage favourites using the REST API, see [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Bookmark).

To view a list of all favourites, use [`BookmarkService::loadBookmarks`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_loadBookmarks):

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 44, 50, remove_indent=True) =]]
```

You can mark a content item as favourite by providing its Location object to the [`BookmarkService::createBookmark`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_createBookmark) method:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 38, 40, remove_indent=True) =]]
```

You can remove a location from a list of favourites with [`BookmarkService::deleteBookmark`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_deleteBookmark):

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 53, 53, remove_indent=True) =]]
```
