---
description: You can use the PHP API to view the bookmark list, as well as add and remove content from it.
---

# Bookmark API

[`BookmarkService`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html)
enables you to read, add and remove bookmarks from content.

!!! tip "Bookmark REST API"

    To learn how to manage bookmarks using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-bookmarks).

To view a list of all bookmarks, use [`BookmarkService::loadBookmarks`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_loadBookmarks):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 43, 50) =]]
```

You can add a bookmark to a Content item by providing its Location object
to the [`BookmarkService::createBookmark`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_createBookmark) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 37, 40) =]]
```

You can remove a bookmark from a Location with [`BookmarkService::deleteBookmark`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-BookmarkService.html#method_deleteBookmark):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 52, 53) =]]
```
