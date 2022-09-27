---
edition: commerce
---

# Order history templates

## Template list

|Path|Description|
|--- |--- |
|`OrderHistoryBundle/Resources/views/OrderHistory/list.html.twig`|Renders the document list.|
|`OrderHistoryBundle/Resources/views/OrderHistory/Components/list_table.html.twig`|Renders the document table. Included in `OrderHistory/list.html.twig`.|
|`OrderHistoryBundle/Resources/views/OrderHistory/detail.html.twig`|Renders the detail view of a single document.|
|`OrderHistoryBundle/Resources/views/OrderHistory/Components/header_default.html.twig`|Renders the header information for document detail. Included in `OrderHistory/detail.html.twig`.|
|`OrderHistoryBundle/Resources/views/OrderHistory/Components/fields.html.twig`|Contains blocks that render the content of the individual fields (defined in the configuration). Included in `OrderHistory/Components/list_table.html.twig` and `OrderHistory/detail.html.twig`.|
|`OrderHistoryBundle/Resources/views/OrderHistory/Components/user_menu.html.twig`|Renders the "Your documents" item in user menu.|

## Custom Twig functions

|Twig filter|Description|Usage|
|--- |--- |--- |
|`ses_erp_to_default`|Converts the ERP date into the default date format.|`{{ 'Order at:'|st_translate }} {{ response.OrderReference.IssueDate.value|ses_erp_to_default }} {{ response.OrderReference.IssueDate.value|ses_erp_to_default }}`|
|`ses_to_float`|Converts the given value to a valid float (also strings that use a comma instead of a dot).|`{{ 'VAT:'|st_translate }} {{ vat.TaxAmount.value|ses_to_float|price_format }}`|
