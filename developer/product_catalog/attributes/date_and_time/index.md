# Date and time attributes

Date and time attribute type allows you to store product information related to time, like an expiration date or date of manufacturing.

The date and time [attribute type](../../products/index.md#product-attributes) allows you to represent date and time values as part of the product specification in the [product catalog](../../product_catalog_guide/index.md).

You can use it to store, for example, manufacturing dates, expiration dates, or event dates, all with specified accuracy.

## Usage

You can manage the date and time attribute type through the back office, [data migrations](../../../content_management/data_migration/importing_data/index.md#date-and-time-attributes), REST, or through the PHP API. It also supports [searching](../../../search/criteria_reference/product_search_criteria/index.md) by using [DateTimeAttribute](../../../search/criteria_reference/datetimeattribute_criterion/index.md) and [DateTimeAttributeRange](../../../search/criteria_reference/datetimeattributerange_criterion/index.md) criteria.

!\[Creating a product using a date and time attribute with "trimester" accuracy level\](../img/datetime.png "Creating a product using a date and time attribute with "trimester" accuracy level")

When creating an attribute based on the date and time attribute type you can select the accuracy level to match your needs:

| Accuracy  | Example             | Limitations                  |
| --------- | ------------------- | ---------------------------- |
| Year      | 2025                | Number between 1000 and 9999 |
| Trimester | Q3 2025             |                              |
| Month     | July 2025           |                              |
| Day       | 2025-07-06          |                              |
| Minute    | 2025-07-06 11:15    |                              |
| Second    | 2025-07-06 11:15:37 |                              |
