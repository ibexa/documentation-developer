# Lost orders [[% include 'snippets/commerce_badge.md' %]]

## Sending lost orders from the Back Office

If sending an order to ERP fails, the order is stored in a database with a special state `ordered_failed`.
You can find lost orders in the Back office tab **eCommerce -> Order Management**.
Filter by **Order transfer failed**.

For each lost order you can perform the following actions:

|Action|Description|Result|
|--- |--- |--- |
|Transfer to ERP|The lost order is re-sent to ERP|The user sees an error or success message depending on whether the lost order could be re-sent to ERP or not. If sending the lost order failed, the administrator gets an email. If sending the lost order was successful, the customer who made this order gets a confirmation email|
|Remove lost order|The lost order is not removed, the state of lost order is changed to `confirmed`|The lost order does not appear in the list anymore|

## Email notifications

Every time an order cannot be placed, the shop administrator gets an email.
The email address can be defined in the fellowing configuration:

``` yaml
parameters:
    siso_core.default.ses_swiftmailer:
        lostOrderEmailReceiver: %ses_eshop.lostorder_email%
```

Templates are located in:

``` 
EshopBundle/Resources/views/Emails/NotificationMail_FailedOrder.html.twig
EshopBundle/Resources/views/Emails/NotificationMail_FailedOrder.txt.twig
```

## Lost order command

You can also re-send lost orders using a command-line tool:

``` bash
php bin/console ibexa:commerce:process-lost-orders [id]
```

!!! caution

    To use the CLI the host must be set, otherwise the URLs and assets are not correct.

    ``` yaml
    parameters:
        siso_core.default.host: localhost
    ```
