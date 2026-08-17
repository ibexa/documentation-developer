---
description: Extend translations management - add custom classes, exclude custom content types and intercept the flow.
edition: lts-update
month_change: true
---

# Extend translations management

By extending [Translations management](translations_management_guide.md), you can adapt the package's behavior to your specific requirements.
The package is designed to be extended in multiple ways.
You can create custom [translation providers](configure_translations_management.md#configure-translation-providers), field type transformers, exclusion rules, and UI components.
In all cases, you follow the same pattern: implement an interface first, then register the service with a service tag.
The package discovers and registers tagged services automatically.

## Add custom translation provider

Before you build a custom translation provider, if your provider uses the AI Actions framework, make sure that the `ibexa/connector-ai` package is installed in your system.

### REST API-based provider

To connect a translation service that calls a REST API directly, implement [`TranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-TranslationProviderInterface.html).
The `translate()` method receives a `TranslationDataInterface` object that carries the text to translate along with the source and target language codes:

``` php hl_lines="36-49"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomProvider.php') =]]
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag.
Both `identifier` and [`validation_profile`](#validation-profiles) are required attributes.

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 6) =]]
```

### AI-based provider

To connect a translation service that uses the [AI Actions](ai_actions.md) framework, implement [`AiTranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-AiTranslationProviderInterface.html).
The interface adds `getConfiguration()` and `isConfigured()` to the base provider contract.
These methods allow the package to determine whether the provider is available before it displays selectable options in the **Create a new translation** modal:

``` php hl_lines="37-50"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomAiProvider.php') =]]
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag, with `ai_generic` as the validation profile.
The `ai_generic` validation profile is used by default for AI providers, but you can [implement your own](#validation-profiles).

``` yaml
[[= include_file('code_samples/translations_management/config/services.yaml', 0, 1) =]] [[= include_code('code_samples/translations_management/config/services.yaml', 32, 36) =]]
```

!!! note "Minimal `getConfiguration()` and `isConfigured()` implementations"

    The sample implements `getConfiguration()` and `isConfigured()` as stubs.
    The built-in AI providers delegate these methods to internal services that are not part of the public API and are not available to custom code outside the bundle.
    If your custom provider integrates with the AI Actions framework, `isConfigured()` should check whether the `actionConfigurationIdentifier` resolves to an existing and enabled Action Configuration.

The `validation_profile`, `supportedLanguageCodes`, and `languageCodesMap` options work the same way as for REST API-based providers.

### Validation profiles

The `validation_profile` attribute links the provider to a validator that checks language codes and payload size before each before each translation request.
By default, three profiles are available:

| Profile | Used by |
|---|---|
| `google` | Google Translate provider |
| `deepl` | DeepL provider |
| `ai_generic` | All built-in AI providers. Suitable for custom AI providers. |

To define a custom validation profile, implement [`ProviderValidatorInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Validator-ProviderValidatorInterface.html) and register it:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 7, 10) =]]
```

You can reuse the [`DefaultProviderValidator`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Validator-DefaultProviderValidator.html) class if it meets your requirements or implement your own.
It exposes configurable maximum payload size and language code regex patterns.

The package also provides several specialized interfaces for providers with specific requirements:

| Interface | Purpose |
|---|---|
| [`ConfigurableProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-ConfigurableProviderInterface.html) | Extends `TranslationProviderInterface`. Adds `getConfiguration()` and `isConfigured()` for providers that store API keys and other required settings |
| [`AiTranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-AiTranslationProviderInterface.html) | Extends `ConfigurableProviderInterface`. Used as a type marker for AI-based providers, it inherits the configuration methods |
| [`TranslationHttpClientInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Http-TranslationHttpClientInterface.html) | For HTTP-based providers that use a REST API pattern |

## Add support for custom field types

The translation engine works by extracting translatable text from fields, sending it to the provider, and writing the translated text back.
Field value transformers handle this encode/decode cycle, one per field type.
The package includes transformers for standard text and RichText fields.

