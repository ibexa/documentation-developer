---
description: Image FileSize Criterion
---

# Image FileSize Criterion

The `FileSize` Search Criterion searches for image with specified size.

## Arguments

- `min_size` - minimum file size expressed in MB
- `max_size` - maximum file size expressed in MB

## Example

### PHP

``` php
$query = new FileSize(string $fieldDefIdentifier, int $minFileSize = 0, ?int $maxFileSize = null);
```
