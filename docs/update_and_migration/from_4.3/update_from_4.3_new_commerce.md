---
description: Update procedure to v4.4 for people who don't use Commerce packages and can remove them.
month_change: false
---
# Update with new Commerce packages

This update procedure applies if you have a v4.3 installation, and you don't use Commerce packages.

[[% include 'snippets/update/temporary_v4_conflicts.md' %]]

## Update from v4.3.x to v4.3.latest

Before you update to v4.4, you need to go through the following steps to update to the latest maintenance release of v4.3 (v[[= latest_tag_4_3 =]]).

### Update the application to v4.3.latest

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```

## Remove deprecated field types

By default, every v4.3 installation has a set of built-in content types.
Some of them use field types deprecated in v4.4, which need to be removed manually.
Make sure to remove all occurrences of `sesspecificationstype`, `uivarvarianttype`, `sesselection`, `sesprofiledata` field types from your content types.

This step should be performed on the working installation, omitting it results in an error during update:

```
  [Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\Exception\NotFound (404)]
  Could not find 'Persistence Field Value Converter' with identifier 'sesspecificationstype'
```

In that case, you can use [Null field type](nullfield.md) to define a replacement for deprecated field types in `config/services.yaml`:

```yaml
services:
    ibexa.field_type.sesspecificationstype:
        class: Ibexa\Core\FieldType\Null\Type
        arguments: [sesspecificationstype]
        tags: [{name: ibexa.field_type, alias: sesspecificationstype}]
    ibexa.field_type.sesspecificationstype.converter:
        class: Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ibexa.field_type.storage.legacy.converter, alias: sesspecificationstype}]
    ibexa.field_type.sesspecificationstype.indexable:
        class: Ibexa\Core\FieldType\Unindexed
        tags: [{name: ibexa.field_type.indexable, alias: sesspecificationstype}]
        
    ibexa.field_type.uivarvarianttype:
        class: Ibexa\Core\FieldType\Null\Type
        arguments: [uivarvarianttype]
        tags: [{name: ibexa.field_type, alias: uivarvarianttype}]
    ibexa.field_type.uivarvarianttype.converter:
        class: Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ibexa.field_type.storage.legacy.converter, alias: uivarvarianttype}]
    ibexa.field_type.uivarvarianttype.indexable:
        class: Ibexa\Core\FieldType\Unindexed
        tags: [{name: ibexa.field_type.indexable, alias: uivarvarianttype}]

    ibexa.field_type.sesselection:
        class: Ibexa\Core\FieldType\Null\Type
        arguments: [sesselection]
        tags: [{name: ibexa.field_type, alias: sesselection}]
    ibexa.field_type.sesselection.converter:
        class: Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ibexa.field_type.storage.legacy.converter, alias: sesselection}]
    ibexa.field_type.sesselection.indexable:
        class: Ibexa\Core\FieldType\Unindexed
        tags: [{name: ibexa.field_type.indexable, alias: sesselection}]

    ibexa.field_type.sesprofiledata:
        class: Ibexa\Core\FieldType\Null\Type
        arguments: [sesprofiledata]
        tags: [{name: ibexa.field_type, alias: sesprofiledata}]
    ibexa.field_type.sesprofiledata.converter:
        class: Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ibexa.field_type.storage.legacy.converter, alias: sesprofiledata}]
    ibexa.field_type.sesprofiledata.indexable:
        class: Ibexa\Core\FieldType\Unindexed
        tags: [{name: ibexa.field_type.indexable, alias: sesprofiledata}]
```

## Update from v4.3.latest to v4.4

When you have the latest version of v4.3, you can update to v4.4.

### Update the application to v4.4

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files

### Flysystem v2

Local adapters' `directory` key changed to `location`.
It's defined in `config/packages/oneup_flysystem.yaml`:

```yaml
oneup_flysystem:
    adapters:
        default_adapter:
            local:
                location: '%kernel.cache_dir%/flysystem'
