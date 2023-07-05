---
description: Update procedure to v4.4 for people who don't use Commerce packages and can remove them.
---
# Update with new Commerce packages

This update procedure applies if you have a v4.3 installation, and you do not use Commerce packages.

## Update from v4.3.x to v4.3.latest

Before you update to v4.4, you need to go through the following steps to update to the latest maintenance release of v4.3 (v[[= latest_tag_4_3 =]]).

### Update the application to v4.3.latest

Run:

=== "Ibexa Content"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```
=== "Ibexa Experience"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```
=== "Ibexa Commerce"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```

## Remove deprecated Field Types

By default, every v4.3 installation has a set of built-in Content Types.
Some of them use Field Types deprecated in v4.4, which need to be removed manually.
Make sure to remove all occurrences of `sesspecificationstype`, `uivarvarianttype`, `sesselection`, `sesprofiledata` Field Types from your Content Types.

This step should be performed on the working installation, omitting it will result in an error during update:

```
  [Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\Exception\NotFound (404)]
  Could not find 'Persistence Field Value Converter' with identifier 'sesspecificationstype'
```

In that case, you can use [Null Field Type](nullfield.md) to define a replacement for deprecated Field Types in `config/services.yaml`:

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

=== "Ibexa Content"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```
=== "Ibexa Experience"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "Ibexa Commerce"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files

### Flysystem v2

Local adapters' `directory` key changed to `location`.
It is defined in `config/packages/oneup_flysystem.yaml`:

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
You do not have to remove third-party bundles (`FOS\` to `JMS\`) if they are used by your installation.

=== "Ibexa Content"

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

=== "Ibexa Experience"

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

=== "Ibexa Commerce"

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
You do not have to remove third-party bundles (for example `config/packages/fos_rest.yaml`) if they are used by your installation.

=== "Ibexa Content"

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

=== "Ibexa Experience"

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

=== "Ibexa Commerce"

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

Next, update the database if you are using Ibexa Commerce.
Ibexa Content and Ibexa Experience do not require the database update.

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

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/user_management/#revoking-passwords) for all affected users.

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```
## Run data migration

### Customer Portal self-registration

If you are using Ibexa Experience or Ibexa Commerce,
you can now run data migration required by the Customer Portal applications feature to finish the update process:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/application_internal_fields.yaml --name=2022_11_07_22_46_application_internal_fields.yaml
php bin/console ibexa:migrations:migrate --file=2022_11_07_22_46_application_internal_fields.yaml
```
