---
description: With the automated translation add-on, users can translate content items into multiple languages with Google Translate or DeepL.
---

# Automated content translation

The automated translation add-on package allows users have content items machine-translated into multiple languages by using either Google Translate or DeepL external translation engine.
The package integrates with [[= product_name =]], and allows users to [request from the UI]([[= user_doc =]]/content_management/translate_content.md#add-translations) that a content item is translated.
However, you can also run an API command to translate a specific content item.
Either way, as a result, a new version of the content item is created with [translatable fields](languages.md#translatable-and-untranslatable-fields) of the following types translated into a target language:

- in pages: [TextBlock](../../content_management/field_types/field_type_reference//textblockfield.md) and [RichText](../../content_management/field_types/field_type_reference//richtextfield.md)
- in other content types: [TextLine](../../content_management/field_types/field_type_reference//textlinefield.md) and RichText

!!! note "DeepL limitations"

    At this point a list of languages available when using DeepL is limited to English, German, French, Spanish, Italian, Dutch, Polish and Japanese.

## Configure automated content translation

### Install package

Automated content translation support comes as an additional package that you must download and install separately:

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
php bin/console ibexa:automated:translate [contentId] [serviceName] --from=eng-GB --to=fre-FR
```

## Add a custom machine translation service

By default, the automated translation package can connect to Google Translate or DeepL, but you can configure it to use a custom machine translation service.
You would do it, for example, when a new service emerges on the market, or your company requires that a specific service is used.

To add a custom engine to a list of available translation services, do the following:

- create a service that implements ` Ibexa\AutomatedTranslation\Client\ClientInterface`
- implement the `translate` method
- in `services.yaml` file, tag the service as `ibexa.automated_translation.client`