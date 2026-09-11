# Update with old Commerce packages

Update procedure to v4.4 for people who use deprecated Commerce packages and want to keep them.

This update procedure applies if you have a v4.3 installation, you use Commerce packages and would like to continue to use them.

All commerce packages as of v4.4 are deprecated and will be removed in v5. Until that time, they will be maintained by Ibexa with fixes, including security fixes, but they won't be further developed. Old packages are replaced by [the all-new Ibexa Commerce packages](../../../release_notes/ibexa_dxp_v4.4/index.md#all-new-ibexa-commerce-packages).

> **Caution: Temporary need of Composerconflict**
>
> To go through this update, [map the conflicting packages](https://getcomposer.org/doc/04-schema.md#conflict) in your `composer.json` file as following:
>
> ```json
> "conflict": {
>     "jms/serializer": ">=3.30.0",
>     "gedmo/doctrine-extensions": ">=3.12.0"
> },
> ```
>
> These entries can be removed after fully upgrading to v4.6 LTS.

## Update from v4.3.x to v4.3.latest

Before you update to v4.4, you need to go through the following steps to update to the latest maintenance release of v4.3 (v4.3.5).

### Update the application to v4.3.latest

Run:

**Ibexa Content**

```bash
composer require ibexa/content:4.3.5 --with-all-dependencies --no-scripts
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.3.5 --with-all-dependencies --no-scripts
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.3.5 --with-all-dependencies --no-scripts
```

## Update from v4.3.latest to v4.4

When you have the latest version of v4.3, you can update to v4.4.

### Update the application to v4.4

First, run:

**Ibexa Content**

```bash
composer require ibexa/content:4.4.4 --with-all-dependencies --no-scripts
composer recipes:install ibexa/content --force -v
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.4.4 --with-all-dependencies --no-scripts
composer recipes:install ibexa/experience --force -v
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.4.4 --with-all-dependencies --no-scripts
composer recipes:install ibexa/commerce --force -v
```

The `recipes:install` command installs new YAML configuration files. Review the old YAML files and move your custom configuration to the relevant new files.

#### Flysystem v2

Local adapters' `directory` key changed to `location`. It's defined in `config/packages/oneup_flysystem.yaml`:

```yaml
oneup_flysystem:
    adapters:
        default_adapter:
            local:
                location: '%kernel.cache_dir%/flysystem'
```

If you haven't applied custom changes to that file, you can reset third-party `oneup/flysystem-bundle` recipe by executing:

```bash
composer recipe:install --force --reset -- oneup/flysystem-bundle
```

### Add `ibexa/commerce-*` packages dependencies

Add the following dependencies in the `require` section in `composer.json`:

**Ibexa Content**

```json
"require":{
    "ibexa/commerce-base-design": "4.4.0",
    "ibexa/commerce-checkout": "4.4.0",
    "ibexa/commerce-fieldtypes": "4.4.0",
    "ibexa/commerce-price-engine": "4.4.0",
    "ibexa/commerce-shop": "4.4.0",
    "ibexa/commerce-shop-ui": "4.4.0",
    "ezsystems/apache-tika-bundle": "^2.0",
    "ezsystems/comment-bundle": "^3.1",
    "ezsystems/job-queue-bundle": "^4.0",
    "ezsystems/payment-core-bundle": "^3.0",
    "ezsystems/stash-bundle": "^0.9",
}
```

**Ibexa Experience**

```json
"require":{
    "ibexa/commerce-base-design": "4.4.0",
    "ibexa/commerce-checkout": "4.4.0",
    "ibexa/commerce-fieldtypes": "4.4.0",
    "ibexa/commerce-price-engine": "4.4.0",
    "ibexa/commerce-shop": "4.4.0",
    "ibexa/commerce-shop-ui": "4.4.0",
    "ezsystems/apache-tika-bundle": "^2.0",
    "ezsystems/comment-bundle": "^3.1",
    "ezsystems/job-queue-bundle": "^4.0",
    "ezsystems/payment-core-bundle": "^3.0",
    "ezsystems/stash-bundle": "^0.9",
}
```

**Ibexa Commerce**

```json
"require":{
    "ibexa/commerce-base-design": "4.4.0",
    "ibexa/commerce-checkout": "4.4.0",
    "ibexa/commerce-fieldtypes": "4.4.0",
    "ibexa/commerce-price-engine": "4.4.0",
    "ibexa/commerce-shop": "4.4.0",
    "ibexa/commerce-shop-ui": "4.4.0",
    "ezsystems/apache-tika-bundle": "^2.0",
    "ezsystems/comment-bundle": "^3.1",
    "ezsystems/job-queue-bundle": "^4.0",
    "ezsystems/payment-core-bundle": "^3.0",
    "ezsystems/stash-bundle": "^0.9",
    "ibexa/commerce-admin-ui": "4.4.0",
    "ibexa/commerce-erp-admin": "4.4.0",
    "ibexa/commerce-order-history": "4.4.0",
    "ibexa/commerce-page-builder": "4.4.0",
    "ibexa/commerce-rest": "4.4.0",
    "ibexa/commerce-transaction": "4.4.0"
}
```

Next, remove the entries with new packages alongside with routing and configuration in `config/routes/ibexa_cart.yaml`, `config/routes/ibexa_checkout.yaml` and `config/routes/ibexa_storefront.yaml`:

```php
    Ibexa\Bundle\Cart\IbexaCartBundle::class => ['all' => true],
    Ibexa\Bundle\Checkout\IbexaCheckoutBundle::class => ['all' => true],
    Ibexa\Bundle\Storefront\IbexaStorefrontBundle::class => ['all' => true],
```

Finally, remove the new `storefront_group` SiteAccess from `config/packages/ibexa.yaml`:

```yaml
ibexa:
    siteaccess:
        groups:
            site_group: [import, site]
            storefront_group: [site]
```

### Update the database

Next, update the database if you're using Ibexa Commerce. Ibexa Content and Ibexa Experience don't require the database update.

> **Caution: Caution**
>
> Always back up your data before running any database update scripts.
>
> After updating the database, clear the cache.
>
> Don't use `--force` argument for `mysql` / `psql` commands when performing update queries. If there is any problem during the update, it's best if the query fails immediately, so you can fix the underlying problem before you execute the update again. If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.

Apply the following database update scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.3.latest-to-4.4.0.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.3.latest-to-4.4.0.sql
```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade isn't necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips), unless you can verify based on your log files that the vulnerability has not been exploited, you should [revoke passwords](https://doc.ibexa.co/en/4.6/users/passwords/#revoking-passwords) for all affected users.

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```

## Run data migration

### Customer Portal self-registration

If you're using Ibexa Experience or Ibexa Commerce, run data migration required by the Customer Portal applications feature:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/application_internal_fields.yaml --name=2022_11_07_22_46_application_internal_fields.yaml
php bin/console ibexa:migrations:migrate --file=2022_11_07_22_46_application_internal_fields.yaml
```
