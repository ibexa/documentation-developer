---
description: Update procedure to v4.4 for people who don't use Commerce packages and can remove them.
---

# Update with new Commerce packages

This update procedure applies if you have a v4.3 installation, and you do not use commerce packages.

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
It is defined in `config/packages/oneup_flysystem.yaml`:

```yaml
oneup_flysystem:
    adapters:
        default_adapter:
            local:
                location: '%kernel.cache_dir%/flysystem'
```

If you haven't applied custom changes to that file,
you can simply reset third party `oneup/flysystem-bundle` recipe by executing:

```bash
composer recipe:install --force --reset -- oneup/flysystem-bundle
```

### Remove `ibexa/commerce-*` packages with dependencies

Remove the following bundles from `config/bundles.php`.
Removal of third party bundles (`FOS\` to `JMS\`) is optional, you can leave them if they are used by your installation.

=== "[[= product_name_content =]]"

    ``` php
    
    ```

=== "[[= product_name_exp =]]"

    ``` php
    
    ```

=== "[[= product_name_com =]]"

    ``` php
    FOS\CommentBundle\FOSCommentBundle::class => ['all' => true],
    Tedivm\StashBundle\TedivmStashBundle::class => ['all' => true],
    WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle::class => ['all' => true],
    Nelmio\SolariumBundle\NelmioSolariumBundle::class => ['all' => true],
    JMS\Payment\CoreBundle\JMSPaymentCoreBundle::class => ['all' => true],
    Joli\ApacheTikaBundle\ApacheTikaBundle::class => ['all' => true],
    JMS\JobQueueBundle\JMSJobQueueBundle::class => ['all' => true],
    FOS\RestBundle\FOSRestBundle::class => ['all' => true],
    JMS\SerializerBundle\JMSSerializerBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Eshop\IbexaCommerceEshopBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\ShopTools\IbexaCommerceShopToolsBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Translation\IbexaCommerceTranslationBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Payment\IbexaCommercePaymentBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Price\IbexaCommercePriceBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Tools\IbexaCommerceToolsBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Search\IbexaCommerceSearchBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\PriceEngine\IbexaCommercePriceEngineBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\SpecificationsType\IbexaCommerceSpecificationsTypeBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\BaseDesign\IbexaCommerceBaseDesignBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\FieldTypes\IbexaCommerceFieldTypesBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Checkout\IbexaCommerceCheckoutBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\ShopUi\IbexaCommerceShopUiBundle::class => ['all' => true],
    # ...
    Ibexa\Bundle\Commerce\OneSky\IbexaCommerceOneSkyBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\EzStudio\IbexaCommerceEzStudioBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Comparison\IbexaCommerceComparisonBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\QuickOrder\IbexaCommerceQuickOrderBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\TestTools\IbexaCommerceTestToolsBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Voucher\IbexaCommerceVoucherBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\LocalOrderManagement\IbexaCommerceLocalOrderManagementBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Newsletter\IbexaCommerceNewsletterBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\OrderHistory\IbexaCommerceOrderHistoryBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\ErpAdmin\IbexaCommerceErpAdminBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\ShopFrontend\IbexaCommerceShopFrontendBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Basket\IbexaCommerceBasketBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\Rest\IbexaCommerceRestBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\AdminUi\IbexaCommerceAdminUiBundle::class => ['all' => true],
    Ibexa\Bundle\Commerce\PageBuilder\IbexaCommercePageBuilderBundle::class => ['all' => true],
    EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle::class => ['all' => true],
    ```


Next, remove related extensions' configuration.
Removal of related extensions' for third party bundles (for example `config/packages/fos_rest.yaml`) is optional, you can leave them if they are used by your installation.

=== "[[= product_name_content =]]"

    ``` 

    ```

=== "[[= product_name_exp =]]"

    ```

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


Finally, removed related routes from `config/routes/ibexa_commerce.yaml`.


### Update the database

Next, update the database in you have a Commerce version of Ibexa DXP.
Ibexa DXP Content and Ibexa DXP Experience do not require database update.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.3.latest-to-4.4.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.3.latest-to-4.4.0.sqll
    ```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/user_management/#revoking-passwords) for all affected users.

## Finish update

Finish the update process:

``` bash
composer run post-install-cmd
```

## Run data migration

### Customer Portal self-registration

If you are using [[= product_name_exp =]] or [[= product_name_com =]],
run data migration required by the Customer Portal applications feature:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/application_internal_fields.yaml --name=2022_11_07_22_46_application_internal_fields.yaml
```