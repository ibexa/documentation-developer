# Automated content translation

With the automated translation add-on, users can translate content items into multiple languages with Google Translate or DeepL.

With the automated translation add-on package, users can translate their content items into multiple languages automatically by using either Google Translate or DeepL external translation engine. The package integrates with Ibexa DXP, and allows users to [request from the UI](../../../../user/content_management/translate_content/index.md#add-translations) that a content item is translated. However, you can also run a Console Command to translate a specific content item. Either way, as a result, a new version of the content item is created.

The following field types are supported out of the box:

- [TextLine](../../../content_management/field_types/field_type_reference/textlinefield/index.md)
- [TextBlock](../../../content_management/field_types/field_type_reference/textblockfield/index.md)
- [RichText](../../../content_management/field_types/field_type_reference/richtextfield/index.md)
- [Page](../../../content_management/field_types/field_type_reference/pagefield/index.md): the content of `text` and `richtext` [block attributes](../../../content_management/pages/page_block_attributes/index.md#block-attribute-types)

See [adding a custom field or block attribute encoder](#create-custom-field-or-block-attribute-encoder) for more information on how you can extend this list.

> **Note: Note**
>
> If you're currently using Automated translations, consider migrating to [Translations management](../../translations_management/translations_management_guide/index.md).

## Configure automated content translation

### Install package

The automated content translation feature comes as an additional package that you must download and install separately:

```bash
composer require ibexa/automated-translation
```

> **Caution: Modify the default configuration**
>
> Symfony Flex installs and activates the package. However, you must modify the `config/bundles.php` file to change the bundle loading order so that `IbexaAutomatedTranslationBundle` is loaded before `IbexaAdminUiBundle`:
>
> ```php
> <?php
>
> return [
>     // ...
>     Ibexa\Bundle\AutomatedTranslation\IbexaAutomatedTranslationBundle::class => ['all' => true],
>     Ibexa\Bundle\AdminUi\IbexaAdminUiBundle::class => ['all' => true],
>     // ...
> ];
> ```

### Configure access to translation services

Before you can start using the feature, you must configure access to your Google and/or DeepL account.

1. Get the [Google API key](https://developers.google.com/maps/documentation/javascript/get-api-key) and/or [DeepL Pro key](https://support.deepl.com/hc/en-us/articles/360020695820-API-key-for-DeepL-API).

2. Set these values in the YAML configuration files, under the `ibexa_automated_translation.system.default.configurations` key:

```yaml
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

```bash
php bin/console ibexa:automated:translate --from=eng-GB --to=fre-FR 52 google
```

## Extend automated content translations

### Add a custom machine translation service

By default, the automated translation package can connect to Google Translate or DeepL, but you can configure it to use a custom machine translation service. You would do it, for example, when a new service emerges on the market, or your company requires that a specific service is used.

The following example adds a new translation service. It uses the [AI actions framework](../../../ai/ai_actions/ai_actions/index.md) and assumes a custom `TranslateAction` AI Action exists. To learn how to build custom AI actions see [Extending AI actions](../../../ai/ai_actions/extend_ai_actions/index.md#custom-action-type-use-case).

1. Create a service that implements the [`\Ibexa\AutomatedTranslation\Client\ClientInterface`](../../../../../../ibexa/automated-translation/src/contracts/Client/ClientInterface.php) interface:

```php
<?php declare(strict_types=1);

namespace App\AutomatedTranslation;

use Ibexa\Contracts\AutomatedTranslation\Client\ClientInterface;
use Ibexa\Contracts\AutomatedTranslation\Exception\ClientNotConfiguredException;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface;
use Ibexa\Contracts\ConnectorAi\ActionServiceInterface;

final class AiClient implements ClientInterface
{
    /** @var array<string> */
    private array $supportedLanguages;

    public function __construct(
        private readonly ActionServiceInterface $actionService,
        private readonly ActionConfigurationServiceInterface $actionConfigurationService
    ) {
    }

    public function setConfiguration(array $configuration): void
    {
        if (!array_key_exists('languages', $configuration)) {
            throw new ClientNotConfiguredException('List of supported languages is missing in the configuration under the "languages" key');
        }
        $this->supportedLanguages = $configuration['languages'];
    }

    public function translate(string $payload, ?string $from, string $to): string
    {
        $action = new TranslateAction(new Text([$payload]));
        $action->setRuntimeContext(
            new RuntimeContext(
                [
                    'from' => $from,
                    'to' => $to,
                ]
            )
        );
        $actionConfiguration = $this->actionConfigurationService->getActionConfiguration('translate');
        $actionResponse = $this->actionService->execute($action, $actionConfiguration)->getOutput();

        assert($actionResponse instanceof Text);

        return $actionResponse->getText();
    }

    public function supportsLanguage(string $languageCode): bool
    {
        return in_array($languageCode, $this->supportedLanguages, true);
    }

    public function getServiceAlias(): string
    {
        return 'aiclient';
    }

    public function getServiceFullName(): string
    {
        return 'Custom AI Automated Translation';
    }
}
```

2. Tag the service as `ibexa.automated_translation.client` in the Symfony container:

```yaml
    App\AutomatedTranslation\AiClient:
        tags:
            - ibexa.automated_translation.client
```

3. Specify the configuration under the `ibexa_automated_translation.system.default.configurations` key:

```yaml
ibexa_automated_translation:
    system:
        default:
            configurations:
                aiclient:
                    languages:
                        - 'en_GB'
                        - 'fr_FR'
```

### Create custom field or block attribute encoder

You can expand the list of supported field types and block attributes for automated translation, adding support for even more use cases than the ones built into Ibexa DXP.

The whole automated translation process consists of 3 phases:

1. **Encoding** - data is extracted from the field types and block attributes and serialized into XML format
2. **Translating** - the serialized XML is sent into specified translation service
3. **Decoding** - the translated response is deserialized into the original data structures for storage in Ibexa DXP

The following example adds support for automatically translating alternative text in image fields.

1. Create a class implementing the [`Ibexa\Contracts\AutomatedTranslation\Encoder\Field\FieldEncoderInterface`](../../../../../../ibexa/automated-translation/src/contracts/Encoder/Field/FieldEncoderInterface.php) and add the required methods:

```php
<?php declare(strict_types=1);

namespace App\AutomatedTranslation;

use Ibexa\Contracts\AutomatedTranslation\Encoder\Field\FieldEncoderInterface;
use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Core\FieldType\Image\Value;

final class ImageFieldEncoder implements FieldEncoderInterface
{
    public function canEncode(Field $field): bool
    {
        return $field->fieldTypeIdentifier === 'ibexa_image';
    }

    public function canDecode(string $type): bool
    {
        return $type === 'ibexa_image';
    }

    public function encode(Field $field): string
    {
        /** @var \Ibexa\Core\FieldType\Image\Value $value */
        $value = $field->getValue();

        return $value->alternativeText ?? '';
    }

    /**
     * @param string $value
     * @param \Ibexa\Core\FieldType\Image\Value $previousFieldValue
     */
    public function decode(string $value, $previousFieldValue): Value
    {
        $previousFieldValue->alternativeText = $value;

        return $previousFieldValue;
    }
}
```

In this example, the methods are responsible for:

- `canEncode` - deciding whether the field to be encoded is an [Image](../../../content_management/field_types/field_type_reference/imagefield/index.md) field
- `canDecode` - deciding whether the field to be decoded is an [Image](../../../content_management/field_types/field_type_reference/imagefield/index.md) field
- `encode` - extracting the alternative text from the field type
- `decode` - saving the translated alternative text in the field type's value object

2. Register the class as a service. If you're not using [Symfony's autoconfiguration](https://symfony.com/doc/7.4/service_container.html#the-autoconfigure-option), use the `ibexa.automated_translation.field_encoder` service tag.

```yaml
    App\AutomatedTranslation\ImageFieldEncoder:
        tags:
            - ibexa.automated_translation.field_encoder
```

For custom block attributes, the appropriate interface is [`Ibexa\Contracts\AutomatedTranslation\Encoder\BlockAttribute\BlockAttributeEncoderInterface`](../../../../../../ibexa/automated-translation/src/contracts/Encoder/BlockAttribute/BlockAttributeEncoderInterface.php) and the service tag is `ibexa.automated_translation.block_attribute_encoder`.
