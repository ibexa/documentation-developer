# Orderhistory configuration [[% include 'snippets/commerce_badge.md' %]]

Order history uses semantic configuration, so it only exposes parameters that are configurable.

However it is possible to [override this configuration per SiteAccess](overriding_semantic_configuration.md).
When an event is thrown, before the configuration is used, you can implement a listener that changes this configuration.
[[= product_name_com =]] uses this event to display [local orders](order_history_features/orderhistory_local_orders.md).
See the [Overriding semantic configuration](overriding_semantic_configuration.md) to find out how to implement a new configuration listener.

``` yaml
siso_order_history:
    list:
        max_document_count: 30
    
    document_types:
        - invoice
        - delivery_note
        - credit_memo
        - order
    
    default_document_type: invoice
    
    #valid values: <integer> hours or <integer> minutes and so on, the date is calculated with <now> - given time
    date:
        start: 2 years
        end: 0 days
        max_start: 4 years
```

To define default sorting for columns in the list page, use the `default_list_sort` setting.

Allowed vales are:

- `numeric-comma` - for numbers which use a comma as the decimal place like currency
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
        #example multiple sorting
        #invoice: [[0, 'desc'], [2, 'asc']]
        invoice: [[1, 'desc']]
        delivery_note: [[1, 'desc']]
        order: [[1, 'desc']]
        credit_memo: [[1, 'desc']]
```

You can configure which columns (per document type) you want to display.

The column identifier is the block name from `views/OrderHistory/Components/fields.html.twig` without the suffix `_field`:

``` yaml
    default_list_fields:
        invoice:
            - ID_list
            - IssueDate
            - LegalMonetaryTotal_TaxExclusiveAmount
            - LegalMonetaryTotal_TaxInclusiveAmount
        delivery_note:
            - ID_list
            - IssueDate
        order:
            - ID_list
            - OrderReference_IssueDate
            - LegalMonetaryTotal_TaxExclusiveAmount
            - LegalMonetaryTotal_TaxInclusiveAmount
        credit_memo:
            - ID_list
            - IssueDate
            - LegalMonetaryTotal_TaxExclusiveAmount
            - LegalMonetaryTotal_TaxInclusiveAmount
    
    default_detail_fields:
        invoice:
            - Item_SellersItemIdentification_ID
            - Item_Name
            - InvoicedQuantity
            - SesExtension_UnitPrice
            - Price_PriceAmount
            - Sum
        delivery_note:
            - Item_SellersItemIdentification_ID
            - Item_Name
            - InvoicedQuantity
            - SesExtension_UnitPrice
        order:
            - Item_SellersItemIdentification_ID
            - Item_Name
            - InvoicedQuantity
            - SesExtension_UnitPrice
            - Price_PriceAmount
            - Sum
        credit_memo:
            - Item_SellersItemIdentification_ID
            - Item_Name
            - InvoicedQuantity
            - SesExtension_UnitPrice
            - Price_PriceAmount
            - Sum
```

You can configure the ERP date format and also the date format that is used in the shop:

``` yaml
parameters:
    #date format that is used and displayed in shop
    #combination of these characters is allowed: Y,m,d
    #accepted delimiters are: "/" , "." and "-"
    #Example: d.m.Y, Y/m/d, d-m-Y...
    siso_order_history.default.date_format: 'd.m.Y'

    #date format that is used for communication with ERP
    siso_order_history.default.erp_date_format: 'Ymd' 
```
