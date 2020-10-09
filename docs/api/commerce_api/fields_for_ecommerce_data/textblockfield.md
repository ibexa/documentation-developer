# TextBlockField

`TextBlockField` is the representative implementation of `AbstractField` for a multi-line text (or DOMDocument).

A new `TextBlockField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\TextBlockField;

// Usage: 
$textBlockField = new TextBlockField(
    array(
        'text' => 'This is the <b>description</b> of the product'
    )
);
```

!!! note

    A TextBlockField object can be reliably serialized, because it implements the magic `__sleep()` and `__wakeup()` methods.
