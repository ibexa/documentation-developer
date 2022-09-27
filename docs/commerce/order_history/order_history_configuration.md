---
description: Configure the order history functionality to define document types and table data.
edition: commerce
---

# Order history configuration

You can change a number of different parameters to configure the behavior of the **Order History** page.

## General settings

To configure the number of documents displayed on one page, use the following setting:

``` yaml
ibexa_commerce_order_history:
    list:
        max_document_count_per_page: 30
```

To define document types that are available for selection, list them under the `document_types` key.
The `default_document_type` setting decides which document type is displayed by default:

``` yaml
ibexa_commerce_order_history:
    document_types:
        - invoice
        - delivery_note
        - credit_memo
        - order
    
    default_document_type: invoice
```    

You can configure the default time period for the displayed documents:

``` yaml
ibexa_commerce_order_history:
    date:
        start: 2 years
        end: 0 days
        max_start: 4 years
```

You can configure the date format that is used in the shop:

``` yaml
parameters:
    ibexa_commerce_order_history.default.date_format: 'd.m.Y'
```

## Column configuration

To define columns that are displayed for each document type, list them under the respective key.
The column identifier is the block name from `OrderHistory/Components/fields.html.twig`, without the suffix `_field`:

``` yaml
ibexa_commerce_order_history:
    default_list_fields:
        invoice:
            - ID_list
            - IssueDate
            - LegalMonetaryTotal_TaxExclusiveAmount
            - LegalMonetaryTotal_TaxInclusiveAmount
        # ...
    default_detail_fields:
        invoice:
            - Item_SellersItemIdentification_ID
            - Item_Name
        # ...
```

### Column sorting

To define default sorting for columns in the list page, use the `default_list_sort` setting.

Allowed values are:

- `numeric-comma` - for numbers that use a comma as a decimal separator, such as currency
- `datetime` - for datetime in the `<dd.mm.YYYY HH:mm>` or `<dd.mm.YYYY>` format`
- `false` - disables column sorting

``` yaml
ibexa_commerce_order_history:
    default_list_sort:
        invoice:
            - numeric-comma
            - datetime
            - numeric-comma
            - numeric-comma
        delivery_note:
            - numeric-comma
            - datetime
        order:
            - numeric-comma
            - datetime
            - numeric-comma
            - numeric-comma
        credit_memo:
            - numeric-comma
            - datetime
            - numeric-comma
            - numeric-comma
```

To define column sorting for the list view, use the `default_list_sort_column` setting:

``` yaml
ibexa_commerce_order_history:
    default_list_sort_column:
        invoice: [[1, 'desc']]
        delivery_note: [[1, 'desc']]
        order: [[1, 'desc']]
        credit_memo: [[1, 'desc']]
```
