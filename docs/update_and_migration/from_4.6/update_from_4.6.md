---
description: Update your installation to the latest v4.6 version from an earlier v4.6 version.
month_change: true
---

# Update from v4.6.x to v4.6.latest

## Update the application

Note which version you actually have before starting.

First, run:

=== "[[= product_name_headless =]]"

    ``` bash
    composer require ibexa/headless:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

Then execute the instructions below starting from the version you're upgrading from.

<!-- vale Ibexa.VariablesVersion = NO -->

## v4.6.2

#### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.1-to-4.6.2.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.1-to-4.6.2.sql
    ```

## v4.6.3

### Notification config update

The configuration of the package `ibexa/notifications` has changed.
This package is required by other packages, such as `ibexa/connector-actito` for [Transactional emails](https://doc.ibexa.co/en/latest/commerce/transactional_emails/transactional_emails/), `ibexa/payment`, or `ibexa/user`.

If you are customizing the configuration of the `ibexa/notifications` package, and using SiteAccess aware configuration to change the `Notification` subscriptions, you have to manually change your configuration by using the new node name `notifier` instead of the old `notifications`.

For example, the following v4.6.2 config:

```yaml hl_lines="4"
ibexa:
    system:
        my_siteacces_name:
            notifications: # old
                subscriptions:
                    Ibexa\Contracts\Shipping\Notification\ShipmentStatusChange:
                        channels:
                            - sms
```

becomes the following from v4.6.3:

```yaml hl_lines="4"
ibexa:
    system:
        my_siteacces_name:
            notifier: # new
                subscriptions:
                    Ibexa\Contracts\Shipping\Notification\ShipmentStatusChange:
                        channels:
                            - sms
```

## v4.6.4

#### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.3-to-4.6.4.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.3-to-4.6.4.sql
    ```

## v4.6.8

To avoid deprecations when updating from an older PHP version to PHP 8.2 or 8.3, run the following commands:

``` bash
composer config extra.runtime.error_handler "\\Ibexa\\Contracts\\Core\\MVC\\Symfony\\ErrorHandler\\Php82HideDeprecationsErrorHandler"
composer dump-autoload
```

## v4.6.9

No additional steps needed.

## v4.6.10

No additional steps needed.

## v4.6.11

### Ibexa Cloud

Update Platform.sh configuration for PHP and Varnish.

Generate new configuration with the following command:

```bash
composer ibexa:setup --platformsh
```

Review the changes applied to `.platform.app.yaml` and `.platform/`,
merge with your custom settings if needed, and commit them to Git.

## v4.6.12

If the new bundle `ibexa/core-search` has not been added by the recipes, enable it by adding the following line in `config/bundles.php`:

```php
    Ibexa\Bundle\CoreSearch\IbexaCoreSearchBundle::class => ['all' => true],
```

## v4.6.13

This release comes with a command to clean up the duplicated entries in the `ezcontentobject_attribute` table, caused by the issue described in [IBX-8562](https://issues.ibexa.co/browse/IBX-8562).

If you're affected you can remove the duplicated entries by running the following command:
``` bash
php bin/console ibexa:content:remove-duplicate-fields
```

!!! caution

    Remember about [**proper database backup**](backup.md) before running the command in the production environment.

You can customize the behavior of the command with the following options:

- `batch-size` or `b` - number of attributes affected per iteration. Default value = 10000.
- `max-iterations` or `i` - max. iterations count (default or -1: unlimited). Default value = -1.
- `sleep` or `s` - wait time between iterations, in milliseconds. Default value = 0.

## v4.6.14

### Security

This release contains security changes.
For each of following advisories evaluate the vulnerability to determine whether you might have been affected. 
If so, take appropriate action, for example by [revoking passwords](https://doc.ibexa.co/en/latest/users/passwords/#revoking-passwords) for all affected users.

You can find the three advisories below:

#### BREACH attack

If you're using Varnish, update the VCL configuration to stop compressing both the [[= product_name =]]'s REST API and JSON responses from your backend.
Fastly users are not affected.

=== "Varnish on [[= product_name_cloud =]]"

    Update Platform.sh configuration and scripts.

    Generate new configuration with the following command:

    ```bash
    composer ibexa:setup --platformsh
    ```

    Review the changes, merge with your custom settings if needed, and commit them to Git before deployment.

=== "Varnish 6"

    Update your Varnish VCL file to align it with the [`vendor/ibexa/http-cache/docs/varnish/vcl/varnish5.vcl`](https://github.com/ibexa/http-cache/blob/4.6/docs/varnish/vcl/varnish6.vcl) file.

=== "Varnish 7"

    Update your Varnish VCL file to align it with the [`vendor/ibexa/http-cache/docs/varnish/vcl/varnish7.vcl`](https://github.com/ibexa/http-cache//blob/4.6/docs/varnish/vcl/varnish7.vcl) file.
    ```

If you're not using a reverse proxy like Varnish or Fastly, adjust the compressed Content Type in the webserver configuration.
For more information. see the [updated Apache and nginx template configuration](https://github.com/ibexa/post-install/pull/86/files).

For more information, see the security advisory[TODO: insert link].

#### XSS in Content name pattern

There are no code changes to apply. For more information, see the security advisory[TODO: insert link].

#### Outdated version of jQuery in ibexa/ezcommerce-shop package

Only users of the [old Commerce solution](update_from_4.3_old_commerce.md) are affected.
There are no code changes to apply. For more information, see the security advisory[TODO: insert link].

### Disable translations of identifiers in Product Catalog's categories

The possibility of translating identifiers and parent information for the Categories in Product Catalog might lead to data consistency issues.

Disable it by running the following migration:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/2024_07_25_07_00_non_translatable_product_categories.yaml --name=2024_07_25_07_00_non_translatable_product_categories.yaml
php bin/console ibexa:migrations:migrate --file=2024_07_25_07_00_non_translatable_product_categories.yaml
```
