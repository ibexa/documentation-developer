---
description: Update your installation to the latest v4.6 version from an earlier v4.6 version.
month_change: false
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

##### Ibexa Open Source

If you have no access to [[= product_name =]]'s `ibexa/installer` package, apply the following database upgrade script:

=== "MySQL"
``` sql
-- IBX-6592: The state/assign policy shouldn't utilize neither Location nor Subtree limitations
DELETE l
FROM `ezpolicy_limitation` l
INNER JOIN `ezpolicy` p ON p.id = l.policy_id
WHERE p.function_name = 'assign'
  AND p.module_name = 'state'
  AND l.identifier IN ('Node', 'Subtree');

DELETE lv
FROM `ezpolicy_limitation_value` lv
LEFT JOIN `ezpolicy_limitation` ON `ezpolicy_limitation`.id = lv.limitation_id
WHERE `ezpolicy_limitation`.id IS NULL;
```

=== "PostgreSQL"
``` sql
-- IBX-6592: The state/assign policy shouldn't utilize neither Location nor Subtree limitations
DELETE
FROM "ezpolicy_limitation"
WHERE "ezpolicy_limitation".id IN
      (SELECT "ezpolicy_limitation".id
       FROM "ezpolicy_limitation"
                INNER JOIN "ezpolicy" ON "ezpolicy".id = "ezpolicy_limitation".policy_id
       WHERE "ezpolicy".function_name = 'assign'
         AND "ezpolicy".module_name = 'state'
         AND "ezpolicy_limitation".identifier IN ('Node', 'Subtree'));
DELETE
FROM "ezpolicy_limitation_value"
WHERE "ezpolicy_limitation_value".id IN
      (SELECT "ezpolicy_limitation_value".id
       FROM "ezpolicy_limitation_value"
                LEFT JOIN "ezpolicy_limitation" ON "ezpolicy_limitation".id = "ezpolicy_limitation_value".limitation_id
       WHERE "ezpolicy_limitation".id IS NULL);
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

This release comes with a command to clean up duplicated entries in the `ezcontentobject_attribute` table, which were created due to an issue described in [IBX-8562](https://issues.ibexa.co/browse/IBX-8562).

If you're affected, remove the duplicated entries by running the following command:
``` bash
php bin/console ibexa:content:remove-duplicate-fields
```

!!! caution

    Remember about [**proper database backup**](backup.md) before running the command in the production environment.

You can customize the behavior of the command with the following options:

- `--batch-size` or `-b` - number of attributes affected per iteration. Default value = 10000.
- `--max-iterations` or `-i` - maximum iterations count. Default value = -1 (unlimited).
- `--sleep` or `-s` - wait time between iterations, in milliseconds. Default value = 0.

## v4.6.14

### Security

This release contains security fixes.
For more information, see [the published security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2024-006-vulnerabilities-in-content-name-pattern-commerce-shop-and-varnish-vhost-templates).
For each of the following fixes, evaluate the vulnerability to determine whether you might have been affected.
If so, take appropriate action, for example by [revoking passwords](https://doc.ibexa.co/en/latest/users/passwords/#revoking-passwords) for all affected users.

#### <abbr title="Browser Reconnaissance & Exfiltration via Adaptive Compression of Hypertext">BREACH</abbr> vulnerability

The [BREACH](https://www.breachattack.com/) attack is a security vulnerability against HTTPS when using HTTP compression.

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

    Update your Varnish VCL file to align it with the [`vendor/ibexa/http-cache/docs/varnish/vcl/varnish6.vcl`](https://github.com/ibexa/http-cache/blob/4.6/docs/varnish/vcl/varnish6.vcl) file.

=== "Varnish 7"

    Update your Varnish VCL file to align it with the [`vendor/ibexa/http-cache/docs/varnish/vcl/varnish7.vcl`](https://github.com/ibexa/http-cache//blob/4.6/docs/varnish/vcl/varnish7.vcl) file.
    ```

If you're not using a reverse proxy like Varnish or Fastly, adjust the compressed `Content-Type` in the web server configuration.
For more information, see the [updated Apache and nginx template configuration](https://github.com/ibexa/post-install/pull/86/files).

#### XSS in Content name pattern

There are no additional update steps to execute.

#### Outdated version of jQuery in ibexa/commerce-shop package

Only users of the [old Commerce solution](update_from_4.3_old_commerce.md) are affected.
There are no additional update steps to execute.

### Other changes

#### Disable translations of identifiers in Product Catalog's categories

The possibility of translating identifiers and parent information for the Categories in Product Catalog might lead to data consistency issues.

Disable it by running the following migration:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/2024_07_25_07_00_non_translatable_product_categories.yaml --name=2024_07_25_07_00_non_translatable_product_categories.yaml
php bin/console ibexa:migrations:migrate --file=2024_07_25_07_00_non_translatable_product_categories.yaml
```

#### Update web server configuration

Adjust the web server configuration to prevent direct access to the `index.php` file when using URLs consisting of multiple path segments.

See [the updated Apache and nginx template files](https://github.com/ibexa/post-install/pull/70/files) for more information.

## v4.6.15

### Removed `symfony/orm-pack` and `symfony/serializer-pack` dependencies

This release no longer directly requires the `symfony/orm-pack` and `symfony/serializer-pack` Composer dependencies, which can remove some dependencies from your project during the update process.

If you rely on them in your project, for example by using Symfony's `ObjectNormalizer` to create your own REST endpoints, run the following command before updating [[= product_name_base =]] packages:

``` bash
composer require symfony/serializer-pack symfony/orm-pack
```

Then, verify that Symfony Flex installed the versions you were using before.

## v4.6.16

No additional steps needed.
