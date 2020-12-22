# eContent API [[% include 'snippets/commerce_badge.md' %]]

eContent provides a flexible way to define project-specific attributes for products and categories (and other product-related types of data).

[[= product_name_com =]] requires that some of the attributes use predefined identifiers.

## Categories

|Identifier|Type|Description|Standard mapping|Stored in|
|--- |--- |--- |--- |--- |
|`ses_name`|ezstring|The name of the category|`catalogElement.name`|data_text|
|`code`|ezstring|A unique ID for the category|||
|`text`|ezstring|Longer text for the category|`catalogElement.text`|data_text|

## Products

|Identifier|Type|Description|Standard mapping|Stored in|
|--- |--- |--- |--- |--- |
|`ses_name`|ezstring|The name of the product|catalogElement.name|data_text|
|`ses_sku`|ezstring|The unique SKU|catalogElement.sku|data_text|
|`ses_subtitle`|ezstring|The subtitle used in product listing pages|catalogElement.text and catalogElement.subtitle</br>catalogElement.text will be replaced by the new `subtitle` attribute in the future|data_text|
|`ses_short_description`|ezstring|A short description|catalogElement.shortDescription|data_text|
|`ses_long_description`|ezstring||catalogElement.longDescription|data_text|
|`ses_unit_price`|ezprice|A list price for the product in the default currency|catalogElement.price|data_float|
|`ses_vat_code`|ezstring||catalogElement.vatCode|data_text||
|`ses_unit`|ezstring|The unit of the product|catalogElement.unit|data_text|
|`ses_image_main|ezstring|A relative path to the main image|catalogElement.mainImage|data_text|
|`ses_specification`|ezstring|A JSON-formatted set of data that contains grouped specifications|catalogElement.specifications|data_text|

Data for variant products:

| Identifier  | Type |Description     | Standard mapping   | Stored in  |
| -------- | -------- | ---------- | ------------------- | ---------- |
| `ses_variants` | ezstring | Contains the SKU/variant code, name, list price and characteristic for the variants | Will be converted to build a variantProductNode | data\_text |

Optional attributes:

|Identifier|type|description|standard mapping|Stored in|
|--- |--- |--- |--- |--- |
|ses_country_of_origin||||data_text|
|ses_ean||||data_text|
|ses_brand||||data_text|
|ses_manufacturer||||data_text|
|ses_manfacturer_sku||||data_text|
|ses_video||||data_text|
|ses_image_list||Additional images|catalogElement.imageList|data_text|
|ses_max_order_quantity|ezinteger|The max quantity to be ordered per order|catalogElement.maxOrderQuantity|data_int|
|ses_min_order_quantity|ezinteger||catalogElement.minOrderQuantity|data_int|
|ses_discontinued|ezboolean|If the product is discontinued, it can be ordered only if stock > 0|Stored in the dataMap|data_int|
