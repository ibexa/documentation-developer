---
description: Image Width Criterion
---

# Image Width Criterion

The `CreatedAt` Search Criterion searches for image with specified width.

## Arguments

- `min_value` - minimum file size expressed in pixels
- `max_value` - maximum file size expressed in pixels

## Example

### PHP

``` php
$query = new Width(string $fieldDefIdentifier, int $minValue = 0, ?int $maxValue = null);
```
