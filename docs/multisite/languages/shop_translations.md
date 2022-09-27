---
description: Translate the shop interface by editing special text modules in the Back Office.
edition: commerce
---

# Shop translations

You can use special translation Content items called "text modules" to create translations of the interface.
The translation service first checks if a Content item with a specific identifier exists and then returns the text attribute of this object.
If it does not find any translations, the [standard Symfony translation service]([[= symfony_doc =]]/book/translation.html) is used.

## Twig filter

The translation service offers the Twig filter `ibexa_commerce_translate`.

The filter uses a code which identifies the text to be translated and an optional context.
The context can be used to differentiate between different meanings, e.g. in the shop context `order` refers to purchasing,
but in content management it can refer to sorting content.

``` html+twig
{{ messageOrCode|ibexa_commerce_translate }}

{{ messageOrCode|ibexa_commerce_translate('context') }}
```

When you use Symfony translation service instead of text modules, you can use a message with placeholders
and define a different translation domain, in this example, `validators.de.xliff`.

``` html+twig
<h2>{{ 'This is a test with %placeholder%'|ibexa_commerce_translate('', { '%placeholder%':'My text' }, 'validators' ) }}</h2>

{{ 'error'|ibexa_commerce_translate(null, {}, 'validators') }}
```

### Specifying translation language

By default the translation service uses the language of the current SiteAccess and the current locale.
You can additionally send the language as a parameter.

The translation service can use the given SiteAccess to specify the language or locale required for the translation process.

``` html+twig
{% set siteaccess = basket.dataMap.siteaccess is defined ? basket.dataMap.siteaccess : null %}

{{ 'Thank you for using our shop.'|ibexa_commerce_translate(null, {}, null, siteaccess) }}
```

### Pluralisation

To handle plurals in translations, use [Symfony pluralization]([[= symfony_doc =]]/translation.html#pluralization).

## Translation in PHP code

In PHP code you can use the `Ibexa\Bundle\Commerce\Translation\Services\TransService` service to get translations:

``` php
$messageOrCode = 'This is either some message that should be translated or a code for a text module';
$context = 'context';

//Call the service
$container->get('Ibexa\Bundle\Commerce\Translation\Services\TransService')->translate($messageOrCode);

//Use the optional context parameter
$container->get('Ibexa\Bundle\Commerce\Translation\Services\TransService')->translate($messageOrCode, $context);
```

## Translations with text modules

The Content Type `st_textmodule` has the following Fields:

| Field      | Description                                                      |
| ---------- | ---------------------------------------------------------------- |
| Name       | Internal name                                |
| Identifier | The source or identifier for the translation that has to be defined. |
| Context    | Optional context                                                 |
| Content    | Content for frontend                                             |

### Field identifier

By default the translated value is taken from the `content` Field.
You can extend the text module Content Type with a new RichText Field.
Then, the translation service can fetch from the appropriate Field.

To take advantage of this, use the `fieldIdentifier` parameter:

``` html+twig
{# without context #}
{{ 'my_profile_intro_text'|ibexa_commerce_translate(null, {'fieldIdentifier' : 'my_field_identifier' }) }}

{# with context #}
{{ label_tooltip_description|ibexa_commerce_translate ('createrma', {'fieldIdentifier' : 'header'}) }}
```

## Configuration

|Configuration|Description|Default|
|--- |--- |--- |
|`silver_tools.default.translationFolderId`|Location ID of the text module folder|`89`|
|`silver_tools.default.textmoduleTranslationEnabled`|Enable/disable text modules|`true`|
|`silver_tools.default.defaultTranslationEnabled`|Enable/disable default Symfony translation|`true`|
|`silver_tools.default.loggTranslations`|Enable/disable logging missing translations|`false`|
|`silver_tools.default.translation_cache`|Enable/disable translation cache|`true`|
|`silver_tools.default.translation_cache_ttl`|Defines how long the translation is stored in the cache. When the TTL value is set to `null`, cache is stored forever.||

## Logging

Missing translations are logged.
You can enable/disable logging of missing translations in the configuration with the `silver_tools.default.loggTranslations` parameter.

All missing translations are logged in `var/logs/siso.translations.log`.

``` xml
<service id="ibexa.commerce.trans.logging_handler.stream" class="%monolog.handler.stream.class%">
    <argument type="string">%kernel.logs_dir%/siso.translations.log</argument>
</service>
```

## Cache

Translations are cached using Stash. If there is no translation for the given message (or code),
a special `null` translation message is cached. Thanks to this there is no need to repeat fetches.

Translations from Symfony are not cached.

### Cache purging

When `ibexa_commerce_translate()` is used in Twig templates, the cache is tagged with `content-<content-id>`.
If a text module is updated, the system purges all HTTP cache blocks which are tagged with the given `content_id`
as well as the Stash cache for this translation.
