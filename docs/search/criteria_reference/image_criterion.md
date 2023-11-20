---
description: Image Criterion
---

# Image Criterion

The `Image` Search Criterion searches for image by specified image attributes.

## Arguments

- `data` - allowed criteria: `width`, `height`, `MimeTypes`, `orientation`. All criteria are optional.

## Example

### PHP

``` php

$data = [
    'mimeTypes' => [
       'image/png'
    ],
    'orientation' => [
       'image/png'
    ],
    'width' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
    'height' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
    'size' => [
        'min' => 0 // (default: 0, optional),
        'max' => 2 // (default: null, optional),
    ],
];

or 

$data = [
    'mimeTypes' => 'image/png',
    'orientation' => 'image/png',
    'width' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
    'height' => [
        'min' => 0 // (default: 0, optional),
        'max' => 1000 // (default: null, optional),
    ],
    'size' => [
        'min' => 0 // (default: 0, optional),
        'max' => 2 // (default: null, optional),
    ],
];


$query = new Image(string $fieldDefIdentifier, array $data);
```
