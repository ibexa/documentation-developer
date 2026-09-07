---
description: You can use the PHP API to view the bookmark list, and add or remove content from it.
---

# Bookmark API

`BookmarkService` enables you to read, add and remove bookmarks from content.

!!! tip "Bookmark REST API"

    To learn how to manage bookmarks using the REST API, see [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Bookmark).

To view a list of all bookmarks, use `BookmarkService::loadBookmarks`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 44, 50, remove_indent=True) =]]
```

You can add a bookmark to a content item by providing its Location object to the `BookmarkService::createBookmark` method:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 38, 40, remove_indent=True) =]]
```

You can remove a bookmark from a location with `BookmarkService::deleteBookmark`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 53, 53, remove_indent=True) =]]
```
