# ArrayField

`ArrayField` is the representative implementation of `AbstractField` for a structured array.

A new `ArrayField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\ImageField;

// Usage:
$myArray = array (
    'weight' => '10 kg',
    'color' => 'red'
);
$arrayField = new ArrayField(array('array' =>  $myArray));
```
