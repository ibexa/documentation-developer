# Data model for prices

## Price

The `Siso\Bundle\PriceBundle\Model` class defines a generic price object.
When attached to a [`ProductNode`](../../catalog/catalog_api/productnode.md) object,
[`PriceField`](../../../api/commerce_api/fields_for_ecommerce_data/pricefield.md) is used.

Because this class extends `ValueObject`,
you can set the necessary properties a new `Price` object using an array in the constructor.

## Properties

| Name               | Type      | Required | Description                |
| ------------------ | --------- | ------- | ------------------------------------------------------------------ |
| `price`            | `float`   |    yes    | The main price value                                               |
| `priceInclVat`     | `float`   |    no     | The price value including VAT                           |
| `priceExclVat`     | `float`   |    no     | The price value excluding VAT                           |
| `isVatPrice`       | `boolean` |    yes    | If true, the main price value includes VAT                     |
| `vatCode`          | `float`   |    yes    | VAT percentage                      |
| `currency`         | `string`  |    yes    | The ISO 4217 currency code (e.g. "EUR")         |
| `discount`         | `float`   |    no     | Discount in percentage                                             |
| `timestamp`        | `string`  |    no     | Timestamp |
| `campaign`         | `string`  |    no     | Campaign code resp. value                                          |
| `source`           | `string`  |    yes    | The source of this price (e.g. "NAV")                              |
| `quantityDiscount` | `array`   |    no     | Information regarding block prices, etc. |
