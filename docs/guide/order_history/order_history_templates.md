# Order history templates [[% include 'snippets/commerce_badge.md' %]]

## Template list

|Path|Description|
|--- |--- |
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/list.html.twig`|Renders the document list.|
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/Components/list_table.html.twig`|Renders the document table. Included in `OrderHistory/list.html.twig`.|
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/detail.html.twig`|Renders the detail view of a single document.|
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/Components/header_default.html.twig`|Renders the header information for document detail. Included in `OrderHistory/detail.html.twig`.|
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/Components/fields.html.twig`|Contains blocks that render the content of the individual fields (defined in the configuration). Included in `OrderHistory/Components/list_table.html.twig` and `OrderHistory/detail.html.twig`.|
|`IbexaCommerceOrderHistoryBundle/Resources/views/OrderHistory/Components/user_menu.html.twig`|Renders the "Your documents" item in user menu.|

## Custom Twig functions

|Twig filter|Description|Usage|
|--- |--- |--- |
|`ibexa_commerce_erp_to_default`|Converts the ERP date into the default date format.|`{{ 'Order at:'|ibexa_commerce_translate }} {{ response.OrderReference.IssueDate.value|ibexa_commerce_erp_to_default }} {{ response.OrderReference.IssueDate.value|ibexa_commerce_erp_to_default }}`|
|`ibexa_commerce_to_float`|Converts the given value to a valid float (also strings that use a comma instead of a dot).|`{{ 'VAT:'|ibexa_commerce_translate }} {{ vat.TaxAmount.value|ibexa_commerce_to_float|ibexa_commerce_price_format }}`|
