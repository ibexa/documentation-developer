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

!!! caution "Deprecation messages on PHP 8.2 and newer"

    To avoid deprecations when using PHP 8.2, 8.3, or 8.4, run the following commands:

    ``` bash
    composer config extra.runtime.error_handler "\\Ibexa\\Contracts\\Core\\MVC\\Symfony\\ErrorHandler\\Php82HideDeprecationsErrorHandler"
    composer dump-autoload
    ```

<!-- vale Ibexa.VariablesVersion = NO -->

!!! caution "Security advisories"

    If you encounter security advisories that prevent the update, see [Package security advisories](security_advisories.md#package-security-advisories).

## v4.6.1

No additional steps needed.

## v4.6.2

### Database update

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
This package is required by other packages, such as `ibexa/connector-actito` for [Transactional emails](https://doc.ibexa.co/en/4.6/commerce/transactional_emails/transactional_emails/), `ibexa/payment`, or `ibexa/user`.

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

### Database update

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

``` php
return [
    // ...
    Ibexa\Bundle\CoreSearch\IbexaCoreSearchBundle::class => ['all' => true],
];
```

## v4.6.13

This release comes with a command to clean up duplicated entries in the `ezcontentobject_attribute` table, which were created due to an issue related to previewing content in different languages.

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
If so, take appropriate action, for example by [revoking passwords](https://doc.ibexa.co/en/4.6/users/passwords/#revoking-passwords) for all affected users.

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

1\. Add the Composer dependency:

``` bash
composer require --dev ibexa/rector:^4.6
```

2\. Adjust the created `rector.php` configuration file to match your project structure

3\. Run Rector in the dry-run mode to preview the changes:

``` bash
vendor/bin/rector --dry-run
```

4\. Run Rector:

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

## v4.6.23

No additional steps needed.

## v4.6.24

### Database update

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.23-to-4.6.24.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.23-to-4.6.24.sql
    ```

## v4.6.25

### Form Builder performance fix: missing indexes on form submission data [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

In large production databases, the `ezform_form_submissions` and `ezform_form_submission_data` tables may contain a lot of rows.
Missing indexes can cause high CPU load and slow queries.

Run the provided SQL upgrade script to add the missing indexes to your database:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.24-to-4.6.25.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.24-to-4.6.25.sql
    ```

## v4.6.26

No additional steps needed.

## v4.6.27

### Elasticsearch 8 support

As of v4.6.27, [[= product_name =]] adds optional support for Elasticsearch 8.19 or higher through the new `ibexa/elasticsearch8` package.

By default, [[= product_name =]] continues to support Elasticsearch 7.16.2+ with the `ibexa/elasticsearch` package.
To use Elasticsearch 8, follow these steps:

#### Install Elasticsearch 8 package

Replace the existing Elasticsearch package and install Elasticsearch 8:

```bash
composer require ibexa/elasticsearch8:[[= latest_tag_4_6 =]] --with-all-dependencies
```

#### Update Elasticsearch server

Upgrade your Elasticsearch server to version 8.19 or higher.
For detailed instructions, follow the [Elasticsearch upgrade guide](https://www.elastic.co/guide/en/elastic-stack/8.19/upgrading-elastic-stack.html#prepare-to-upgrade).

When you use [[= product_name_cloud =]], see [Elasticsearch service](https://developer.upsun.com/docs/add-services/elasticsearch) for a list of supported versions.

#### Update configuration

Update your configuration in `config/packages/ibexa_elasticsearch.yaml` as described below:

##### Replace connection pool settings

The `connection_pool` and `connection_selector` settings are ignored when using Elasticsearch 8.
Replace them with appropriate `node_pool_selector` and `node_pool_resurrect` settings:

``` yaml
# Elasticsearch 7 configuration
ibexa_elasticsearch:
    connections:
        default:
            connection_pool: 'Elasticsearch\ConnectionPool\StaticNoPingConnectionPool'
            connection_selector: 'Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector'
```

``` yaml
# Elasticsearch 8 configuration
ibexa_elasticsearch:
    connections:
        default:
            node_pool_selector: 'Elastic\Transport\NodePool\Selector\RoundRobin'
            node_pool_resurrect: 'Elastic\Transport\NodePool\Resurrect\NoResurrect'
```

For more information, see [Connection pool and node pool settings](https://doc.ibexa.co/en/4.6/search/search_engines/elasticsearch/configure_elasticsearch/#connection-pool-and-node-pool-settings).

##### Remove trace option

The `trace` debugging option is no longer available in Elasticsearch 8:

``` yaml
# Elasticsearch 7 configuration
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            trace: true
```

``` yaml
# Elasticsearch 8 configuration
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            # Trace option is no longer available
```

#### Reindex content

After upgrading to Elasticsearch 8 and updating your configuration, reindex the search engine:

1. Push the index templates:

    ``` bash
    php bin/console ibexa:elasticsearch:put-index-template --overwrite
    ```

2. Reindex your content:

    ``` bash
    php bin/console ibexa:reindex
    ```

### Removed Composer dependencies

The following unused Composer dependencies have been removed from `ibexa/core`:

- `guzzlehttp/guzzle`
- `php-http/guzzle6-adapter`

If your project uses Guzzle directly, you should add these dependencies to your project's `composer.json` file.

To check if you need to add these dependencies, run:

```bash
composer why guzzlehttp/guzzle
composer why php-http/guzzle6-adapter
```

If only the `ibexa/core` entry appears in the output, check your codebase to determine if you use Guzzle directly.
If you do, add the required dependencies to your project:

```bash
composer require guzzlehttp/guzzle:^6.5 php-http/guzzle6-adapter:^2.0
```

### Messenger support in CDP

If you're using [CDP](cdp.md) and haven't configured Ibexa Messenger yet, do so now.
Follow the [Messenger setup instructions](https://doc.ibexa.co/en/4.6/infrastructure_and_maintenance/background_tasks/#install-package) to continue.

<!-- End of update instructions -->

[[% include 'snippets/update/notify_support.md' %]]

With the product updated to the latest version, you can now finish the update process or proceed to updating the LTS Updates packages.

## v4.6.28

### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Run the provided SQL upgrade script to adapt your database to latest change in [form builder](form_builder_guide.md)'s `max_length` validator behavior:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.27-to-4.6.28.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.27-to-4.6.28.sql
    ```

Prior, `0` was interpreted as "no length limit".
Now, `0` is interpreted as "length limited to zero characters" and `NULL` as "no length limit".

## v4.6.29

### GraphQL package update

The GraphQL dependency constraints have been updated to allow installing versions of `webonyx/graphql-php` that address the following security advisories:

- [GHSA-68jq-c3rv-pcrr](https://github.com/advisories/GHSA-68jq-c3rv-pcrr)
- [GHSA-fc86-6rv6-2jpm](https://github.com/advisories/GHSA-fc86-6rv6-2jpm)
- [GHSA-r7cg-qjjm-xhqq](https://github.com/advisories/GHSA-r7cg-qjjm-xhqq)

When doing the update, you have two options:

#### Update GraphQL packages and custom code (recommended)

Make sure the `webonyx/graphql-php` package is in version v15.32.3 or higher.

If you [extended GraphQL to support custom field types](graphql_custom_ft.md), update the returned expression from `@=resolver(...)` to `@=query(...)` and change the argument syntax from an array to variadic arguments as in the following example:

```diff
-return sprintf('@=resolver("MyFieldValue", [field, %s])', $myArg);
+return sprintf('@=query("MyFieldValue", field, %s)', $myArg);
```

Then, regenerate the GraphQL schema by running:

``` bash
rm -rf config/graphql/types/ibexa/
php bin/console ibexa:graphql:generate-schema
```

#### Implement other countermeasures

If updating the GraphQL packages isn't possible, for example, because the project is using PHP 7.4 where the fix is not available, review the security issues carefully and assess the danger.

If you choose to implement countermeasures without updating the GraphQL packages, for example by restricting access to the GraphQL endpoint with rate limiting, authentication, or [WAF](https://en.wikipedia.org/wiki/Web_application_firewall), you can silence the advisories in `composer.json`:

```json
"config": {
    "audit": {
        "ignore": {
            "GHSA-68jq-c3rv-pcrr": "Description of the countermeasures you've implemented causing this one to be safe to ignore.",
            "GHSA-fc86-6rv6-2jpm": "Description of the countermeasures you've implemented causing this one to be safe to ignore.",
            "GHSA-r7cg-qjjm-xhqq": "Description of the countermeasures you've implemented causing this one to be safe to ignore."
        }
    }
}
```

In addition, consider upgrading your project to one of [the actively supported PHP versions](/getting_started/requirements.md#php).

### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Run the provided SQL upgrade script to update your database:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.28-to-4.6.29.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.28-to-4.6.29.sql
    ```

## v4.6.30

### Update Twig to v3.26.0

For security reasons, it's highly recommenced to update `twig/twig` and `twig/intl-extra` to version v3.26.0 or higher.

For more information, see the following security advisories:

- PHP 8.0 and PHP 7.4
    - [PKSA-5k7f-wvjj-jrgw](https://packagist.org/security-advisories/PKSA-5k7f-wvjj-jrgw)
    - [PKSA-sjvz-tbbr-vwth](https://packagist.org/security-advisories/PKSA-sjvz-tbbr-vwth)
    - [PKSA-h8hf-ytnd-5t9q](https://packagist.org/security-advisories/PKSA-h8hf-ytnd-5t9q)
    - [PKSA-wwb1-81rc-pd65](https://packagist.org/security-advisories/PKSA-wwb1-81rc-pd65)
    - [PKSA-hgmw-wn4d-hpcy](https://packagist.org/security-advisories/PKSA-hgmw-wn4d-hpcy)
    - [PKSA-kvv6-36cr-fkzb](https://packagist.org/security-advisories/PKSA-kvv6-36cr-fkzb)
    - [PKSA-n14z-jjjg-g8vd](https://packagist.org/security-advisories/PKSA-n14z-jjjg-g8vd)
    - [PKSA-3mcc-k66d-pydb](https://packagist.org/security-advisories/PKSA-3mcc-k66d-pydb)
    - [PKSA-gw7n-z4yx-7xjt](https://packagist.org/security-advisories/PKSA-gw7n-z4yx-7xjt)
    - [PKSA-dpx1-78wg-1kqs](https://packagist.org/security-advisories/PKSA-dpx1-78wg-1kqs)
    - [PKSA-21g2-dzjv-sky5](https://packagist.org/security-advisories/PKSA-21g2-dzjv-sky5)
    - [PKSA-yhcn-xrg3-68b1](https://packagist.org/security-advisories/PKSA-yhcn-xrg3-68b1)
    - [PKSA-2wrf-1xmk-1pky](https://packagist.org/security-advisories/PKSA-2wrf-1xmk-1pky)
    - [PKSA-6319-ffpf-gx66](https://packagist.org/security-advisories/PKSA-6319-ffpf-gx66)
    - [PKSA-n7sg-8f52-pqtf](https://packagist.org/security-advisories/PKSA-n7sg-8f52-pqtf)
    - [PKSA-8kk8-h2xr-h5nx](https://packagist.org/security-advisories/PKSA-8kk8-h2xr-h5nx)
    - [PKSA-2rbx-bjdx-4d4d](https://packagist.org/security-advisories/PKSA-2rbx-bjdx-4d4d)
    - [PKSA-fs5b-x5k4-1h39](https://packagist.org/security-advisories/PKSA-fs5b-x5k4-1h39)
- PHP 7.4 only
    - [PKSA-fbvq-z33h-r2np](https://packagist.org/security-advisories/PKSA-fbvq-z33h-r2np)
    - [PKSA-g9zw-qxh8-pq8w](https://packagist.org/security-advisories/PKSA-g9zw-qxh8-pq8w)
    - [PKSA-yd6k-t2gh-1m43](https://packagist.org/security-advisories/PKSA-yd6k-t2gh-1m43)
    - [PKSA-1tmc-rt7x-12w6](https://packagist.org/security-advisories/PKSA-1tmc-rt7x-12w6)
    - [PKSA-xx6c-6d96-db2w](https://packagist.org/security-advisories/PKSA-xx6c-6d96-db2w)

To use these packages in versions not affected by security vulnerabilities, PHP 8.1 is the minimum required version.

For projects meeting this requirement, you can update the packages with Composer.

If you're using PHP 7.4 or 8.0, to do the [[= product_name =]] update, you have two options:

#### Update PHP, the custom code, then the platform (recommended)

Make sure to use PHP 8.1 or higher. Since PHP 8.1 has reached its End of Life (EOL), it's recommended that you use PHP 8.2 or higher.
Migrate custom code to be compatible with PHP 8.1 or higher, for example by using [Rector](https://github.com/rectorphp/rector).
Then, update Ibexa DXP.

#### Implement other countermeasures

If updating the Twig packages isn't possible, for example, because the project is using PHP 7.4 or 8.0 where the fixes are not available, review the security issues carefully and assess the danger.

If you choose to implement countermeasures without upgrading PHP and updating Twig, you can silence the advisories in `composer.json`.
For more information, see [Package security advisories](security_advisories.md#package-security-advisories).

In addition, consider upgrading your project to one of [the actively supported PHP versions](requirements.md#php).

## v4.6.31

No additional steps needed.

## v4.6.3X

### Database update

v4.6.3X introduces Ibexa Doctrine Migrations to manage database schema changes.
It replaces the previous usage of SQL files (like vendor/ibexa/installer/upgrade/db/<server>/ibexa-x.y.a-to-x.y.b.sql).

Run the following to run a basic schema check and store the database status.

```bash
php bin/console ibexa:doctrine:migrations:migrate
```

!!! caution

    Notice that this command isn't a full schema conformity checker.
    It tests the presence of key elements to determine if a previous change has been applied or not.
    If, in the past, you had incomplete schema upgrades, Ibexa Doctring Migrations command can be misled into considering a change as fully applied while it's only partially applied.

## v4.6.(3X+N)

### TODO: Add config for new feature, anything needed to have the console running again

### Database update

Run Ibexa Doctrine Migrations through the following command:

```bash
php bin/console ibexa:doctrine:migrations:migrate
```

## LTS Updates

[LTS Updates](https://doc.ibexa.co/en/4.6/ibexa_products/editions/#lts-updates) are standalone packages with their own update procedures.
To use the [latest features](ibexa_dxp_v4.6.md) added to them, update them separately with the following commands:

=== "Discounts"

    ### Discounts [[% include 'snippets/lts-update_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

    To install the [Discounts feature](discounts_guide.md), see the [installation instructions](https://doc.ibexa.co/en/4.6/discounts/install_discounts/).

    If you're already using it, run the following command to get the latest version of this feature:


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
    ### Discounts v4.6.24

    #### Database update

    Run the following scripts:

    === "MySQL"

        ``` sql
        ALTER TABLE ibexa_discount
            ADD indexed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)';

        CREATE INDEX ibexa_discount_indexed_at_idx
            ON ibexa_discount (indexed_at);
        ```

    === "PostgreSQL"

        ``` sql
        ALTER TABLE ibexa_discount
            ADD indexed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL;

        COMMENT ON COLUMN ibexa_discount.indexed_at IS '(DC2Type:datetime_immutable)';

        CREATE INDEX ibexa_discount_indexed_at_idx
            ON ibexa_discount (indexed_at);
        ```

=== "AI Actions"

    ### AI Actions [[% include 'snippets/lts-update_badge.md' %]]

    To install the [AI actions feature](ai_actions_guide.md), see the [installation instructions](https://doc.ibexa.co/en/4.6/ai_actions/install_ai_actions/).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/connector-ai:[[= latest_tag_4_6 =]] ibexa/connector-openai:[[= latest_tag_4_6 =]]
    ```

=== "Date and time attribute"

    ### Date and time attribute [[% include 'snippets/lts-update_badge.md' %]]

    To install the [Date and time attribute](date_and_time.md), see the [installation instructions](https://doc.ibexa.co/en/4.6/pim/attributes/date_and_time/#installation).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/product-catalog-date-time-attribute:[[= latest_tag_4_6 =]]
    ```

=== "Symbol attribute"

    ### Symbol attribute [[% include 'snippets/lts-update_badge.md' %]]

    To install the [Symbol attribute](symbol_attribute_type.md), see the [installation instructions](https://doc.ibexa.co/en/4.6/pim/attributes/symbol_attribute_type/#installation).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/product-catalog-symbol-attribute:[[= latest_tag_4_6 =]]
    ```

=== "Integrated help"

    ### Integrated help [[% include 'snippets/lts-update_badge.md' %]]

    See [Integrated help](integrated_help.md) for more information.

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/integrated-help:[[= latest_tag_4_6 =]]
    ```

=== "Collaborative editing"

    ### Collaborative editing [[% include 'snippets/lts-update_badge.md' %]]

    To learn more about the [Collaborative editing](https://doc.ibexa.co/en/4.6/content_management/collaborative_editing/collaborative_editing_guide/), see the [installation instructions](https://doc.ibexa.co/en/4.6/content_management/collaborative_editing/install_collaborative_editing).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/share:[[= latest_tag_4_6 =]] ibexa/collaboration:[[= latest_tag_4_6 =]]
    ```

    If you're using the Real-time collaborative editing, in addition run:

    ```bash
    composer require ibexa/fieldtype-richtext-rte:[[= latest_tag_4_6 =]] ibexa/ckeditor-premium:[[= latest_tag_4_6 =]]
    ```
