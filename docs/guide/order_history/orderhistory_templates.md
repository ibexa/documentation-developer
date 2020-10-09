# Order history templates

## Template list

|Path|Description|
|--- |--- |
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/list.html.twig`|Renders the list view of requested documents.|
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/Components/list_table.html.twig`|Renders the table with list of requested documents. Included in `views/OrderHistory/list.html.twig`.|
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/detail.html.twig`|Renders the detail view of the requested document.|
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/Components/header_default.html.twig`|Renders the header information for document detail. Included in `views/OrderHistory/detail.html.twig`.|
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/Components/fields.html.twig`|Contains blocks that render the content of the requested field for columns (defined in the configuration). Included in `views/OrderHistory/Components/list_table.html.twig` and `views/OrderHistory/detail.html.twig`.|
|`vendor/silversolutions/silver.orderhistory/src/Siso/Bundle/OrderHistoryBundle/Resources/views/OrderHistory/Components/user_menu.html.twig`|See [User menu](../customers/customers_faq.md).|

## Custom Twig functions

|Twig filter|Description|Usage|
|--- |--- |--- |
|`ses_erp_to_default`|Converts the ERP date into default date format.|`{{ 'Order at:'|st_translate }} {{ response.OrderReference.IssueDate.value|ses_erp_to_default }} {{ response.OrderReference.IssueDate.value|ses_erp_to_default }}`|
|`ses_to_float`|Converts the given value to a valid float (also strings that use comma instead of dot).|`{{ 'VAT:'|st_translate }} {{ vat.TaxAmount.value|ses_to_float|price_format }}`|

## Related routes

``` yaml
siso_order_history_list:
    path:     /orderhistory
    defaults: { _controller: SisoOrderHistoryBundle:OrderHistory:list }

siso_order_history_detail:
    path:     /orderhistory/detail/{documentType}/{id}
    defaults: { _controller: SisoOrderHistoryBundle:OrderHistory:detail } 
```
