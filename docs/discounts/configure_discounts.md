---
description: Customize the behavior of the Discounts feature.
month_change: false
editions:
    - commerce
---

# Customize Discounts

You can customize the behavior of the Discounts feature by using the following [configuration](configuration.md):

## Back Office pagination

Use the built-in SiteAccess-aware parameters to change the default pagination settings.

The following parameters are available:

- `list_per_page_limit` controls the number of discounts displayed on a single page in discount list view
- `products_list_per_page_limit` controls the number of products displayed on a single page in a discount details view

You can set them as in the following example:

``` yaml
ibexa:
    system:
        admin_group:
            discounts:
                pagination:
                    list_per_page_limit: 10
                    products_list_per_page_limit: 15
```

## Discount re-indexing

Discounts feature uses [[= product_name_base =]] Messenger to reindex discounts and product prices as [background tasks](background_tasks.md).
This way changes are processed efficiently without slowing down the system and disrupting the user experience.

When triggered periodically, the `ibexa:discounts:reindex` command identifies discounts that require re-indexing, ensuring prices always remain up-to-date.
If there are edits to discounts that should result in changed product catalog prices, messages are dispatched to the [[= product_name_base =]] Messenger's queue and consumed by a background worker.
The worker passes the messages to the handler, which then starts the re-indexing process at the most convenient moment.

To run discount re-indexing in the background:

1\. Make sure that the transport layer is [defined properly](background_tasks.md#configure-package) in [[= product_name_base =]] Messenger configuration.

2\. Make sure that the [worker starts](background_tasks.md#start-worker) together with the application to watch the transport bus:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus
```

3\. Use a scheduler of your choice, for example, [cron](https://en.wikipedia.org/wiki/Cron), to periodically run the following command:

``` bash
php bin/console ibexa:discounts:reindex
```

!!! note "Deploying Symfony Messenger"

    For more information about deploying the Messenger to production, see [Symfony documentation]([[= symfony_doc =]]/messenger.html#deploying-to-production).

## Rate limiting

To prevent malicious actors from trying all the possible discount code combinations using brute-force attacks, the [`/discounts_codes/{cartIdentifier}/apply` endpoint](https://doc.ibexa.co/en/4.6/api/rest_api/rest_api_reference/rest_api_reference.html#discount-codes-apply-discount-to-cart) is rate limited using the [Rate Limiter Symfony component]([[= symfony_doc =]]/rate_limiter.html).

You can adjust the default configuration by modifying the `config/packages/ibexa_discounts_codes.yaml` file created during installation process.

The limiter uses the following pattern: `user_%d_ip_%s`, using Customer ID and Customer IP address to track usage of both logged-in and anonymous customers.
To cover additional use cases, you can add your own logic by listening to the [`BeforeDiscountCodeApplyEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Event-BeforeDiscountCodeApplyEvent.html) event.

## Checkout error-handling

A discount can be valid when customer enters the cart, but later become invalid before the checkout process is completed.

For example, this event could occur if the discount expired, was modified, disabled, or deleted before the customer completed the checkout process.

To prevent customers from placing such orders, the Discounts feature comes with built-in error-handling.
Once it detects that a discount that can no longer be used is applied to a product, it stops the checkout process and informs the customer.

This error handling is provided by two event subscribers:

- `Ibexa\Bundle\Checkout\EventSubscriber\DiscountsHaveChangedExceptionSubscriber`
- `Ibexa\Bundle\DiscountsCodes\EventSubscriber\DiscountCodeUnusableExceptionSubscriber`

You can disable this behavior by setting the `ibexa_checkout.error_handlers.enabled` container parameter to `false`, which allows you to provide your own solution for these cases.
