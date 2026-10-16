---
description: Add custom classes, exclude custom content types and add support for custom fields.
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

Before you build a custom translation provider, if your provider uses the AI Actions framework, make sure that the `ibexa/connector-ai` package is configured in your system.

### REST API-based provider

To connect a translation service that calls a REST API directly, implement [`TranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-TranslationProviderInterface.html).
For providers that store API keys and other required settings, you can rely on [`ConfigurableProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-ConfigurableProviderInterface.html).
It extends `TranslationProviderInterface` and adds `getConfiguration()` and `isConfigured()` methods.

The `translate()` method receives a [`TranslationDataInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-TranslationDataInterface.html) object that carries the text to translate along with the source and target [language codes](configure_translations_management.md#advanced-translation-provider-options):

``` php hl_lines="36-49"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomProvider.php') =]]
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag.
Both `identifier` and [`validation_profile`](#validation-profiles) attributes are required.

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 6) =]]
```

### AI-based provider

To connect a translation service that uses the [AI Actions](ai_actions.md) framework, implement [`AiTranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-AiTranslationProviderInterface.html).
This interface extends `ConfigurableProviderInterface` and serves as a type marker for AI-based providers.
The system uses the `getConfiguration()` and `isConfigured()` methods to determine whether the provider is available before displaying selectable options in the **Create a new translation** modal:

``` php hl_lines="53 60"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomAiProvider.php') =]]
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag, with `ai_generic` as the validation profile.
The `ai_generic` validation profile is meant to be used by default for AI providers, but you can [implement your own](#validation-profiles).

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 29, 33) =]]
```

If your custom provider integrates with the AI Actions framework, `isConfigured()` should check whether the `actionConfigurationIdentifier` resolves to an existing and enabled Action Configuration.

The `validation_profile`, `supportedLanguageCodes`, and `languageCodesMap` options work the same way as for REST API-based providers.

### Language code normalizer

If your provider uses [language codes](configure_translations_management.md#advanced-translation-provider-options) that differ from the ones used by [[= product_name =]] and the `languageCodesMap` configuration is insufficient, implement a custom [`LanguageNormalizerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-LanguageNormalizer-LanguageNormalizerInterface.html) to handle the conversion:

``` php
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomLanguageCodeNormalizer.php') =]]
```

The `supports()` method is a way to bind the normalizer to a provider.
When a translation is triggered, the system checks the registered normalizers, and it uses the first one whose `supports()` method returns `true` for the current provider.

Register the normalizer with the `ibexa.translations_management.auto_translate.provider.language_normalizer` tag:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 34, 37) =]]
```

If multiple normalizers are registered, use `priority` to control the order in which they're checked.

### Validation profiles

The `validation_profile` attribute links the provider to a validator that checks language codes and payload size before each translation request.
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

## Add support for custom field types

The translation engine works by extracting translatable text from fields, sending it to the provider, and writing the translated text back.
Field value transformers handle this encode/decode cycle, one per field type.
The package includes transformers for `text`, `RichText`, and `ibexa_landing_page` fields.

To add support for a custom or non-standard field type, implement [`FieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-FieldValueTransformerInterface.html):

- `getFieldTypeIdentifier()` - returns the field type identifier that this transformer handles
- `encode(Field $field): EncodedFieldValue` - extracts the translatable string from the field and wraps it in an [`EncodedFieldValue`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-EncodedFieldValue.html).
The constructor takes the extracted string as its first argument and an optional metadata array as the second.
- `decode(string $value, mixed $previousFieldValue, array $metadata): Value` - receives the translated string, the previous field value, and any metadata. Returns the updated field value.

The following example adds support for automatically translating the alternative text of an image:

``` php hl_lines="21 31 37 46-58"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/ImageAltTextTransformer.php') =]]
```

Register the new transformer with the `ibexa.translations_management.auto_translate.field_value_transformer` tag.
The `field_type_identifier` attribute is required.
It must match the value that `getFieldTypeIdentifier()` returns:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 11, 14) =]]
```

!!! note "Advanced metadata handling"

    When metadata is required for decoding or when you need to control what happens if metadata encoding fails, implement [`MetadataAwareFieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-MetadataAwareFieldValueTransformerInterface.html).
    With this interface, you can fail the translation when metadata encoding fails and indicate that metadata is required for decoding.
    Without it, the field is skipped instead.

## Define custom exclusion rules

Use exclusion rules to identify content that cannot use the side-by-side view.
The Translations management package ships with one rule that excludes content types that contain `ibexa_landing_page` or `ibexa_form` fields.

### Exclude with custom class

To exclude content from side-by-side view, for example, content types whose fields render incorrectly in the side-by-side layout, implement [`SideBySideExclusionRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Service-SideBySideExclusionRuleInterface.html).
The `isExcluded()` method receives a [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html) object, which gives you access to different criteria, including content type, section, owner, main language, publication status, visibility, and main location of the content item.
If the content item should be excluded, the method should return `true`.

``` php
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomExclusionRule.php') =]]
```

Register the rule with the `ibexa.translations_management.side_by_side.exclusion_rule` tag.
This interface is not registered for [Symfony autoconfiguration]([[= symfony_doc =]]/service_container.html#the-autoconfigure-option), so the tag is required.

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 15, 18) =]]
```

## Use Twig component extension points

Two [Twig component groups](custom_components.md#translations-management) allow you to inject custom UI elements into the translation interface without the need to override their templates.

Such custom element could be, for example, a disclaimer or policy notice that the editor must acknowledge before a translation is created.

The two groups behave differently:

- `admin-ui-content-translation-modal-footer` — if any of the [components](components.md) renders output that is not empty, it entirely replaces the default footer buttons.
Your component template must therefore include its own action buttons.
- `admin-ui-content-edit-translation-select-footer` — component output is inserted between the existing **Edit** and **Discard** buttons of the content edit confirmation screen.

Register a component with the `ibexa.twig.component` tag:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 24, 28) =]]
```

!!! note

    The `admin-ui-content-translation-modal-footer` group receives a `location` variable that may be `null` for an unpublished draft.
    Always check for `null` before you access location properties in your component template.
