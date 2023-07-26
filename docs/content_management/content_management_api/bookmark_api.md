---
description: You can use the PHP API to view the bookmark list, as well as add and remove content from it.
---

# Bookmark API

[`BookmarkService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php)
enables you to read, add and remove bookmarks from content.

!!! tip "Bookmark REST API"

    To learn how to manage bookmarks using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-bookmarks).

To view a list of all bookmarks, use [`BookmarkService::loadBookmarks`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L54)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 43, 50) =]]
```

You can add a bookmark to a Content item by providing its Location object
to the [`BookmarkService::createBookmark`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L31) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 37, 40) =]]
```

You can remove a bookmark from a Location with [`BookmarkService::deleteBookmark`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L42)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 52, 53) =]]
```
