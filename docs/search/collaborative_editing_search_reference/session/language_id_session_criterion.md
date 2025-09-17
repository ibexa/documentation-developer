---
description: LanguageID Search Criterion
---

# LanguageID Criterion

The `LanguageID` Search Criterion searches for content sessions based on language ID of content item.

## Arguments

- `value` - integer(s) representing language id(s)

## Example

```php
$criteria = new Ibexa\Share\Session\Query\Criterion\LanguageId(1);

OR

$criteria = new Ibexa\Share\Session\Query\Criterion\LanguageId([1, 2]);

$query = new SessionQuery($criteria);
```