# StandardPriceFactory

Depending on the configuration, `StandardPriceFactory` creates a Price instance including or excluding VAT.
The configuration can be overridden by method parameters.

The default fallback price source depends on the content of the price fields.

- If one of the fields is empty (zero or null), the fallback price source is `PriceConstants::PRICE_ENGINE_SOURCE_INCOMPLETE`
- Otherwise the price source is `PriceConstants::PRICE_ENGINE_SOURCE_LOCAL`

## Creating price

There are two ways to create a price:

1\. Create Price from `PriceLine` in `PriceRequest`. It uses the content of a `PriceLine` and the given currency code. 

``` php
/**
 * @param PriceLine $responseLine
 * @param string $currencyCode  Must be set with an ISO 4217 value
 * @param string $type  Must be one of the PRICE_RESPONSE_PRICE_TYPE_* values of
 *                      PriceConstant class. It defines, which of the
 *                      prices in the response line is referred to.
 * @param bool $useUnitPrice If true unit price will be used instead of line amount
 * @return Price
 */
public function createPriceFromResponseLine(PriceLine $responseLine, $currencyCode, $type, $useUnitPrice = false);
```

2\. Create price from given properties. The necessary values are passed directly within an array. 

If the `vatPercent` value is not set, but `vatCode` is, `vatCode` and `country` are used to get the `vatPercent`.
Otherwise, fallback `vatPercent` (determined by fallback country and fallback vat code) is used.  

``` php
/**
 * @param array $properties
 * @return Price
 */
public function createPrice(array $properties);
```

``` php
// Example of all possible properties
$properties = array(
      'price' => 1.0,
      'priceInclVat' => 1.0
      'priceExclVat' => 0.81,
      'isVatPrice' => true,
      'vatPercent' => 19,
      'vatCode' => 'vegetable',
      'country' => 'DE',
      'currency' => 'EUR',
      'source' => 'Shop'
 );
```

## Default configuration

Factory uses default values for fallbacks if value is missing:

``` yaml
siso_core.default.standard_price_factory.fallback_currency: EUR
siso_core.default.standard_price_factory.fallback_country: DE
siso_core.default.standard_price_factory.fallback_vat_code: vegetable
siso_core.default.standard_price_factory.is_vat_price: true
```

## PriceFactoryInterface

The `PriceFactoryInterface` service creates Price instances.

!!! caution

    Do not create Price Field directly. Use Price Factory instead.

|Method|Description|
|--- |--- |
|`public function createPriceFromResponseLine(PriceLine $responseLine, $currencyCode, $type, $useUnitPrice = false);`|This method instantiates a Price entity. It uses the content of a `PriceLine` and the given currency code.|
|`public function createPrice(array $properties);`|This method instantiates a Price entity. The necessary values are passed directly within an array.|
