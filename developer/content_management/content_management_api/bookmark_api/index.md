# Bookmark API

You can use the PHP API to view the bookmark list, and add or remove content from it.

[`Ibexa\Contracts\Core\Repository\BookmarkService`](../../../../../../ibexa/core/src/contracts/Repository/BookmarkService.php) enables you to read, add and remove bookmarks from content.

> **Tip: Bookmark REST API**
>
> To learn how to manage bookmarks using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Bookmark).

To view a list of all bookmarks, use [`BookmarkService::loadBookmarks`](../../../../../../ibexa/core/src/contracts/Repository/BookmarkService.php):

```php
$bookmarkList = $this->bookmarkService->loadBookmarks();

$output->writeln('Total bookmarks: ' . $bookmarkList->totalCount);

foreach ($bookmarkList->items as $bookmark) {
    $output->writeln($bookmark->getContentInfo()->name);
}
```

You can add a bookmark to a content item by providing its Location object to the [`BookmarkService::createBookmark`](../../../../../../ibexa/core/src/contracts/Repository/BookmarkService.php) method:

```php
$location = $this->locationService->loadLocation($locationId);

$this->bookmarkService->createBookmark($location);
```

You can remove a bookmark from a location with [`BookmarkService::deleteBookmark`](../../../../../../ibexa/core/src/contracts/Repository/BookmarkService.php):

```php
$this->bookmarkService->deleteBookmark($location);
```