To add support for a custom or non-standard field type, implement [`FieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-FieldValueTransformerInterface.html):

- `getFieldTypeIdentifier()` - returns the field type identifier that this transformer handles
- `encode(Field $field): EncodedFieldValue` - extracts the translatable string from the field and wraps it in an [`EncodedFieldValue`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-EncodedFieldValue.html).
The constructor takes the extracted string as its first argument and an optional metadata array as the second.
- `decode(string $value, mixed $previousFieldValue, array $metadata): Value` - receives the translated string, the previous field value, and any metadata. Returns the updated field value.

``` php hl_lines="21 31 37 46-58"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/ImageAltTextTransformer.php') =]]
```

Register the new transformer with the `ibexa.translations_management.auto_translate.field_value_transformer` tag.
The `field_type_identifier` attribute is required.
It must match the value that `getFieldTypeIdentifier()` returns:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 14, 17) =]]
```

If a field type requires metadata, for example, RichText fields with embedded objects that you must preserve after translation, implement [`MetadataAwareFieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-MetadataAwareFieldValueTransformerInterface.html) instead.

## Define custom exclusion rules

Use exclusion rules to identify content types that cannot use the side-by-side view.
The Translations management package ships with one rule that excludes content types that contain `ibexa_landing_page` or `ibexa_form` fields.

### Exclude with custom class

To exclude additional content types, for example, content types whose fields render incorrectly in the side-by-side layout, implement [`SideBySideExclusionRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Service-SideBySideExclusionRuleInterface.html).
The `isExcluded()` method receives a [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html) object and returns `true` if the content item should be excluded.
Register the rule with the `ibexa.translations_management.side_by_side.exclusion_rule` tag.
This interface is not registered for Symfony autoconfiguration, so the tag is required.

``` php
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomExclusionRule.php') =]]
```


``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 18, 20) =]]
```

### Exclude with existing class

`MyCustomExclusionRule` targets one specific content type by name.
To exclude any content type that contain specific field types without the need to write a custom class, register an additional instance of the built-in [`UnsupportedFieldTypeExclusionRule`](https://github.com/ibexa/translations-management/blob/main/src/lib/SideBySide/Service/UnsupportedFieldTypeExclusionRule.php).
Because this registers a second instance of the service with different arguments, you can't use the class name as the service ID.
Use an arbitrary string ID instead to avoid a service definition conflict:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 21, 26) =]]
```

## Use Twig component extension points

Two Twig component groups allow you to inject custom UI elements into the translation interface without the need to override their templates.
Such custom elements could be:

- buttons that allow the editor to create a new translation either in the side-by-side view or the standard single-panel editor
- a disclaimer or policy notice that the editor must acknowledge before a translation is created

| Component group | Location | Variables available |
|---|---|---|
| `admin-ui-content-translation-modal-footer` | Footer of the **Add translation** modal | `form`, `content_id`, `location`, `allow_placeholder` |
| `admin-ui-content-edit-translation-select-footer` | Footer of the **Select translation** panel on the content edit screen | `form`, `content_id`, `main_language_code` |

The two groups behave differently:

- `admin-ui-content-translation-modal-footer` — if any of the components renders output that is not empty, it entirely replaces the default footer buttons.
Your component template must therefore include its own action buttons.
- `admin-ui-content-edit-translation-select-footer` — component output is inserted between the existing **Edit** and **Discard** buttons.

Register a component with the `ibexa.twig.component` tag:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 27, 31) =]]
```

!!! note

    The `admin-ui-content-translation-modal-footer` group receives a `location` variable that may be `null` when the modal is rendered outside a location context.
    Always check for `null` before you access location properties in your component template.

## Intercept translation flow

The `BeforeTranslateEvent` and `TranslateEvent` [events](translations_management_events.md#translation-events) operate at the field-value level and cannot redirect the HTTP flow.
To intercept the "Add translation" action at the HTTP level, for example, to trigger auto-translation and redirect to a custom view, or to bypass the default flow entirely, subscribe to `admin-ui`'s `ContentProxyTranslateEvent`.

The `translations-management` package listens to this event at priority `100`.
Subscribe at a higher priority to act before the package does:

``` php hl_lines="22 38 39"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/ContentProxyTranslateSubscriber.php') =]]
```

Both highlighted calls are required:

- `setResponse()` alone does not prevent the Translations management listener at priority 100 from running and overwriting the response.
- `stopPropagation()` stops all lower-priority listeners from executing.

When a response is set on the event, `admin-ui` uses it and doesn't proceed with the standard translation editor.

When the package's Subscriber fails to create the auto-translated draft, for example, when the provider is unreachable, it catches the exception, shows an error notification in the back office, and redirects the editor to the content view, but it does not surface a full error page.
If your subscriber takes over the flow by calling both `setResponse()` and `stopPropagation()`, you must implement error handling.

!!! caution "Internal `ContentProxyTranslateEvent`"

    `ContentProxyTranslateEvent` is marked `@internal` in `ibexa/admin-ui`.
    While it functions as an extension point in practice, its name and signature may change.
    It may even be removed entirely without a deprecation notice.

## Service tags reference

The following service tags expose additional extension points that you can use to customize and extend translations management behavior.

| Tag | Purpose | Required attributes |
|---|---|---|
| `ibexa.translations_management.auto_translate.provider.language_normalizer` | Register a language code normalizer for a provider | none |
| `ibexa.translations_management.auto_translate.provider.ai.translation_strategy` | Register a custom AI translation strategy (prompt structure) | `priority` |
| `ibexa.translations_management.auto_translate.metadata_validation.retry_policy` | Register a metadata validation retry policy | `priority` |
