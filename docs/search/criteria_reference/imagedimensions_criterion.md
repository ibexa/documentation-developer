---
description: Image Dimensions Criterion
---

# Image Dimension Criterion

The `Orientation` Search Criterion searches for image with specified dimensions.

## Arguments

- `data` - string or array. Allowed criteria: `width`, `height`. All criteria are optional.

## Example

### PHP

``` php

$data = [
    'width' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
    'height' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
]

$query = new Dimensions(string $fieldDefIdentifier, array $data);
```
