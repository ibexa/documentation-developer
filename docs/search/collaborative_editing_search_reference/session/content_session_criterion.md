---
description: ContentSession Search Criterion
---

# ContentSession Criterion

The `ContentSession` Search Criterion searches for contentId, versionNo, languageId.

## Arguments

- `contentId` - integer representing content item ID
- `versionNo` - integer representing version number
- `languageId` - integer representing language ID

## Example

```php
$criteria = new \Ibexa\Share\Session\Query\Criterion\ContentSession(1, 2, 3);

OR

$versionInfo = $this->contentService->loadVersionInfoById(1);
$criteria = new \Ibexa\Share\Session\Query\Criterion\ContentSession::fromVersionInfo($versionInfo);

$query = new SessionQuery($criteria);
```