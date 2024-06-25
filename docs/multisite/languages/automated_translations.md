---
description: With the automated translation add-on, users can translate content items into multiple languages with Google Translate and other machine translation engines.
---

# Automated content translation

The automated translation add-on package allows users have content items machine-translated into multiple languages by using external translation engines like Google Translate and DeepL.
The package integrates with [[= product_name =]], and allows users to [request from the UI]([[= user_doc =]]/content_management/translate_content.md#add-translations) that a content item is translated.
However, you can also run an API command to translate a specific content item.
Either way, as a result, a new version of a content item is created with all [translatable fields](languages.md#translatable-and-untranslatable-fields) translated into a target language.

## Configure automated content translation

### Install package

Automated content translation support comes as an additional package that needs to be downloaded and installed separately:

```bash
composer require ibexa/automated-translation
```

!!! caution "Modify the default configuration"

    Flex installs and activates the package.
    However, you must modify the `bundles.php` file to change the template loading order:

    ```php
    <?php

    return [
        ...
        Ibexa\Bundle\AutomatedTranslation\IbexaAutomatedTranslationBundle::class => ['all' => true],
        Ibexa\Bundle\AdminUi\IbexaAdminUiBundle::class => ['all' => true],
        ...
    ];
    ```

### Configure access to translation services

Before you can start using the feature you must configure access to your Google and/or DeepL account.

1\. Get the [Google API key](https://developers.google.com/maps/documentation/javascript/get-api-key) and/or [DeepL Pro key](https://support.deepl.com/hc/en-us/articles/360020695820-API-Key-for-DeepL-s-API).

3\. Set these values in the YAML configuration files, under the `ibexa_automated_translation.system.default.configurations` key:

``` yaml
ibexa_automated_translation:
    system:
        default:
            configurations:
                google:
                    apiKey: "google-api-key"
                deepl:
                    authKey: "deepl-pro-key"
```

!!! note

    The configuration is SiteAccess-aware, therefore, you can configure different engines to be used for different sites.

## Translate content items with API

To create a machine translation of a specific content item, run the following command:

```shell
php bin/console ibexatranslate [contentId] [serviceName] --from=eng-GB --to=fre-FR
```

## Add a custom machine translation service

You can configure the automated translation package to use a custom machine translation service.
You would do it, for example, when a new service emerges on the market, or your company requires that a specific service is used.

To add a custom engine to a list of available translation services, do the following:

- create a service that implements the ` Ibexa\AutomatedTranslation\Client\ClientInterface`
- implement the `translate` method
- in `services.yaml` file, tag the service as `ibexa.automated_translation.client`