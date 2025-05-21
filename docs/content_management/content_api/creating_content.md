---
description: Create, publish, update and translate content items by using the PHP API.
---

# Creating content

!!! note

    Creating most objects is impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

!!! tip "Content REST API"

    To learn how to create content items using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-content-item).

## Creating content item draft

Value objects such as content items are read-only, so to create or modify them you need to use structs.

[`ContentService::newContentCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_newContentCreateStruct)
returns a new [`ContentCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentCreateStruct.html) object.

``` php hl_lines="2-3 5"
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 62, 71) =]]
```

This command creates a draft using [`ContentService::createContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_createContent) (line 7).
This method must receive a `ContentCreateStruct` and an array of location structs.

`ContentCreateStruct` (which extends `ContentStruct`) is created through [`ContentService::newContentCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_newContentCreateStruct) (line 2),
which receives the content type and the primary language for the content item.
For information about translating a content item into other languages, see [Translating content](#translating-content).

[`ContentStruct::setField`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentStruct.html#method_setField) (line 3) enables you to define the field values.
When the field accepts a simple value, you can provide it directly, as in the example above.
For some field types, for example [images](#creating-an-image), you need to provide an instance of a Value type.

### Creating an image

Image field type requires an instance of its Value type, which you must provide to the [`ContentStruct::setField`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentStruct.html#method_setField) method.
Therefore, when creating a content item of the Image type (or any other content type with an `image` field type),
the `ContentCreateStruct` is slightly more complex than in the previous example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateImageCommand.php', 61, 74) =]]
```

Value of the Image field type contains the path to the image file and other basic information based on the input file.

### Creating content with RichText

The RichText field accepts values in a custom flavor of [Docbook](https://github.com/docbook/wiki/wiki) format.
For example, to add a RichText paragraph, provide the following as input:

``` xml
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml" xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" version="5.0-variant ezpublish-1.0"><para>Description of your content item.</para></section>
```

To learn more about the format and how it represents different elements of rich text, see
[RichText field type reference](richtextfield.md#custom-docbook-format).

## Publishing a draft

[`ContentService::createContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_createContent) creates a content item with only one draft version.
To publish it, use [`ContentService::publishVersion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_publishVersion).
This method must get the [`VersionInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-VersionInfo.html) object of a draft version.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 73, 74) =]]
```

## Updating content

To update an existing content item, you need to prepare a [`ContentUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentUpdateStruct.html)
and pass it to [`ContentService::updateContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_updateContent).
This method works on a draft, so to publish your changes you need to use [`ContentService::publishVersion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_publishVersion) as well:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/UpdateContentCommand.php', 52, 60) =]]
```

## Translating content

Content [translations](languages.md#language-versions) are created per version. By default every version contains all existing translations.

To translate a content item to a new language, you need to update it and provide a new `initialLanguageCode`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 57, 62) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 67, 69) =]]
```

You can also update content in multiple languages at once using the `setField` method's third argument.
Only one language can still be set as a version's initial language:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TranslateContentCommand.php', 64, 65) =]]
```

### Deleting a translation

You can delete a single translation from a content item's version using [`ContentService::deleteTranslationFromDraft`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_deleteTranslationFromDraft).
The method must be provided with a `VersionInfo` object and the code of the language to delete:

``` php
$this->contentService->deleteTranslationFromDraft($versionInfo, $language);
```
