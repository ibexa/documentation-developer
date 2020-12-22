# Creating content

!!! note

    Creating most objects will be impossible for an anonymous user.
    Make sure to [authenticate](public_php_api.md#setting-the-repository-user) as a user with sufficient permissions.

## Creating Content item draft

Value objects such as Content items are read-only, so to create or modify them you need to use structs.

[`ContentService::newContentCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L526)
returns a new [`ContentCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentCreateStruct.php) object.

``` php hl_lines="17 18 21"
//...
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\LocationService;

class CreateContentCommand extends Command
{
    //...
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parentLocationId = $input->getArgument('parentLocationId');
        $contentTypeIdentifier = $input->getArgument('contentType');
        $title = $input->getArgument('title');

        try {
            $contentType = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);
            $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
            $contentCreateStruct->setField('title', $title);
            $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

            $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

            $output->writeln("Created a draft of " . $contentType->getName() . " with name " . $draft->getName());

        } catch //..
    }
}
```

This command creates a draft using [`ContentService::createContent`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L206) (line 21).
This method must receive a `ContentCreateStruct` and an array of Location structs.

`ContentCreateStruct` (which extends `ContentStruct`) is created through [`ContentService::newContentCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L526) (line 17),
which receives the Content Type and the primary language for the Content item.
For information about translating a Content item into other languages, see [Translating content](#translating-content).

[`ContentStruct::setField`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentStruct.php#L32) (line 18) enables you to define the Field values.
When the Field accepts a simple value, you can provide it directly, as in the example above.
For some Field Types, for example [images](#creating-an-image), you need to provide an instance of a Value type.

### Creating an image

Image Field Type requires an instance of its Value type, which you must provide to the [`ContentStruct::setField`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentStruct.php#L32) method.
Therefore, when creating a Content item of the Image type (or any other Content Type with an `image` Field Type),
the `ContentCreateStruct` is slightly more complex than in the previous example:

``` php
$file = '/path/to/image.png';
$name = 'Image name';

$contentType = $this->contentTypeService->loadContentTypeByIdentifier('image');
$contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
$contentCreateStruct->setField('name', $name);
$imageValue = new \eZ\Publish\Core\FieldType\Image\Value(
    array(
        'path' => $file,
        'fileSize' => filesize($file),
        'fileName' => basename($file),
        'alternativeText' => $name
    )
);
$contentCreateStruct->setField('image', $imageValue);
```

Value of the Image Field Type contains the path to the image file, as well as other basic information
based on the input file.

### Creating content with RichText

The RichText Field accepts values in [[= product_name =]]'s variant of the [Docbook](https://github.com/docbook/wiki/wiki) format.
You can see more information about this format in [Field Types reference](field_type_reference.md#example-of-the-field-types-internal-format).

For example, to add a simple RichText paragraph, provide the following as input:

``` xml
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0"><para>Description of your Content item.</para></section>
```

## Publishing a draft

[`ContentService::createContent`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L206) creates a Content item with only one draft version.
To publish it, use [`ContentService::publishVersion`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L336).
This method must get the [`VersionInfo`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/VersionInfo.php) object of a draft version.

``` php
$content = $this->contentService->publishVersion($draft->versionInfo);
```

## Updating content

To update an existing Content item, you need to prepare a [`ContentUpdateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php)
and pass it to [`ContentService::updateContent`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L314)
This method works on a draft, so to publish your changes you need to use [`ContentService::publishVersion`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L336) as well:

``` php
try {
    $contentDraft = $this->contentService->createContentDraft($contentInfo);
    $newName = 'New content name';

    $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
    $contentUpdateStruct->initialLanguageCode = 'eng-GB';
    $contentUpdateStruct->setField('name', $newName);

    $contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
    $this->contentService->publishVersion($contentDraft->versionInfo);

} catch //...
```

## Translating content

Content translations are created per version. By default every version contains all existing translations.

To translate a Content item to a new language, you need to update it and provide a new `initialLanguageCode`:

``` php
$contentDraft = $this->contentService->createContentDraft($contentInfo);
$newLanguage = 'ger-DE';
$translatedName = 'Name in German';

$contentUpdateStruct = $this->contentService->newContentUpdateStruct();
$contentUpdateStruct->initialLanguageCode = $newLanguage;
$contentUpdateStruct->setField('name', $translatedName);

$contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
$this->contentService->publishVersion($contentDraft->versionInfo);
```

You can also update content in multiple languages at once using the `setField` method's third argument.
Only one language can still be set as a version's initial language:

``` php
$anotherLanguagee = 'fre-FR';
$newNameInAnotherLanguage = "Name in French";

$contentUpdateStruct = $this->contentService->newContentUpdateStruct();
$contentUpdateStruct->initialLanguageCode = $newLanguage;
$contentUpdateStruct->setField('name', $newName);
$contentUpdateStruct->setField('name', $newNameInAnotherLanguage, $anotherLanguage);
```

### Deleting a translation

You can delete a single translation from a Content item's version using [`ContentService::deleteTranslationFromDraft`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php#L492)
The method must be provided with a `VersionInfo` object and the code of the language to delete:

``` php
$this->contentService->deleteTranslationFromDraft($versionInfo, $language);
```