```
If you haven't applied custom changes to that file,
you can reset the third-party `oneup/flysystem-bundle` recipe by executing:

```bash
composer recipe:install --force --reset -- oneup/flysystem-bundle
```

### Remove `ibexa/commerce-*` packages with dependencies

Remove the following bundles from `config/bundles.php`.
You don't have to remove third-party bundles (`FOS\` to `JMS\`) if they're used by your installation.

=== "[[= product_name_content =]]"

    ``` php
    FOS\CommentBundle\FOSCommentBundle
    Tedivm\StashBundle\TedivmStashBundle
    WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle
    Nelmio\SolariumBundle\NelmioSolariumBundle
    JMS\Payment\CoreBundle\JMSPaymentCoreBundle
    Joli\ApacheTikaBundle\ApacheTikaBundle
    JMS\JobQueueBundle\JMSJobQueueBundle
    FOS\RestBundle\FOSRestBundle
    JMS\SerializerBundle\JMSSerializerBundle
    Ibexa\Bundle\Commerce\Eshop\IbexaCommerceEshopBundle
    Ibexa\Bundle\Commerce\ShopTools\IbexaCommerceShopToolsBundle
    Ibexa\Bundle\Commerce\Translation\IbexaCommerceTranslationBundle
    Ibexa\Bundle\Commerce\Payment\IbexaCommercePaymentBundle
    Ibexa\Bundle\Commerce\Price\IbexaCommercePriceBundle
    Ibexa\Bundle\Commerce\Tools\IbexaCommerceToolsBundle
    Ibexa\Bundle\Commerce\Search\IbexaCommerceSearchBundle
    Ibexa\Bundle\Commerce\PriceEngine\IbexaCommercePriceEngineBundle
    Ibexa\Bundle\Commerce\SpecificationsType\IbexaCommerceSpecificationsTypeBundle
    Ibexa\Bundle\Commerce\BaseDesign\IbexaCommerceBaseDesignBundle
    Ibexa\Bundle\Commerce\FieldTypes\IbexaCommerceFieldTypesBundle
    Ibexa\Bundle\Commerce\Checkout\IbexaCommerceCheckoutBundle
    Ibexa\Bundle\Commerce\ShopUi\IbexaCommerceShopUiBundle
    ```

=== "[[= product_name_exp =]]"

    ``` php
    FOS\CommentBundle\FOSCommentBundle
    Tedivm\StashBundle\TedivmStashBundle
    WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle
    Nelmio\SolariumBundle\NelmioSolariumBundle
    JMS\Payment\CoreBundle\JMSPaymentCoreBundle
    Joli\ApacheTikaBundle\ApacheTikaBundle
    JMS\JobQueueBundle\JMSJobQueueBundle
    FOS\RestBundle\FOSRestBundle
    JMS\SerializerBundle\JMSSerializerBundle
    Ibexa\Bundle\Commerce\Eshop\IbexaCommerceEshopBundle
    Ibexa\Bundle\Commerce\ShopTools\IbexaCommerceShopToolsBundle
    Ibexa\Bundle\Commerce\Translation\IbexaCommerceTranslationBundle
    Ibexa\Bundle\Commerce\Payment\IbexaCommercePaymentBundle
    Ibexa\Bundle\Commerce\Price\IbexaCommercePriceBundle
    Ibexa\Bundle\Commerce\Tools\IbexaCommerceToolsBundle
    Ibexa\Bundle\Commerce\Search\IbexaCommerceSearchBundle
    Ibexa\Bundle\Commerce\PriceEngine\IbexaCommercePriceEngineBundle
    Ibexa\Bundle\Commerce\SpecificationsType\IbexaCommerceSpecificationsTypeBundle
    Ibexa\Bundle\Commerce\BaseDesign\IbexaCommerceBaseDesignBundle
    Ibexa\Bundle\Commerce\FieldTypes\IbexaCommerceFieldTypesBundle
    Ibexa\Bundle\Commerce\Checkout\IbexaCommerceCheckoutBundle
    Ibexa\Bundle\Commerce\ShopUi\IbexaCommerceShopUiBundle
    ```

=== "[[= product_name_com =]]"

    ``` php
    FOS\CommentBundle\FOSCommentBundle
    Tedivm\StashBundle\TedivmStashBundle
    WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle
    Nelmio\SolariumBundle\NelmioSolariumBundle
    JMS\Payment\CoreBundle\JMSPaymentCoreBundle
    Joli\ApacheTikaBundle\ApacheTikaBundle
    JMS\JobQueueBundle\JMSJobQueueBundle
    FOS\RestBundle\FOSRestBundle
    JMS\SerializerBundle\JMSSerializerBundle
    Ibexa\Bundle\Commerce\Eshop\IbexaCommerceEshopBundle
    Ibexa\Bundle\Commerce\ShopTools\IbexaCommerceShopToolsBundle
    Ibexa\Bundle\Commerce\Translation\IbexaCommerceTranslationBundle
    Ibexa\Bundle\Commerce\Payment\IbexaCommercePaymentBundle
    Ibexa\Bundle\Commerce\Price\IbexaCommercePriceBundle
    Ibexa\Bundle\Commerce\Tools\IbexaCommerceToolsBundle
    Ibexa\Bundle\Commerce\Search\IbexaCommerceSearchBundle
    Ibexa\Bundle\Commerce\PriceEngine\IbexaCommercePriceEngineBundle
    Ibexa\Bundle\Commerce\SpecificationsType\IbexaCommerceSpecificationsTypeBundle
    Ibexa\Bundle\Commerce\BaseDesign\IbexaCommerceBaseDesignBundle
    Ibexa\Bundle\Commerce\FieldTypes\IbexaCommerceFieldTypesBundle
    Ibexa\Bundle\Commerce\Checkout\IbexaCommerceCheckoutBundle
    Ibexa\Bundle\Commerce\ShopUi\IbexaCommerceShopUiBundle
    # ...
    Ibexa\Bundle\Commerce\OneSky\IbexaCommerceOneSkyBundle
    Ibexa\Bundle\Commerce\EzStudio\IbexaCommerceEzStudioBundle
    Ibexa\Bundle\Commerce\Comparison\IbexaCommerceComparisonBundle
    Ibexa\Bundle\Commerce\QuickOrder\IbexaCommerceQuickOrderBundle
    Ibexa\Bundle\Commerce\TestTools\IbexaCommerceTestToolsBundle
    Ibexa\Bundle\Commerce\Voucher\IbexaCommerceVoucherBundle
    Ibexa\Bundle\Commerce\LocalOrderManagement\IbexaCommerceLocalOrderManagementBundle
    Ibexa\Bundle\Commerce\Newsletter\IbexaCommerceNewsletterBundle
    Ibexa\Bundle\Commerce\OrderHistory\IbexaCommerceOrderHistoryBundle
    Ibexa\Bundle\Commerce\ErpAdmin\IbexaCommerceErpAdminBundle
    Ibexa\Bundle\Commerce\ShopFrontend\IbexaCommerceShopFrontendBundle
    Ibexa\Bundle\Commerce\Basket\IbexaCommerceBasketBundle::class
    Ibexa\Bundle\Commerce\Rest\IbexaCommerceRestBundle::class
    Ibexa\Bundle\Commerce\AdminUi\IbexaCommerceAdminUiBundle::class
    Ibexa\Bundle\Commerce\PageBuilder\IbexaCommercePageBuilderBundle::class
    EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle::class
    ```

Next, remove related extensions' configuration.
You don't have to remove third-party bundles (for example `config/packages/fos_rest.yaml`) if they're used by your installation.

=== "[[= product_name_content =]]"

    ``` 
    config/packages/commerce.yaml
    config/packages/commerce/autogenerated/.gitkeep
    config/packages/commerce/commerce.yaml
    config/packages/commerce/commerce_advanced.yaml
    config/packages/commerce/commerce_common.yaml
    config/packages/commerce/commerce_demo.yaml
    config/packages/commerce/commerce_parameters.yaml
    config/packages/nelmio_solarium.yaml
    ```

=== "[[= product_name_exp =]]"

    ```
    config/packages/commerce.yaml
    config/packages/commerce/autogenerated/.gitkeep
    config/packages/commerce/commerce.yaml
    config/packages/commerce/commerce_advanced.yaml
    config/packages/commerce/commerce_common.yaml
    config/packages/commerce/commerce_demo.yaml
    config/packages/commerce/commerce_parameters.yaml
    config/packages/nelmio_solarium.yaml
    ```

=== "[[= product_name_com =]]"

    ```
    config/packages/commerce.yaml
    config/packages/commerce/autogenerated/.gitkeep
    config/packages/commerce/commerce.yaml
    config/packages/commerce/commerce_advanced.yaml
    config/packages/commerce/commerce_common.yaml
    config/packages/commerce/commerce_demo.yaml
    config/packages/commerce/commerce_parameters.yaml
    config/packages/dev/ewz_recaptcha.yaml
    config/packages/dev/jms_serializer.yaml
    config/packages/ewz_recaptcha.yaml
    config/packages/ezcommerce/autogenerated/commerce_repository_parameters.yaml
    config/packages/fos_rest.yaml
    config/packages/google_recaptcha.yaml
    config/packages/jms_serializer.yaml
    config/packages/nelmio_solarium.yaml
    config/packages/prod/jms_serializer.yaml
    ```

Finally, remove related routes by deleting `config/routes/ibexa_commerce.yaml` file.

### Update the database

Next, update the database if you're using [[= product_name_com =]].
[[= product_name_content =]] and [[= product_name_exp =]] don't require the database update.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.3.latest-to-4.4.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.3.latest-to-4.4.0.sql
    ```

