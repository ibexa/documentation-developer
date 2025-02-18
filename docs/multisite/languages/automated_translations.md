---
description: With the automated translation add-on, users can translate content items into multiple languages with Google Translate or DeepL.
---

# Automated content translation

The automated translation add-on package allows users have content items machine-translated into multiple languages by using either Google Translate or DeepL external translation engine.
The package integrates with [[= product_name =]], and allows users to [request from the UI]([[= user_doc =]]/content_management/translate_content.md#add-translations) that a content item is translated.
However, you can also run an Console Command to translate a specific content item.
Either way, as a result, a new version of the content item is created.

The following field types are supported out of the box:

- [TextLine](textlinefield.md)
- [TextBlock](textblockfield.md)
- [RichText](richtextfield.md)
- [Page](pagefield.md):
    - The content of `text` and `richtext` [block attributes](page_block_attributes.md#block-attribute-types)

See [adding a custom field encoder](##add-a-custom-field-encoder) for more information on how to expand this.

!!! note "DeepL limitations"

    At this point a list of languages available when using DeepL is limited to English, German, French, Spanish, Italian, Dutch, Polish and Japanese.

## Configure automated content translation

### Install package

Automated content translation support comes as an additional package that you must download and install separately:

```bash
composer require ibexa/automated-translation
```

!!! caution "Modify the default configuration"

    Symfony Flex installs and activates the package.
    However, you must modify the `config/bundles.php` file to change the bundle loading order so that`IbexaAutomatedTranslationBundle` is before `IbexaAdminUiBundle`:

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

The configuration is SiteAccess-aware, therefore, you can configure different engines to be used for different sites.

## Translate content items with CLI

To create a machine translation of a specific content item, run the following command:

```shell
php bin/console ibexa:automated:translate [contentId] [serviceName] --from=eng-GB --to=fre-FR
```

## Add a custom machine translation service

By default, the automated translation package can connect to Google Translate or DeepL, but you can configure it to use a custom machine translation service.
You would do it, for example, when a new service emerges on the market, or your company requires that a specific service is used.

To add a custom engine to a list of available translation services, do the following:

1. Create a service that implements the [`\Ibexa\AutomatedTranslation\Client\ClientInterface`](REFERENCE LINK) interface
1. In `services.yaml` file, tag the service as `ibexa.automated_translation.client`

See the example below:

<example here>

The whole automated translation process consists of 3 phases:
1. Encoding - the raw data stored in the fieldtype is processed so that it can be translated by the automated translation service. Google and Deepl can h
1. Translating - the data is translated using an Automated Translatin client.
1. Decoding - the translated data is decoded back to the original structure so that it can be stored back in [= product_name =]]

## Add a custom field or block encoder




