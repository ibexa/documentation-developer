---
description: Image Height Criterion
---

# Image Height Criterion

The `CreatedAt` Search Criterion searches for image with specified height.

## Arguments

- `min_value` - minimum file size expressed in pixels
- `max_value` - maximum file size expressed in pixels

## Example

### PHP

``` php
$query = new Height(string $fieldDefIdentifier, int $minValue = 0, ?int $maxValue = null);
```
