# Extend translations management

Add custom classes, exclude custom content types and add support for custom fields.

Editions: LTS Update

By extending [Translations management](../translations_management_guide/index.md), you can adapt the package's behavior to your specific requirements. The package is designed to be extended in multiple ways. You can create custom [translation providers](../configure_translations_management/index.md#configure-translation-providers), field type transformers, exclusion rules, and UI components. In all cases, you follow the same pattern: implement an interface first, then register the service with a service tag. The package discovers and registers tagged services automatically.

## Add custom translation provider

Before you build a custom translation provider, if your provider uses the AI Actions framework, make sure that the `ibexa/connector-ai` package is configured in your system.

### REST API-based provider

To connect a translation service that calls a REST API directly, implement [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Provider/TranslationProviderInterface.php). For providers that store API keys and other required settings, you can rely on [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\ConfigurableProviderInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Provider/ConfigurableProviderInterface.php). It extends `TranslationProviderInterface` and adds `getConfiguration()` and `isConfigured()` methods.

The `translate()` method receives a [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\TranslationDataInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/TranslationDataInterface.php) object that carries the text to translate along with the source and target [language codes](../configure_translations_management/index.md#advanced-translation-provider-options):

```php
<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\TranslationDataInterface;

final readonly class MyCustomProvider implements TranslationProviderInterface
{
    /**
     * Replace MyApiClient with your HTTP client, SDK wrapper, or any service
     * that communicates with the external translation API.
     */
    public function __construct(
        private MyApiClient $apiClient,
    ) {
    }

    public function getIdentifier(): string
    {
        return 'my_custom_provider';
    }

    public function getName(): string
    {
        return 'My Translation Service';
    }

    public function getVendorName(): string
    {
        return 'My Company Ltd';
    }

    public function translate(TranslationDataInterface $translationData): string
    {
        return $this->apiClient->translate(
            $translationData->getText(),
            $translationData->getSourceLanguage(),
            $translationData->getTargetLanguage()
        );
    }

    /** @return array<string> */
    public function getSupportedLanguageCodes(): array
    {
        return ['eng-GB', 'ger-DE', 'fre-FR'];
    }
}
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag. Both `identifier` and [`validation_profile`](#validation-profiles) attributes are required.

```yaml
services:
    App\TranslationsManagement\MyCustomProvider:
        tags:
            - name: 'ibexa.translations_management.auto_translate.provider'
              identifier: 'my_custom_provider'
              validation_profile: 'my_custom_profile'
```

### AI-based provider

To connect a translation service that uses the [AI Actions](../../../ai/ai_actions/ai_actions/index.md) framework, implement [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\AiTranslationProviderInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Provider/AiTranslationProviderInterface.php). This interface extends `ConfigurableProviderInterface` and serves as a type marker for AI-based providers. The system uses the `getConfiguration()` and `isConfigured()` methods to determine whether the provider is available before displaying selectable options in the **Create a new translation** modal:

```php
<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\AiTranslationProviderInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\TranslationDataInterface;

final readonly class MyCustomAiProvider implements AiTranslationProviderInterface
{
    /**
     * Replace MyApiClient with your HTTP client, SDK wrapper, or any service
     * that communicates with the external AI translation API.
     */
    public function __construct(
        private MyApiClient $apiClient,
        private string $actionConfigurationIdentifier,
    ) {
    }

    public function getIdentifier(): string
    {
        return 'my_custom_ai_provider';
    }

    public function getName(): string
    {
        return 'My AI Translation Service';
    }

    public function getVendorName(): string
    {
        return 'My Company Ltd';
    }

    public function translate(TranslationDataInterface $translationData): string
    {
        return $this->apiClient->translate(
            $translationData->getText(),
            $translationData->getSourceLanguage(),
            $translationData->getTargetLanguage()
        );
    }

    /** @return array<string> */
    public function getSupportedLanguageCodes(): array
    {
        return ['eng-GB', 'ger-DE', 'fre-FR'];
    }

    /** @return array<string, mixed> */
    public function getConfiguration(): array
    {
        return [
            'actionConfigurationIdentifier' => $this->actionConfigurationIdentifier,
        ];
    }

    public function isConfigured(): bool
    {
        return $this->actionConfigurationIdentifier !== '';
    }
}
```

Register the provider with the `ibexa.translations_management.auto_translate.provider` tag, with `ai_generic` as the validation profile. The `ai_generic` validation profile is meant to be used by default for AI providers, but you can [implement your own](#validation-profiles).

```yaml
services:
    App\TranslationsManagement\MyCustomAiProvider:
        tags:
            - name: 'ibexa.translations_management.auto_translate.provider'
              identifier: 'my_custom_ai_provider'
              validation_profile: 'ai_generic'
```

If your custom provider integrates with the AI Actions framework, `isConfigured()` should check whether the `actionConfigurationIdentifier` resolves to an existing and enabled Action Configuration.

The `validation_profile`, `supportedLanguageCodes`, and `languageCodesMap` options work the same way as for REST API-based providers.

### Language code normalizer

If your provider uses [language codes](../configure_translations_management/index.md#advanced-translation-provider-options) that differ from the ones used by Ibexa DXP and the `languageCodesMap` configuration is insufficient, implement a custom [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\LanguageNormalizer\LanguageNormalizerInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Provider/LanguageNormalizer/LanguageNormalizerInterface.php) to handle the conversion:

```php
<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Exception\UnsupportedLanguageException;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\LanguageNormalizer\LanguageNormalizerInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface;

final class MyCustomLanguageCodeNormalizer implements LanguageNormalizerInterface
{
    private const array LANGUAGE_MAP = [
        'eng-GB' => 'en-GB',
        'ger-DE' => 'de',
        'fre-FR' => 'fr',
    ];

    public function supports(TranslationProviderInterface $provider): bool
    {
        return $provider->getIdentifier() === 'my_custom_ai_provider';
    }

    public function normalize(
        TranslationProviderInterface $provider,
        string $languageCode
    ): string {
        if (isset(self::LANGUAGE_MAP[$languageCode])) {
            return self::LANGUAGE_MAP[$languageCode];
        }

        throw new UnsupportedLanguageException(
            $languageCode,
            $provider->getIdentifier(),
            array_values(self::LANGUAGE_MAP)
        );
    }
}
```

The `supports()` method is a way to bind the normalizer to a provider. When a translation is triggered, the system checks the registered normalizers, and it uses the first one whose `supports()` method returns `true` for the current provider.

Register the normalizer with the `ibexa.translations_management.auto_translate.provider.language_normalizer` tag:

```yaml
services:
    App\TranslationsManagement\MyCustomLanguageNormalizer:
        tags:
            - name: 'ibexa.translations_management.auto_translate.provider.language_normalizer'
              priority: 10
```

If multiple normalizers are registered, use `priority` to control the order in which they're checked.

### Validation profiles

The `validation_profile` attribute links the provider to a validator that checks language codes and payload size before each translation request. By default, three profiles are available:

| Profile      | Used by                                                      |
| ------------ | ------------------------------------------------------------ |
| `google`     | Google Translate provider                                    |
| `deepl`      | DeepL provider                                               |
| `ai_generic` | All built-in AI providers. Suitable for custom AI providers. |

To define a custom validation profile, implement [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Validator\ProviderValidatorInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Validator/ProviderValidatorInterface.php) and register it:

```yaml
services:
    App\TranslationsManagement\MyProviderValidator:
        tags:
            - name: 'ibexa.translations_management.auto_translate.provider.validator'
              profile: 'my_custom_profile'
```

You can reuse the [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Validator\DefaultProviderValidator`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Validator/DefaultProviderValidator.php) class if it meets your requirements or implement your own. It exposes configurable maximum payload size and language code regex patterns.

