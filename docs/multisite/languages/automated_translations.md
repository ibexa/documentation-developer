---
description: With the automated translation add-on, users can translate content items into multiple languages with Google Translate or DeepL.
month_change: false
---

# Automated content translation

With the automated translation add-on package, users can translate their content items into multiple languages automatically by using either Google Translate or DeepL external translation engine.
The package integrates with [[= product_name =]], and allows users to [request from the UI]([[= user_doc =]]/content_management/translate_content/#add-translations) that a content item is translated.
However, you can also run a Console Command to translate a specific content item.
Either way, as a result, a new version of the content item is created.

The following field types are supported out of the box:

- [TextLine](textlinefield.md)
- [TextBlock](textblockfield.md)
- [RichText](richtextfield.md)
- [Page](pagefield.md): the content of `text` and `richtext` [block attributes](page_block_attributes.md#block-attribute-types)

See [adding a custom field or block attribute encoder](#create-custom-field-or-block-attribute-encoder) for more information on how you can extend this list.

## Configure automated content translation

### Install package

The automated content translation feature comes as an additional package that you must download and install separately:

```bash
composer require ibexa/automated-translation
```

!!! caution "Modify the default configuration"

    Symfony Flex installs and activates the package.
    However, you must modify the `config/bundles.php` file to change the bundle loading order so that `IbexaAutomatedTranslationBundle` is loaded before `IbexaAdminUiBundle`:

    ```php
    <?php

    return [
        // ...
        Ibexa\Bundle\AutomatedTranslation\IbexaAutomatedTranslationBundle::class => ['all' => true],
        Ibexa\Bundle\AdminUi\IbexaAdminUiBundle::class => ['all' => true],
        // ...
    ];
    ```

### Configure access to translation services

Before you can start using the feature, you must configure access to your Google and/or DeepL account.

1\. Get the [Google API key](https://developers.google.com/maps/documentation/javascript/get-api-key) and/or [DeepL Pro key](https://support.deepl.com/hc/en-us/articles/360020695820-API-Key-for-DeepL-s-API).

2\. Set these values in the YAML configuration files, under the `ibexa_automated_translation.system.default.configurations` key:

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

To create a machine translation of a specific content item, you can use the `ibexa:automated:translate` command.

The following arguments and options are supported:

- `--from` - the source language
- `--to` - the target language
- `contentId` - ID of the content to translate
- `serviceName` - the service to use for translation

For example, to translate the root content item from English to French with the help of Google Translate, run:

``` bash
php bin/console ibexa:automated:translate --from=eng-GB --to=fre-FR 52 google
```

## Extend automated content translations

### Add a custom machine translation service

By default, the automated translation package can connect to Google Translate or DeepL, but you can configure it to use a custom machine translation service.
You would do it, for example, when a new service emerges on the market, or your company requires that a specific service is used.

The following example adds a new translation service.
It uses the [AI actions framework](ai_actions.md) and assumes a custom `TranslateAction` AI Action exists.
To learn how to build custom AI actions see [Extending AI actions](extend_ai_actions.md#custom-action-type-use-case).

1. Create a service that implements the [`\Ibexa\AutomatedTranslation\Client\ClientInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AutomatedTranslation-Client-ClientInterface.html) interface:

``` php hl_lines="35-52"
[[= include_file('code_samples/multisite/automated_translation/src/AutomatedTranslation/AiClient.php') =]]
```

2\. Tag the service as `ibexa.automated_translation.client` in the Symfony container:

``` yaml
[[= include_file('code_samples/multisite/automated_translation/config/services.yaml', 15, 18) =]]
```

3\. Specify the configuration under the `ibexa_automated_translation.system.default.configurations` key:

``` yaml
[[= include_file('code_samples/multisite/automated_translation/config/services.yaml', 23, 32) =]]
```

### Create custom field or block attribute encoder

You can expand the list of supported field types and block attributes for automated translation, adding support for even more use cases than the ones built into [[= product_name =]].

The whole automated translation process consists of 3 phases:

1. **Encoding** - data is extracted from the field types and block attributes and serialized into XML format
1. **Translating** - the serialized XML is sent into specified translation service
1. **Decoding** - the translated response is deserialized into the original data structures for storage in [[= product_name =]]

The following example adds support for automatically translating alternative text in image fields.

1. Create a class implementing the [`FieldEncoderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AutomatedTranslation-Encoder-Field-FieldEncoderInterface.html) and add the required methods:

``` php hl_lines="11-14 16-19 21-27 33-38"
[[= include_file('code_samples/multisite/automated_translation/src/AutomatedTranslation/ImageFieldEncoder.php') =]]
```
In this example, the methods are responsible for:

- `canEncode` - deciding whether the field to be encoded is an [Image](imagefield.md) field
- `canDecode` - deciding whether the field to be decoded is an [Image](imagefield.md) field
- `encode` - extracting the alternative text from the field type
- `decode` - saving the translated alternative text in the field type's value object

2\. Register the class as a service.
If you're not using [Symfony's autoconfiguration]([[= symfony_doc =]]/service_container.html#the-autoconfigure-option), use the `ibexa.automated_translation.field_encoder` service tag.

``` yaml
[[= include_file('code_samples/multisite/automated_translation/config/services.yaml', 19, 22) =]]
```

For custom block attributes, the appropriate interface is [`BlockAttributeEncoderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AutomatedTranslation-Encoder-BlockAttribute-BlockAttributeEncoderInterface.html) and the service tag is `ibexa.automated_translation.block_attribute_encoder`.
