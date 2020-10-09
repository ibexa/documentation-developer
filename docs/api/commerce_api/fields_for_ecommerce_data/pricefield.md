# PriceField

`PriceField` is the representative implementation of `AbstractField` for a `Price`.

A new `PriceField` can be created using the following data:

``` php
use Silversolutions\Bundle\EshopBundle\Content\Fields\PriceField;
use Siso\Bundle\PriceBundle\Model\Price;
 
// Usage: 
$price = new Price(
    array(
        'price' => 99.99,
        'isVatPrice' => true,
        'vatCode' => 19.0,
        'currency' => 'EUR',
        'source' => 'ERP',
    )
);
$priceField = new PriceField(array('price' => $price));
```

## Rendering
See [Rendering for prices](../../../guide/pricing/price_engine_templates/rendering_for_prices.md) to see the possibilities of outputting a `PriceField` using the `ses_render_field()` function.

You can also render a `priceField` with a Twig function `ses_render_price()`:

|Twig function|Parameters|Usage|
|--- |--- |--- |
|`ses_render_field()`|`$catalogElement`</br>`string $fieldIdentifier`</br>`array $params`|Renders `FieldInterface $fields` from `$catalogElement`, like TextBlockField, ImageField, PriceField.|
|`ses_render_price()`|`$catalogElement`</br>`PriceField $priceField`</br>`array $params`|Renders only `PriceField $price`.|
