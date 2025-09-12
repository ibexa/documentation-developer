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

!!! caution

    To avoid deprecations when using PHP 8.2 or 8.3, run the following commands:

    ``` bash
    composer config extra.runtime.error_handler "\\Ibexa\\Contracts\\Core\\MVC\\Symfony\\ErrorHandler\\Php82HideDeprecationsErrorHandler"
    composer dump-autoload
    ```

<!-- vale Ibexa.VariablesVersion = NO -->

## v4.6.1

No additional steps needed.

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

## v4.6.5

No additional steps needed.

## v4.6.6

No additional steps needed.

## v4.6.7

No additional steps needed.

## v4.6.8

No additional steps needed.

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

## v4.6.17

### Security

This release contains security fixes.
For more information, see [the published security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-001-vulnerabilities-in-shopping-cart-and-publish-unscheduling).
For each of the following fixes, evaluate the vulnerability to determine whether you might have been affected.
If so, take appropriate action.

#### CartOwner permission limitation exposes carts

This release fixes a critical vulnerability in the REST API regarding shopping carts.
There are no additional update steps to execute.

#### Unauthorized user can cancel scheduled publish events

This release fixes vulnerability in publish scheduling, ensures that `edit/create` policies are correctly checked.
There are no additional update steps to execute.

#### Dependency upgrades

