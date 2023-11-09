---
description: Install created bundle extension into Ibexa DXP.
---

# Install bundle
 
## Add repository to composer

To be able to install the bundle to your [[= product_name_base =]] project, first, update the requirements.


```json
    "require": {
        "php": ">=7.4",
        "ext-ctype": "*",
        "ext-iconv": "*",
        "acme/video-editor": "dev-master",
        "ibexa/commerce": "4.6.x-dev",
        "ibexa/connector-seenthis": "^4.6@dev",
```


Next, add the repository to the `composer.json`:

```json hl_lines="17"
    "repositories": {
        "ibexa": {
            "type": "composer",
            "url": "https://updates.ibexa.co"
        },
        "acme/currency-exchange-rate":{
            "type": "vcs",
            "url": "file:///Users/justyna.koralewicz/example-3rd-party-extension"
        }
    }
```

## Install bundle into application

On your [[= product_name_base =]] root project run:
 
```bash
composer require acme/currency-exchange-rate:dev-master
```

!!! note

    If your application uses Symfony Flex, the bundle is registered automatically after you install it.


Check whether the bundle is enabled, if not, you must enable it per environment in the `config/bundles.php` file:


```php
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    ...
    Ibexa\Bundle\TestFixtures\IbexaTestFixturesBundle::class => ['all' => true],
    ACME\Bundle\CurrencyExchangeRate\ACMECurrencyExchangeRateBundle::class => ['all' => true],
];
```


Next, clear the cache by runnig the following command:

```bash
php bin/console cache:clear
```

The newly installed bundle should be visible in the **Composer** tab in **Admin** -> **System information**.

![Installed bundles](sys_info_composer_tab.png)


## Add currency exchange page block

Go to Page Builder edit mode. The Currency exchange block should be visible and available in the **Elements** panel.


![Currency exchange page block](bundle_page_block.png)
