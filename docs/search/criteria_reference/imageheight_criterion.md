---
description: Image Height Search Criterion
---

# Image Height Criterion

The `Height` Search Criterion searches for image with specified height.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the field
- (optional) `minValue` - int representing minimum file height expressed in pixels, default: 0
- (optional) `maxValue` - int representing maximum file height expressed in pixels, default: `null`

## Limitations

`ImageHeight` can be used on all search engines.

## Example

### PHP

```php
$query->query = new Criterion\Height('image', 0, 1500);
```
