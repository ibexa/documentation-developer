# ImageField

`ImageField` is the representative implementation of `AbstractField` for an image.
An image is identified and initiated by a given path and an optional alternative text.

A new `ImageField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\ImageField;

// Usage:
$imagePath = 'var/storage/images/product_image.jpg';
$imageField = new ImageField(
    array(
        'alternativeText' => 'a nice product',
        'fileName'        => basename($imagePath),
        'fileSize'        => filesize($imagePath),
        'path'            => $imagePath,
    )
);
```