This release upgrades the requirements for [Twig to v3.19](https://github.com/twigphp/Twig/security/advisories/GHSA-3xg3-cgvq-2xwr) and [PHPSpreadsheet to v1.29.9](https://github.com/PHPOffice/PhpSpreadsheet/security), resolving several vulnerabilities of varying severity in those dependencies.
There are no additional update steps to execute.

## v4.6.18

No additional steps needed.

## v4.6.19

### Security

This release fixes a critical vulnerability in the [RichText field type](richtextfield.md).
By entering a maliciously crafted input into the RichText field type's XML, the attacker could perform an attack using [XML external entity (XXE) injection](https://portswigger.net/web-security/xxe). 
To exploit this vulnerability, an attacker would need to have edit permission to content with RichText fields.

For more information, see the [published security advisory IBEXA-SA-2025-002](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-002-xxe-vulnerability-in-richtext).

Evaluate the vulnerability to determine whether you might have been affected.
If so, take appropriate action.
There are no additional update steps to execute.

### [[= product_name_base =]] Rector

The new [Ibexa Rector](https://github.com/ibexa/rector/) package is now available.
It's an optional package based on [Rector](https://getrector.com/) and comes with additional rules for working with Ibexa code.

You can use it to get rid of PHP code deprecations and start preparing your project for the next major release.

!!! note

    [[= product_name_base =]] Rector requires PHP 8.3 and you must upgrade your codebase first.
    To do it, you can use Rector and the [existing PHP upgrade sets](https://getrector.com/documentation/integration-to-new-project#content-2-upgrade-php-first).

To get started with [[= product_name_base =]] Rector, execute the following steps:

1. Add the Composer dependency:
``` bash
composer require --dev ibexa/rector:^4.6
```

2. Adjust the created `rector.php` configuration file to match your project structure

3. Run Rector in the dry-run mode to preview the changes: 
``` bash
vendor/bin/rector --dry-run
```

4. Run Rector:
``` bash
vendor/bin/rector
```

## v4.6.20

No additional steps needed.

## v4.6.21

### Security

This security advisory resolves XSS vulnerabilities in several parts of the back office of the DXP.
Back office access and varying levels of editing and management permissions are required to exploit these vulnerabilities.

For more information, see the [security advisory IBEXA-SA-2025-003](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-003-xss-vulnerabilities-in-back-office).

Evaluate the vulnerability to determine whether you might have been affected.
If so, take appropriate action.
There are no additional update steps to execute.

### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.20-to-4.6.21.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.20-to-4.6.21.sql
    ```

## v4.6.22

### Added support for Solr 9

This release adds support for [Solr 9](requirements.md#search).

To update Solr within an existing [[= product_name =]] project, first refer to the [Solr 9 upgrade planning](https://solr.apache.org/guide/solr/latest/upgrade-notes/major-changes-in-solr-9.html) instructions.

Then, follow the [instructions for setting up Solr 9 with [[= product_name =]]](/search/search_engines/solr_search_engine/install_solr.md#configure-and-start-solr) and merge them with your custom configuration.

Changes include:

1. Configuration files

    - the `schema.xml` configuration file became [`managed-schema.xml`](https://solr.apache.org/guide/solr/latest/upgrade-notes/major-changes-in-solr-6.html#managed-schema-is-now-the-default)
    - the [removed `LatLonType` field is replaced by the `LatLonPointSpatialField` field](https://solr.apache.org/guide/solr/latest/upgrade-notes/major-changes-in-solr-7.html#deprecations-and-removed-features)

2. New [Solr version parameter](install_solr.md#configure-solr-version)

Once Solr 9 is fully configured, [refresh the search index](reindex_search.md).

### Set character set for activity log tables [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

When using MySQL or MariaDB, run the following script to ensure correct character set for activity log tables:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.21-to-4.6.22.sql
    ```

[[% include 'snippets/update/notify_support.md' %]]

With the product updated to the latest version, you can now finish the update process or proceed to updating the LTS Updates packages.

## LTS Updates

[LTS Updates](https://doc.ibexa.co/en/4.6/ibexa_products/editions/#lts-updates) are standalone packages with their own update procedures.
To use the [latest features](ibexa_dxp_v4.6.md) added to them, update them separately with the following commands:

=== "Discounts"

    Run the following command to get the latest version:

    ```bash
    composer require ibexa/discounts:[[= latest_tag_4_6 =]] ibexa/discounts-codes:[[= latest_tag_4_6 =]]
    ```

    Then apply manually the changes described below.

    ### Discounts v4.6.20

    #### Policy changes

    The `discount/view` policy is no longer required for the store customers to use a discount and must be removed from all users who are not managing discounts.
    The policy allows to access all the discount details, including the coupon codes to activate them, which could lead to system abuse.

    To learn more, see the [discounts policies overview](https://doc.ibexa.co/en/4.6/permissions/policies/).

    #### Database update

    Run the following scripts:

    === "MySQL"

        ``` sql
        CREATE TABLE ibexa_discount_code_usage (
            id INT AUTO_INCREMENT NOT NULL,
            discount_code_id INT NOT NULL,
            order_id INT NOT NULL,
            discriminator VARCHAR(10) NOT NULL,
            used_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
            INDEX ibexa_discount_code_usage_discount_code_idx (discount_code_id),
            INDEX ibexa_discount_code_usage_order_idx (order_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

        CREATE TABLE ibexa_discount_code_usage_email (
            id INT NOT NULL,
            user_email VARCHAR(190) DEFAULT NULL,
            INDEX ibexa_discount_code_usage_email_idx (user_email),
            UNIQUE INDEX ibexa_discount_codes_usage_email_uidx (id, user_email),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

        CREATE TABLE ibexa_discount_code_usage_user (
            id INT NOT NULL,
            user_id INT DEFAULT NULL,
            INDEX ibexa_discount_code_usage_user_idx (user_id),
            UNIQUE INDEX ibexa_discount_codes_usage_user_uidx (id, user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

        ALTER TABLE ibexa_discount_code_usage
            ADD CONSTRAINT ibexa_discount_code_usage_code_fk FOREIGN KEY (discount_code_id)
                REFERENCES ibexa_discount_code (id) ON UPDATE CASCADE ON DELETE CASCADE;

        ALTER TABLE ibexa_discount_code_usage
            ADD CONSTRAINT ibexa_discount_code_usage_order_fk FOREIGN KEY (order_id)
                REFERENCES ibexa_order (id) ON UPDATE CASCADE ON DELETE CASCADE;

        ALTER TABLE ibexa_discount_code_usage_email
            ADD CONSTRAINT ibexa_discount_code_usage_email_fk FOREIGN KEY (id)
                REFERENCES ibexa_discount_code_usage (id) ON UPDATE CASCADE ON DELETE CASCADE;

        ALTER TABLE ibexa_discount_code_usage_user
            ADD CONSTRAINT ibexa_discount_code_usage_user_fk FOREIGN KEY (id)
                REFERENCES ibexa_discount_code_usage (id) ON UPDATE CASCADE ON DELETE CASCADE;

        ALTER TABLE ibexa_discount_code_usage_user
            ADD CONSTRAINT ibexa_discount_code_usage_user_content_fk FOREIGN KEY (user_id)
                REFERENCES ezuser (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE;
        ```

    === "PostgreSQL"

        ``` sql
        CREATE TABLE ibexa_discount_code_usage
        (
            id SERIAL NOT NULL,
            discount_code_id INT NOT NULL,
            order_id INT NOT NULL,
            discriminator VARCHAR(10) NOT NULL,
            used_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        );

        CREATE INDEX ibexa_discount_code_usage_discount_code_idx
            ON ibexa_discount_code_usage (discount_code_id);

        CREATE INDEX ibexa_discount_code_usage_order_idx
            ON ibexa_discount_code_usage (order_id);

        COMMENT ON COLUMN ibexa_discount_code_usage.used_at IS '(DC2Type:datetime_immutable)';

        CREATE TABLE ibexa_discount_code_usage_email (
            id INT NOT NULL,
            user_email VARCHAR(190) DEFAULT NULL,
            PRIMARY KEY(id)
        );

        CREATE INDEX ibexa_discount_code_usage_email_idx
            ON ibexa_discount_code_usage_email (user_email);

        CREATE UNIQUE INDEX ibexa_discount_codes_usage_email_uidx
            ON ibexa_discount_code_usage_email (id, user_email);

        CREATE TABLE ibexa_discount_code_usage_user
        (
            id INT NOT NULL,
            user_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        );

        CREATE INDEX ibexa_discount_code_usage_user_idx
            ON ibexa_discount_code_usage_user (user_id);

        CREATE UNIQUE INDEX ibexa_discount_codes_usage_user_uidx
            ON ibexa_discount_code_usage_user (id, user_id);

        ALTER TABLE ibexa_discount_code_usage
            ADD CONSTRAINT ibexa_discount_code_usage_code_fk FOREIGN KEY (discount_code_id)
                REFERENCES ibexa_discount_code (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

        ALTER TABLE ibexa_discount_code_usage
            ADD CONSTRAINT ibexa_discount_code_usage_order_fk FOREIGN KEY (order_id)
                REFERENCES ibexa_order (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

        ALTER TABLE ibexa_discount_code_usage_email
            ADD CONSTRAINT ibexa_discount_code_usage_email_fk FOREIGN KEY (id)
                REFERENCES ibexa_discount_code_usage (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

        ALTER TABLE ibexa_discount_code_usage_user
            ADD CONSTRAINT ibexa_discount_code_usage_user_fk FOREIGN KEY (id)
                REFERENCES ibexa_discount_code_usage (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

        ALTER TABLE ibexa_discount_code_usage_user
            ADD CONSTRAINT ibexa_discount_code_usage_user_content_fk FOREIGN KEY (user_id)
                REFERENCES ezuser (contentobject_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
        ```

    ### Discounts v4.6.22

    #### Database update

    Run the following scripts:

    === "MySQL"

        ``` sql
        ALTER TABLE ibexa_discount ADD override_prioritization tinyint(1) NOT NULL DEFAULT 0;
        CREATE INDEX ibexa_discount_prioritization_idx ON ibexa_discount (override_prioritization, type, priority);
        ALTER TABLE ibexa_discount_code ADD global_limit INT DEFAULT NULL;
        ```

    === "PostgreSQL"

        ``` sql
        ALTER TABLE ibexa_discount ADD override_prioritization tinyint(1) NOT NULL DEFAULT 0;
        CREATE INDEX ibexa_discount_prioritization_idx ON ibexa_discount (override_prioritization, type, priority);
        ALTER TABLE ibexa_discount_code ADD global_limit INT DEFAULT NULL;
        ```

=== "AI actions"

    Run the following command to get the latest version:

    ```bash
    composer require ibexa/connector-ai:[[= latest_tag_4_6 =]] ibexa/connector-openai:[[= latest_tag_4_6 =]]
    ```

=== "Date and time attribute"

    Run the following command to get the latest version:

    ```bash
    composer require ibexa/product-catalog-date-time-attribute:[[= latest_tag_4_6 =]]
    ```

## v4.6.23

No additional steps needed.
