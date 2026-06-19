---
description: Extend translations management - add custom classes, exclude custom content types and intercept the flow.
edition: lts-update
month_change: true
---

# Extend translations management

By extending [Translations management](translations_management_guide.md), you can build custom translation workflows and adapt the feature set's behavior to your specific requirements.
The package is designed to be extended in multiple ways.
You can create custom [translation providers](configure_translations_management.md#configure-translation-providers), field type transformers, exclusion rules, and UI components.
In all cases you follow the same pattern: implement an interface or extend a base class, then register the service with a service tag.
The package discovers and registers tagged services automatically.

## Add custom translation provider

Before you build a custom translation provider, make sure that the `ibexa/connector-ai` package has been installed in your system.

To connect a translation service that is not built into the package, implement [`TranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-TranslationProviderInterface.html).
The `translate()` method receives a `TranslationDataInterface` object that carries the text to translate along with the source and target language codes:

``` php hl_lines="31-44"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomProvider.php') =]]
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag.
Both `identifier` and `validation_profile` are required attributes.

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 6) =]]
```

The `validation_profile` attribute links the provider to a validator that checks language codes and payload size before each call.
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

The [`DefaultProviderValidator`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Validator-DefaultProviderValidator.html) class is available as a reusable base with configurable maximum payload size and language code regex patterns.

The package also provides several specialized interfaces for providers with specific requirements:

| Interface | Purpose |
|---|---|
| [`ConfigurableProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-ConfigurableProviderInterface.html) | Extends `TranslationProviderInterface`. Adds `getConfiguration()` and `isConfigured()` for providers that store API keys and other settings |
| [`AiTranslationProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Provider-AiTranslationProviderInterface.html) | Extends `ConfigurableProviderInterface`. Used as a type marker for AI-based providers, it inherits the configuration methods |
| [`TranslationHttpClientInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Http-TranslationHttpClientInterface.html) | For HTTP-based providers that use a REST API pattern |

## Add support for custom field types

The translation engine works by extracting translatable text from fields, sending it to the provider, and writing the translated text back.
This encode/decode cycle is handled by field value transformers, one per field type.
The package includes transformers for standard text and RichText fields.
To add support for a custom or non-standard field type, implement [`FieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-FieldValueTransformerInterface.html):

- `getFieldTypeIdentifier()` - returns the field type identifier this transformer handles
- `encode(Field $field): EncodedFieldValue` - extracts the translatable string from the field and wraps it in an [`EncodedFieldValue`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-EncodedFieldValue.html). The constructor takes the extracted string as its first argument and an optional metadata array as its second.
- `decode(string $value, mixed $previousFieldValue, array $metadata): Value` - receives the translated string, the previous field value, and any metadata, and returns the updated field value


``` php hl_lines="19 24"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/ImageAltTextTransformer.php') =]]
```

Register the transformer with the `ibexa.translations_management.auto_translate.field_value_transformer` tag.
The `field_type_identifier` attribute is required and must match the value returned by `getFieldTypeIdentifier()`:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 14, 17) =]]
```

For field types that require metadata, for example, RichText fields with embedded objects that must be preserved after translation, implement [`MetadataAwareFieldValueTransformerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Transformer-Field-MetadataAwareFieldValueTransformerInterface.html) instead.

## Define custom exclusion rules

Content types that should not use the side-by-side view are identified by exclusion rules.
The Translations management package ships with one rule that excludes content types that contain `ibexa_landing_page` or `ibexa_form` fields.

### Exclude with custom class

To exclude additional content types, for example, content types with fields that are known to behave poorly in the side-by-side layout, implement [`SideBySideExclusionRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Service-SideBySideExclusionRuleInterface.html).
The `isExcluded()` method receives a [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html) object and returns `true` if the content item should be excluded.
Classes that implement this interface are automatically tagged via autoconfigure:

``` php
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyCustomExclusionRule.php') =]]
```

If autoconfigure is not available, register the tag explicitly:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 18, 20) =]]
```

### Exclude with existing class

`MyCustomExclusionRule` targets one specific content type by name. 
To exclude any content type that contain specific field types without the need to write a custom class, register an additional instance of the built-in [`UnsupportedFieldTypeExclusionRule`](https://github.com/ibexa/translations-management/blob/main/src/lib/SideBySide/Service/UnsupportedFieldTypeExclusionRule.php).
Because this registers a second instance of the service with different arguments, you can't use the class name as the service ID.
Use an arbitrary string ID instead to avoid overwriting the package's own registration:

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

Both groups follow the same pattern: if any component renders a non-empty output into the group, the default footer buttons are replaced entirely by the component output.
Therefore, if your component template replaces the defaults, make sure it includes its own action buttons.

Register a component with the `ibexa.twig.component` tag:


``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 27, 31) =]]
```

!!! note

    The `admin-ui-content-translation-modal-footer` group receives a `location` variable that may be `null` when the modal is rendered outside a location context.
    Always check for `null` before you access location properties in your component template.

## Extend the modal

If injecting custom UI elements is not sufficient, you can extend the modal itself.
To add a field to the **Add translation** modal, for example, to let the editor choose a custom workflow or pass extra parameters along with the translation request, extend [`TranslationAddType`](https://github.com/ibexa/admin-ui/blob/main/src/lib/Form/Type/Content/Translation/TranslationAddType.php) with a [Symfony's Form Type extension](https://symfony.com/doc/current/form/create_form_type_extension.html).
It's the same mechanism the translations management package uses internally to inject its provider selector into the modal.

Create a class that extends [`AbstractTypeExtension`](https://symfony.com/doc/current/reference/forms/types/form.html) and declare the extended type:

``` php
[[= include_code('code_samples/translations_management/src/TranslationsManagement/MyTranslationAddExtension.php') =]]
```

Register it as a service:

``` yaml
[[= include_code('code_samples/translations_management/config/services.yaml', 1, 1) =]]
[[= include_code('code_samples/translations_management/config/services.yaml', 11, 13) =]]
```

The extra field is then available in the submitted form data, which the standard `admin-ui` controller passes through the translation flow.
Use this approach when you need to read extra input from the editor, not to redirect or replace the response.

## Intercept translation flow

The `BeforeTranslateEvent` and `TranslateEvent` [events](translations_management_events.md#translation-events) operate at the field-value level and cannot redirect the HTTP flow.
To intercept the "Add translation" action at the HTTP level, for example, to trigger auto-translation and redirect to a custom view, or to bypass the default flow entirely, subscribe to `admin-ui`'s `ContentProxyTranslateEvent`.

The `translations-management` package listens to this event at priority `100`.
Subscribe at a higher priority to act before the package does:

``` php hl_lines="35 36"
[[= include_code('code_samples/translations_management/src/TranslationsManagement/ContentProxyTranslateSubscriber.php') =]]
```

Both highlighted calls are required: 

- `setResponse()` alone does not prevent the translations management listener at priority 100 from running and overwriting the response. 
- `stopPropagation()` stops all lower-priority listeners from executing.

When a response is set on the event, `admin-ui` uses it and doesn't proceed with the standard translation editor.

!!! caution "Internal `ContentProxyTranslateEvent`"

    `ContentProxyTranslateEvent` is marked `@internal` in `ibexa/admin-ui`.
    While it functions as an extension point in practice, its name and signature may change.
    It may even be removed entirely without a deprecation notice.