If you used old Commerce packages before, and have migrated everything, you can remove the old tables.
The tables that can be removed are prefixed with `ses_` and `sve_`.

=== "MySQL"

    To switch to the right database, issue the following command:
    ``` sql
    USE <database_name>;
    ```

    Then, to remove all the old tables, run the following queries:
    ``` sql
    DROP TABLE IF EXISTS ses_basket;
    DROP TABLE IF EXISTS ses_basket_line;
    DROP TABLE IF EXISTS ses_content_modification_queue;
    DROP TABLE IF EXISTS ses_customer_prices;
    DROP TABLE IF EXISTS ses_customer_sku;
    DROP TABLE IF EXISTS ses_download;
    DROP TABLE IF EXISTS ses_externaldata;
    DROP TABLE IF EXISTS ses_gdpr_log;
    DROP TABLE IF EXISTS ses_invoice;
    DROP TABLE IF EXISTS ses_log_erp;
    DROP TABLE IF EXISTS ses_log_mail;
    DROP TABLE IF EXISTS ses_log_search;
    DROP TABLE IF EXISTS ses_payment_basket_map;
    DROP TABLE IF EXISTS ses_price;
    DROP TABLE IF EXISTS ses_shipping_cost;
    DROP TABLE IF EXISTS ses_stat_sessions;
    DROP TABLE IF EXISTS ses_stock;
    DROP TABLE IF EXISTS ses_token;
    DROP TABLE IF EXISTS sve_class;
    DROP TABLE IF EXISTS sve_class_attributes;
    DROP TABLE IF EXISTS sve_object;
    DROP TABLE IF EXISTS sve_object_attributes;
    DROP TABLE IF EXISTS sve_object_attributes_tmp;
    DROP TABLE IF EXISTS sve_object_catalog;
    DROP TABLE IF EXISTS sve_object_catalog_tmp;
    DROP TABLE IF EXISTS sve_object_tmp;
    DROP TABLE IF EXISTS sve_object_urls;
    DROP TABLE IF EXISTS sve_object_urls_tmp;
    ```

