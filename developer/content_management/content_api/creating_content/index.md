# Creating content

Create, publish, update and translate content items by using the PHP API.

> **Note: Note**
>
> Creating most objects is impossible for an anonymous user. Make sure to [authenticate](../../../api/php_api/php_api/index.md#setting-the-repository-user) as a user with sufficient permissions.

> **Tip: Content REST API**
>
> To learn how to create content items using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Objects/operation/api_contentobjects_post).

## Creating content item draft

Value objects such as content items are read-only, so to create or modify them you need to use structs.

[`ContentService::newContentCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) returns a new [`Ibexa\Contracts\Core\Repository\Values\Content\ContentCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentCreateStruct.php) object.

```php
$contentType = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);
$contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
$contentCreateStruct->setField('name', $name);

$locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

$draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

$output->writeln('Created a draft of ' . $contentType->getName() . ' with name ' . $draft->getName());
```

This command creates a draft using [`ContentService::createContent`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) (line 6). This method must receive a `ContentCreateStruct` and an array of location structs.

`ContentCreateStruct` (which extends `ContentStruct`) is created through [`ContentService::newContentCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) (line 1), which receives the content type and the primary language for the content item. For information about translating a content item into other languages, see [Translating content](#translating-content).

[`ContentStruct::setField`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentStruct.php) (line 2) enables you to define the field values. When the field accepts a simple value, you can provide it directly, as in the example above. For some field types, for example [images](#creating-an-image), you need to provide an instance of a Value type.

### Creating an image

Image field type requires an instance of its Value type, which you must provide to the [`ContentStruct::setField`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentStruct.php) method. Therefore, when creating a content item of the Image type (or any other content type with an `image` field type), the `ContentCreateStruct` is slightly more complex than in the previous example:

```php
$contentType = $this->contentTypeService->loadContentTypeByIdentifier('image');
$contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
$contentCreateStruct->setField('name', $name);
$imageValue = new Value(
    [
        'path' => $file,
        'fileSize' => filesize($file),
        'fileName' => basename((string) $file),
        'alternativeText' => $name,
    ]
);
$contentCreateStruct->setField('image', $imageValue);
```

Value of the Image field type contains the path to the image file and other basic information based on the input file.

### Creating content with RichText

The RichText field accepts values in a custom flavor of [DocBook](https://github.com/docbook/wiki/wiki) format. For example, to add a RichText paragraph, provide the following as input:

```xml
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml" xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" version="5.0-variant ezpublish-1.0"><para>Description of your content item.</para></section>
```

To learn more about the format and how it represents different elements of rich text, see [RichText field type reference](../../field_types/field_type_reference/richtextfield/index.md#custom-docbook-format).

## Publishing a draft

[`ContentService::createContent`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) creates a content item with only one draft version. To publish it, use [`ContentService::publishVersion`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php). This method must get the [`Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/VersionInfo.php) object of a draft version.

```php
$content = $this->contentService->publishVersion($draft->versionInfo);
```

## Updating content

To update an existing content item, you need to prepare a [`Ibexa\Contracts\Core\Repository\Values\Content\ContentUpdateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentUpdateStruct.php) and pass it to [`ContentService::updateContent`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php). This method works on a draft, so to publish your changes you need to use [`ContentService::publishVersion`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) as well:

```php
$contentInfo = $this->contentService->loadContentInfo($contentId);
$contentDraft = $this->contentService->createContentDraft($contentInfo);

$contentUpdateStruct = $this->contentService->newContentUpdateStruct();
$contentUpdateStruct->initialLanguageCode = 'eng-GB';
$contentUpdateStruct->setField('name', $newName);

$contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
$this->contentService->publishVersion($contentDraft->versionInfo);
```

## Translating content

Content [translations](../../../multisite/languages/languages/index.md#language-versions) are created per version. By default every version contains all existing translations.

To translate a content item to a new language, you need to update it and provide a new `initialLanguageCode`:

```php
        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $contentDraft = $this->contentService->createContentDraft($contentInfo);

        $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
        $contentUpdateStruct->initialLanguageCode = $language;
        $contentUpdateStruct->setField('name', $newName);


        $contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
        $this->contentService->publishVersion($contentDraft->versionInfo);
```

You can also update content in multiple languages at once using the `setField` method's third argument. Only one language can still be set as a version's initial language:

```php
$contentUpdateStruct->setField('name', $nameInSecondaryLanguage, $secondaryLanguage);
```

### Deleting a translation

You can delete a single translation from a content item's version using [`ContentService::deleteTranslationFromDraft`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php). The method must be provided with a `VersionInfo` object and the code of the language to delete:

```php
/** @var \Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo $versionInfo */
$languageCode = 'ger-DE';
/** @var \Ibexa\Contracts\Core\Repository\ContentService $contentService */
$contentService->deleteTranslationFromDraft($versionInfo, $languageCode);
```
