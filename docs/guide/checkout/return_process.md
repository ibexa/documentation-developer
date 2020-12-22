# Return process [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] offers a simple RMA (return merchandise authorization) process.
The goal is to inform the user about the cancellation policies and give them the possibility to return their goods, including online returns.

The cancellation process validates the input and sends an email to the shop administrator. 

![](../img/rma_process.png)

## Link to cancellation form

A link to the cancellation policies and online cancellation form is displayed in the footer.
The text modules that are used to render the footer can be configured per SiteAccess:

``` yaml
parameters:
    siso_core.default.identifier_footer_block_address: footer_block_address
    siso_core.default.identifier_footer_block_company: footer_block_company
    siso_core.default.identifier_footer_block_service: footer_block_service
    siso_core.default.identifier_footer_block_ordering: footer_block_ordering
```

## Online cancellation form

After a user submits the online cancellation form,
an email is sent to the admin using [SendCancellationEmailDataProcessor](../forms/form_api/dataprocessors.md#sendcancellationemaildataprocessor).

## Product return form

After a user submits the Product return form,
an email is sent to the admin using [SendRmaEmailDataProcessor](../forms/form_api/dataprocessors.md#sendrmaemaildataprocessor).

The email recipient has to generate a delivery note with a return number and send it to the customer.
The customer then can return their goods together with return number.
