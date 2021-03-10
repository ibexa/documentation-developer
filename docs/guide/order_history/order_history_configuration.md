# Order history configuration [[% include 'snippets/commerce_badge.md' %]]

Configure the number of documents displayed on one page in using the following setting:

``` yaml
siso_order_history:
    list:
        max_document_count_per_page: 30
```

To define which document types are available in the list, use the `document_types` setting.

`default_document_type` indicates the defaults document type to display:

``` yaml
siso_order_history:
    document_types:
        - invoice
        - delivery_note
        - credit_memo
        - order
    
    default_document_type: invoice
```    

You can configure the default time period for the displayed documents:

``` yaml
siso_order_history:
    date:
        start: 2 years
        end: 0 days
        max_start: 4 years
```

## Column configuration

You can configure which columns (per document type) you want to display in the order history table.

The column identifier is the block name from `OrderHistory/Components/fields.html.twig` without the suffix `_field`:

``` yaml
siso_order_history:
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

- `numeric-comma` - for numbers which use a comma as the decimal place, such as currency
- `datetime` - for datetime in the format `<dd.mm.YYYY HH:mm>` or `<dd.mm.YYYY>`
- `false` - disables sorting of a column

``` yaml
siso_order_history:
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
siso_order_history:
    default_list_sort_column:
        invoice: [[1, 'desc']]
        delivery_note: [[1, 'desc']]
        order: [[1, 'desc']]
        credit_memo: [[1, 'desc']]
```

## Date format

You can configure the date format that is used in the shop
and the format in which dates are sent to ERP:

``` yaml
parameters:
    siso_order_history.default.date_format: 'd.m.Y'

    # date format that is used for communication with ERP
    siso_order_history.default.erp_date_format: 'Ymd' 
```