## Add support for custom field types

The translation engine works by extracting translatable text from fields, sending it to the provider, and writing the translated text back. Field value transformers handle this encode/decode cycle, one per field type. The package includes transformers for `text`, `RichText`, and `ibexa_landing_page` fields.

To add support for a custom or non-standard field type, implement [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\FieldValueTransformerInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Transformer/Field/FieldValueTransformerInterface.php):

- `getFieldTypeIdentifier()` - returns the field type identifier that this transformer handles
- `encode(Field $field): EncodedFieldValue` - extracts the translatable string from the field and wraps it in an [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\EncodedFieldValue`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Transformer/Field/EncodedFieldValue.php). The constructor takes the extracted string as its first argument and an optional metadata array as the second.
- `decode(string $value, mixed $previousFieldValue, array $metadata): Value` - receives the translated string, the previous field value, and any metadata. Returns the updated field value.

The following example adds support for automatically translating the alternative text of an image:

```php
<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\EncodedFieldValue;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\FieldValueTransformerInterface;
use Ibexa\Core\Base\Exceptions\InvalidArgumentException;
use Ibexa\Core\FieldType\Image\Value as ImageValue;
use Ibexa\Core\FieldType\Value;

final class ImageAltTextTransformer implements FieldValueTransformerInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'ibexa_image';
    }

    public function encode(Field $field): EncodedFieldValue
    {
        $value = $field->getValue();
        if (!$value instanceof ImageValue) {
            throw new InvalidArgumentException(
                '$field',
                sprintf('Expected %s, got %s.', ImageValue::class, get_debug_type($value))
            );
        }

        return new EncodedFieldValue($value->alternativeText ?? '');
    }

    /**
     * @param array<string, mixed> $metadata
     */
    public function decode(string $value, mixed $previousFieldValue, array $metadata): Value
    {
        if (!$previousFieldValue instanceof ImageValue) {
            throw new InvalidArgumentException(
                '$previousFieldValue',
                sprintf('Expected %s, got %s.', ImageValue::class, get_debug_type($previousFieldValue))
            );
        }

        return new ImageValue([
            'id' => $previousFieldValue->id,
            'fileName' => $previousFieldValue->fileName,
            'fileSize' => $previousFieldValue->fileSize,
            'uri' => $previousFieldValue->uri,
            'imageId' => $previousFieldValue->imageId,
            'inputUri' => $previousFieldValue->inputUri,
            'width' => $previousFieldValue->width,
            'height' => $previousFieldValue->height,
            'alternativeText' => $value,
            'additionalData' => $previousFieldValue->additionalData,
            'mime' => $previousFieldValue->mime,
        ]);
    }
}
```

Register the new transformer with the `ibexa.translations_management.auto_translate.field_value_transformer` tag. The `field_type_identifier` attribute is required. It must match the value that `getFieldTypeIdentifier()` returns:

```yaml
services:
    App\TranslationsManagement\ImageAltTextTransformer:
        tags:
            - name: 'ibexa.translations_management.auto_translate.field_value_transformer'
              field_type_identifier: 'ibexa_image'
