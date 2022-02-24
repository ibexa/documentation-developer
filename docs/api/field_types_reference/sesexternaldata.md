# SesExternalData

Field Type `sesexternaldatatype` uses external storage to store data.
The data is stored in the `ses_externaldata` table with the following structure:

|Field|Type|Description|
|--- |--- |--- |
|`sku`|char(40)|Unique ID of the Product category (CatalogElement).|
|`identifier`|char(40)|ID of the Field.|
|`language_code`|char(8)|Language code, for example, `ger-DE`.|
|`ses_field_type`|char(20)|The data type used for this data.|
|`content`|longtext|Serialized data in string format.|

## Storing data in `ses_externaldata`

Data that is stored in the `ses_externaldata` table must be either a simple datatype: int, float, bool or a Field Type.

Field Type data is stored in the database in serialized form by using the `toHash()` method.
Simple data types (int, float, bool) are stored in serialized form.
