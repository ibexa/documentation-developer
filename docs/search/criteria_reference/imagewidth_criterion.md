---
description: Image Width Criterion
---

# Image Width Criterion

The `Width` Search Criterion searches for image with specified width.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the Field
- (optional) `minValue` - int representing minimum file width expressed in pixels, default: 0
- (optional) `maxValue` - int representing maximum file width expressed in pixels, default: `null`

## Example

### PHP

``` php
$query->query = new Criterion\Width('image', 150, 1000);
```
