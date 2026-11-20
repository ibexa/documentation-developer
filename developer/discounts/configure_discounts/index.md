# Customize Discounts

Customize the behavior of the Discounts feature.

Editions: Commerce

You can customize the behavior of the Discounts feature by using the following [configuration](../../administration/configuration/configuration/index.md):

## Back Office pagination

Use the built-in SiteAccess-aware parameters to change the default pagination settings.

The following parameters are available:

- `list_per_page_limit` controls the number of discounts displayed on a single page in discount list view
- `products_list_per_page_limit` controls the number of products displayed on a single page in a discount details view

You can set them as in the following example:

```yaml
ibexa:
    system:
        admin_group:
            discounts:
                pagination:
                    list_per_page_limit: 10
                    products_list_per_page_limit: 15
```

## Discount re-indexing

Discounts feature uses Ibexa Messenger to reindex discounts and product prices as [background tasks](../../infrastructure_and_maintenance/background_tasks/index.md). This way changes are processed efficiently without slowing down the system and disrupting the user experience.

When triggered periodically, the `ibexa:discounts:reindex` command identifies discounts that require re-indexing, ensuring prices always remain up-to-date. If there are edits to discounts that should result in changed product catalog prices, messages are dispatched to the Ibexa Messenger's queue and consumed by a background worker. The worker passes the messages to the handler, which then starts the re-indexing process at the most convenient moment.

To run discount re-indexing in the background:

1. Make sure that the transport layer is [defined properly](../../infrastructure_and_maintenance/background_tasks/index.md#configure-package) in Ibexa Messenger configuration.

2. Make sure that the [worker starts](../../infrastructure_and_maintenance/background_tasks/index.md#start-worker) together with the application to watch the transport bus:

```bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus
```

3. Run the following command periodically, at least once a day:

```bash
php bin/console ibexa:discounts:reindex
```

For more information about command scheduling, see [Additional scheduled tasks and advanced usage](../../getting_started/install_ibexa_dxp/index.md#additional-scheduled-tasks-and-advanced-usage).

> **Note: Deploying Symfony Messenger**
>
> For more information about deploying the Messenger to production, see [Symfony documentation](https://symfony.com/doc/7.4/messenger.html#deploying-to-production).

## Rate limiting

To prevent malicious actors from trying all the possible discount code combinations using brute-force attacks, the [`/discounts_codes/{cartIdentifier}/apply` endpoint](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#discount-codes-apply-discount-to-cart) is rate limited using the [Rate Limiter Symfony component](https://symfony.com/doc/7.4/rate_limiter.html).

You can adjust the default configuration by modifying the `config/packages/ibexa_discounts_codes.yaml` file created during installation process.

The limiter uses the following pattern: `user_%d_ip_%s`, using Customer ID and Customer IP address to track usage of both logged-in and anonymous customers. To cover additional use cases, you can add your own logic by listening to the [`Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`](../../../../../ibexa/discounts-codes/src/contracts/Event/BeforeDiscountCodeApplyEvent.php) event.

## Checkout error-handling

A discount can be valid when customer enters the cart, but later become invalid before the checkout process is completed.

For example, this event could occur if the discount expired, was modified, disabled, or deleted before the customer completed the checkout process.

To prevent customers from placing such orders, the Discounts feature comes with built-in error-handling. Once it detects that a discount that can no longer be used is applied to a product, it stops the checkout process and informs the customer.

This error handling is provided by two event subscribers:

- `Ibexa\Bundle\Checkout\EventSubscriber\DiscountsHaveChangedExceptionSubscriber`
- `Ibexa\Bundle\DiscountsCodes\EventSubscriber\DiscountCodeUnusableExceptionSubscriber`

You can disable this behavior by setting the `ibexa_checkout.error_handlers.enabled` container parameter to `false`, which allows you to provide your own solution for these cases.