=== "PostgreSQL"

    To switch to the right database, issue the following command:
    ``` sql
    \connect <database_name>;
    ```


    Then, to remove all the old tables, run the following queries:
    ``` sql
    DROP TABLE IF EXISTS ses_basket;
    DROP TABLE IF EXISTS ses_basket_line;
    DROP TABLE IF EXISTS ses_content_modification_queue;
    DROP TABLE IF EXISTS ses_customer_prices;
    DROP TABLE IF EXISTS ses_customer_sku;
    DROP TABLE IF EXISTS ses_download;
    DROP TABLE IF EXISTS ses_externaldata;
    DROP TABLE IF EXISTS ses_gdpr_log;
    DROP TABLE IF EXISTS ses_invoice;
    DROP TABLE IF EXISTS ses_log_erp;
    DROP TABLE IF EXISTS ses_log_mail;
    DROP TABLE IF EXISTS ses_log_search;
    DROP TABLE IF EXISTS ses_payment_basket_map;
    DROP TABLE IF EXISTS ses_price;
    DROP TABLE IF EXISTS ses_shipping_cost;
    DROP TABLE IF EXISTS ses_stat_sessions;
    DROP TABLE IF EXISTS ses_stock;
    DROP TABLE IF EXISTS ses_token;
    DROP TABLE IF EXISTS sve_class;
    DROP TABLE IF EXISTS sve_class_attributes;
    DROP TABLE IF EXISTS sve_object;
    DROP TABLE IF EXISTS sve_object_attributes;
    DROP TABLE IF EXISTS sve_object_attributes_tmp;
    DROP TABLE IF EXISTS sve_object_catalog;
    DROP TABLE IF EXISTS sve_object_catalog_tmp;
    DROP TABLE IF EXISTS sve_object_tmp;
    DROP TABLE IF EXISTS sve_object_urls;
    DROP TABLE IF EXISTS sve_object_urls_tmp;
    ```

#### Ibexa Open Source

If you have no access to [[= product_name =]]'s `ibexa/installer` package, database upgrade isn't necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/passwords/#revoking-passwords) for all affected users.

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```
## Run data migration

### Customer Portal self-registration

If you're using [[= product_name_exp =]] or [[= product_name_com =]],
you can now run data migration required by the Customer Portal applications feature to finish the update process:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/application_internal_fields.yaml --name=2022_11_07_22_46_application_internal_fields.yaml
php bin/console ibexa:migrations:migrate --file=2022_11_07_22_46_application_internal_fields.yaml
```
