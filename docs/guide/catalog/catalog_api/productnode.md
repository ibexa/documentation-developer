# ProductNode [[% include 'snippets/commerce_badge.md' %]]

`ProductNode` is an abstract base class for product elements. 
It inherits from product category `CatalogElement`.
`OrderableProductNode` is a concrete implementation of `ProductNode` for a product.

Each `ProductNode` has predefined properties. These methods are validated automatically on constructor by the `validateProperties()` method.

|Identifier|Field identifier|Type|Description|
|--- |--- |--- |--- |
|`name`|`ses_name`|string|Product name|
|`sku`|`ses_sku`|string|Unique Stock Keeping Unit (SKU) of the product|
|`manufacturerSku`|`ses_manufacturer_sku`|string|Stock Keeping Unit (SKU) as provided by the manufacturer of the product|
|`ean`|`ses_ean`|string|European Article Number (EAN)|
|`type`|`ses_product_type`|string|Type of the product, e.g. vegetable|
|`isOrderable`||boolean|True, if the product is orderable|
|`price`|`ses_unit_price`|FieldInterface|Price of the product|
|`customerPrice`||PriceField (FieldInterface)|Customer price of the product which might be generated from a price provider|
|`scaledPrices`||ArrayField|Array with scaled prices and parameters to determine which scale price should be applied|
|`stock`|`ses_stock_numeric`|FieldInterface|Available stock of the product|
|`subtitle`|`ses_subtitle`|TextBlockField (FieldInterface)|Product subtitle|
|`shortDescription`|`ses_short_description`|TextBlockField (FieldInterface)|Short product description|
|`longDescription`|`ses_long_description`|TextBlockField (FieldInterface)|Long product description|
|`specifications`|`ses_specifications`|FieldInterface[]|List of specifications of the product|
|`imageList`|`ses_image_1` ... `ses_image_4`|ImageField[] (FieldInterface[])|List of images|
|`minOrderQuantity`|`ses_min_order_quantity`|float|Minimum quantity that can be ordered|
|`maxOrderQuantity`|`ses_max_order_quantity`|float|Maximum quantity that can be ordered|
|`allowedQuantity`||string|Regex that indicates the allowed quantity|
|`packagingUnit`|`ses_packaging_unit`|float|Packaging unit of the product|
|`unit`|`ses_unit`|string|Unit of the product|
|`vatCode`|`ses_vat_code`|string|VAT code of the product. Needed to determine VAT rate|

## `allowedQuantity` regex

This regex can be evaluated using the `preg_match()` function by some processes to check if the given quantity corresponds to the allowed quantity.
The following values can be used:

- `ALLOWED_QUANTITY_INTEGER`
- `ALLOWED_QUANTITY_UP_TO_ONE_DECIMAL_PLACE`
- `ALLOWED_QUANTITY_UP_TO_TWO_DECIMAL_PLACES`
- `ALLOWED_QUANTITY_MULTIPLE_DECIMAL_PLACES`

Example for an individual expression: `'#^[0-9]+(\.|,)?[0-9]*$#'`

If this regex is not set, the quantity can be an integer only.

Example:

`'allowedQuantity' => ProductNodeConstants::ALLOWED_QUANTITY_UP_TO_ONE_DECIMAL_PLACE,`
