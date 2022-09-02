---
description: Create, publish, update and translate Content items by using the PHP API.
---

# Creating content

!!! note

    Creating most objects will be impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

!!! tip "Content REST API"

    To learn how to create Content items using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-content-item).

## Creating Content item draft

Value objects such as Content items are read-only, so to create or modify them you need to use structs.

[`ContentService::newContentCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L533)
returns a new [`ContentCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentCreateStruct.php) object.

``` php hl_lines="2-3 5"
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 57, 66) =]]
```

This command creates a draft using [`ContentService::createContent`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L210) (line 21).
This method must receive a `ContentCreateStruct` and an array of Location structs.

`ContentCreateStruct` (which extends `ContentStruct`) is created through [`ContentService::newContentCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L533) (line 17),
which receives the Content Type and the primary language for the Content item.
For information about translating a Content item into other languages, see [Translating content](#translating-content).

[`ContentStruct::setField`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentStruct.php#L32) (line 18) enables you to define the Field values.
When the Field accepts a simple value, you can provide it directly, as in the example above.
For some Field Types, for example [images](#creating-an-image), you need to provide an instance of a Value type.

### Creating an image

Image Field Type requires an instance of its Value type, which you must provide to the [`ContentStruct::setField`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentStruct.php#L32) method.
Therefore, when creating a Content item of the Image type (or any other Content Type with an `image` Field Type),
the `ContentCreateStruct` is slightly more complex than in the previous example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateImageCommand.php', 56, 67) =]]
```

Value of the Image Field Type contains the path to the image file, as well as other basic information
based on the input file.

### Creating content with RichText

The RichText Field accepts values in a custom flavor of [Docbook](https://github.com/docbook/wiki/wiki) format.
For example, to add a simple RichText paragraph, provide the following as input:

``` xml
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0"><para>Description of your Content item.</para></section>
```

To learn more about the format and how it represents different elements of rich text, see
[RichText Field Type reference](richtextfield.md#custom-docbook-format).

## Publishing a draft

[`ContentService::createContent`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L210) creates a Content item with only one draft version.
To publish it, use [`ContentService::publishVersion`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L343).
This method must get the [`VersionInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/VersionInfo.php) object of a draft version.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 68, 69) =]]
```

## Updating content

To update an existing Content item, you need to prepare a [`ContentUpdateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php)
and pass it to [`ContentService::updateContent`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L320)
This method works on a draft, so to publish your changes you need to use [`ContentService::publishVersion`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L343) as well:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/UpdateContentCommand.php', 47, 55) =]]
```

## Translating content

Content [translations](languages.md#language-versions) are created per version. By default every version contains all existing translations.

To translate a Content item to a new language, you need to update it and provide a new `initialLanguageCode`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 53, 58) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 63, 65) =]]
```

You can also update content in multiple languages at once using the `setField` method's third argument.
Only one language can still be set as a version's initial language:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 60, 61) =]]
```

### Deleting a translation

You can delete a single translation from a Content item's version using [`ContentService::deleteTranslationFromDraft`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L499)
The method must be provided with a `VersionInfo` object and the code of the language to delete:

``` php
$this->contentService->deleteTranslationFromDraft($versionInfo, $language);
```