```

> **Note: Advanced metadata handling**
>
> When metadata is required for decoding or when you need to control what happens if metadata encoding fails, implement [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\MetadataAwareFieldValueTransformerInterface`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Transformer/Field/MetadataAwareFieldValueTransformerInterface.php). With this interface, you can fail the translation when metadata encoding fails and indicate that metadata is required for decoding. Without it, the field is skipped instead.

## Define custom exclusion rules

Use exclusion rules to identify content that cannot use the side-by-side view. The Translations management package ships with one rule that excludes content types that contain `ibexa_landing_page` or `ibexa_form` fields.

### Exclude with custom class

To exclude content from side-by-side view, for example, content types whose fields render incorrectly in the side-by-side layout, implement [`Ibexa\Contracts\TranslationsManagement\SideBySide\Service\SideBySideExclusionRuleInterface`](../../../../../../ibexa/translations-management/src/contracts/SideBySide/Service/SideBySideExclusionRuleInterface.php). The `isExcluded()` method receives a [`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentInfo.php) object, which gives you access to different criteria, including content type, section, owner, main language, publication status, visibility, and main location of the content item. If the content item should be excluded, the method should return `true`.

```php
<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\TranslationsManagement\SideBySide\Service\SideBySideExclusionRuleInterface;

final class MyCustomExclusionRule implements SideBySideExclusionRuleInterface
{
    public function isExcluded(ContentInfo $contentInfo): bool
    {
        return $contentInfo->getContentType()->identifier === 'my_excluded_type';
    }
}
```

Register the rule with the `ibexa.translations_management.side_by_side.exclusion_rule` tag. This interface is not registered for [Symfony autoconfiguration](https://symfony.com/doc/7.4/service_container.html#the-autoconfigure-option), so the tag is required.

```yaml
services:
    App\TranslationsManagement\MyCustomExclusionRule:
        tags:
            - { name: 'ibexa.translations_management.side_by_side.exclusion_rule' }
    app.translations_management.exclusion_rule.custom_field_types:
```

## Use Twig component extension points

Two [Twig component groups](../../../administration/back_office/back_office_elements/custom_components/index.md#translations-management) allow you to inject custom UI elements into the translation interface without the need to override their templates.

Such custom element could be, for example, a disclaimer or policy notice that the editor must acknowledge before a translation is created.

The two groups behave differently:

- `admin-ui-content-translation-modal-footer` — if any of the [components](../../../templating/components/index.md) renders output that is not empty, it entirely replaces the default footer buttons. Your component template must therefore include its own action buttons.
- `admin-ui-content-edit-translation-select-footer` — component output is inserted between the existing **Edit** and **Discard** buttons of the content edit confirmation screen.

Register a component with the `ibexa.twig.component` tag:

```yaml
services:
    App\TranslationsManagement\TwigComponent\MyTranslationModalFooter:
        tags:
            - name: ibexa.twig.component
              group: 'admin-ui-content-translation-modal-footer'
              priority: 10
```

> **Note: Note**
>
> The `admin-ui-content-translation-modal-footer` group receives a `location` variable that may be `null` for an unpublished draft. Always check for `null` before you access location properties in your component template.
