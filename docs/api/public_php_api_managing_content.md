# Managing Content

In the following recipes, you will see how to create Content.

## Identifying to the repository with a login and a password

As seen earlier, the Repository executes operations with a user's credentials. In a web context, the currently logged-in user is automatically identified. In a command line context, you need to manually log a user in. You have already seen how to manually load and set a user using their login. If you would like to identify a user using their credentials instead, this can be achieved in the following way:

**authentication**

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByCredentials( $username, $password );
$permissionResolver->setCurrentUserReference($user);
```

## Creating content

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateContentCommand.php>

You will now see how to create Content using the public API. This example will work with the default Folder (ID 1) Content Type from eZ Platform.

``` php
/** @var $repository \eZ\Publish\API\Repository\Repository */
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$locationService = $repository->getLocationService();
$contentTypeService = $repository->getContentTypeService();
```

First, you need the required services. In this case: `ContentService`, `LocationService` and `ContentTypeService`.

### The ContentCreateStruct

As explained in the [Public PHP API section](public_php_api.md#value-info-objects), value objects are read only. Dedicated objects are provided for Update and Create operations: structs, like `ContentCreateStruct` or `UpdateCreateStruct`. In this case, you need to use a `ContentCreateStruct`.

``` php
$contentType = $contentTypeService->loadContentTypeByIdentifier( 'article' );
$contentCreateStruct = $contentService->newContentCreateStruct( $contentType, 'eng-GB' );
```

First get the [`ContentType`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/ContentType/ContentType.html) you want to create a `Content` with. To do so, use [`ContentTypeService::loadContentTypeByIdentifier()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_loadContentTypeByIdentifier), with the wanted `ContentType` identifier, like 'article'. Finally get a `ContentTypeCreateStruct` using [`ContentService::newContentCreateStruct()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_newContentCreateStruct), providing the Content Type and a Locale Code (eng-GB).

### Setting the fields values

``` php
$contentCreateStruct->setField( 'title', 'My title' );
$contentCreateStruct->setField( 'intro', $intro );
$contentCreateStruct->setField( 'body', $body );
```

Using your create struct, you can now set the values for our Content item's Fields, using the [`setField()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentCreateStruct.html#method_setField) method. For now, you will just set the title. `setField()` for a TextLine Field simply expects a string as input argument. More complex Field Types, like Author or Image, expect different input values.

The `ContentCreateStruct::setField()` method can take several type of arguments.

In any case, whatever the Field Type is, a Value of this type can be provided. For instance, a TextLine\\Value can be provided for a TextLine\\Type. Depending on the Field Type implementation itself, more specifically on the `fromHash()` method every Field Type implements, various arrays can be accepted, as well as primitive types, depending on the Type.

### Setting the Location

In order to set a Location for your object, you must instantiate a [`LocationCreateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/LocationCreateStruct.html). This is done with `LocationService::newLocationCreateStruct()`, with the new Location's parent ID as an argument.

``` php
$locationCreateStruct = $locationService->newLocationCreateStruct( 2 );
```

### Creating and publishing

To actually create your Content in the Repository, you need to use `ContentService::createContent()`. This method expects a `ContentCreateStruct`, as well as a `LocationCreateStruct`. You have created both in the previous steps.

``` php
$draft = $contentService->createContent( $contentCreateStruct, array( $locationCreateStruct ) );
$content = $contentService->publishVersion( $draft->versionInfo );
```

The `LocationCreateStruct` is provided as an array, since a Content item can have multiple Locations.

`createContent()` returns a new Content value object, with one version that has the DRAFT status. To make this Content visible, you need to publish it. This is done using `ContentService::publishVersion()`. This method expects a `VersionInfo` object as its parameter. In your case, simply use the current version from `$draft`, with the `versionInfo` property.

## Updating Content

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/UpdateContentCommand.php>

You will now see how the previously created Content can be updated. To do so, you will create a new draft for your Content, update it using a [`ContentUpdateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.html), and publish the updated Version.

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
$contentDraft = $contentService->createContentDraft( $contentInfo );
```

To create your draft, you need to load the Content item's ContentInfo using `ContentService::loadContentInfo()`. You can then use `ContentService::createContentDraft()` to add a new Draft to your Content.

``` php
// instantiate a content update struct and set the new fields
$contentUpdateStruct = $contentService->newContentUpdateStruct();
$contentUpdateStruct->initialLanguageCode = 'eng-GB'; // set language for new version
$contentUpdateStruct->setField( 'title', $newTitle );
$contentUpdateStruct->setField( 'body', $newBody );
```

To set the new values for this version, you request a `ContentUpdateStruct` from the `ContentService` using the `newContentUpdateStruct()` method. Updating the values hasn't changed: you use the `setField()` method.

``` php
$contentDraft = $contentService->updateContent( $contentDraft->versionInfo, $contentUpdateStruct );
$content = $contentService->publishVersion( $contentDraft->versionInfo );
```

You can now use `ContentService::updateContent()` to apply your `ContentUpdateStruct` to your draft's `VersionInfo`. Publishing is done exactly the same way as for a new Content, using `ContentService::publishVersion()`.

## Handling translations

In the two previous examples, you set the ContentUpdateStruct's `initialLanguageCode` property. To translate an object to a new language, set the locale to a new one.

### translating

``` php
$contentUpdateStruct->initialLanguageCode = 'ger-DE';
$contentUpdateStruct->setField( 'title', $newtitle );
$contentUpdateStruct->setField( 'body', $newbody );
```

It is possible to create or update content in multiple languages at once. There is one restriction: only one language can be set a version's language. This language is the one that will get a flag in the Back Office. However, you can set values in other languages for your attributes, using the `setField` method's third argument.

### update multiple languages

``` php
// set one language for new version
$contentUpdateStruct->initialLanguageCode = 'fre-FR';

$contentUpdateStruct->setField( 'title', $newgermantitle, 'ger-DE' );
$contentUpdateStruct->setField( 'body', $newgermanbody, 'ger-DE' );

$contentUpdateStruct->setField( 'title', $newfrenchtitle );
$contentUpdateStruct->setField( 'body', $newfrenchbody );
```

Since you did not specify a locale for the last two fields, they are set for the `UpdateStruct`'s `initialLanguageCode`, fre-FR.

### Delete translations

#### Delete translations from a Content item version

To delete translations from a Content item version, use the `deleteTranslationFromDraft` method on `ContentService`.

```
public function deleteTranslationFromDraft(VersionInfo $versionInfo, string $languageCode) : Content
```

This method returns a Content draft without the specified translation.

!!! note

    To remove the main translation, the main language needs to be changed manually
    using the `ContentService::updateContentMetadata` method first.
    Otherwise the method will throw an `\eZ\Publish\API\Repository\Exceptions\BadStateException`.


The PHP API consumer is responsible for creating a Content item version draft and publishing it after translation removal.

Since the returned Content draft is to be published, both search and HTTP cache are already handled
by `PublishVersion` slots once the call to `publishVersion()` is made.

Example:

``` php
$repository->beginTransaction();
/** @var \eZ\Publish\API\Repository\Repository $repository */
try {
    $versionInfo = $contentService->loadVersionInfoById($contentId, $versionNo);
    $contentDraft = $contentService->createContentDraft($versionInfo->contentInfo, $versionInfo);
    $contentDraft = $contentService->deleteTranslationFromDraft($contentDraft->versionInfo, $languageCode);
    $contentService->publishVersion($contentDraft->versionInfo);

    $repository->commit();
} catch (\Exception $e) {
    $repository->rollback();
    throw $e;
}
```

## Creating Content containing an image

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateImageCommand.php>

As explained above, the `setField()` method can accept various values: an instance of the Field Type's Value class, a primitive type, or a hash. The last two depend on what the `Type::acceptValue()` method is build up to handle. TextLine can, for instance, accept a simple string as an input value. In this example, you will see how to set an Image value.

Let's assume that you use the default image class. Creating your Content, using the Content Type and a `ContentCreateStruct`, has been covered above, and can be found in the full code. Let's focus on how the image is provided.

``` php
$file = '/path/to/image.png';

$value = new \eZ\Publish\Core\FieldType\Image\Value(
    array(
        'path' => '/path/to/image.png',
        'fileSize' => filesize( '/path/to/image.png' ),
        'fileName' => basename( 'image.png' ),
        'alternativeText' => 'My image'
    )
);
$contentCreateStruct->setField( 'image', $value );
```

This time, create your image by directly providing an [`Image\Value`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/Core/FieldType/Image/Value.html) object. The values are directly provided to the constructor using a hash with predetermined keys that depend on each Type. In this case: the path where the image can be found, its size, the file name, and an alternative text.

Images also implement a static [`fromString()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/Core/FieldType/Image/Value.html#method_fromString) method that will, given a path to an image, return an `Image\Value` object.

``` php
$value = \eZ\Publish\Core\FieldType\Image\Value::fromString( '/path/to/image.png' );
```

But as said before, whatever you provide `setField()` with is sent to the `acceptValue()` method. This method really is the entry point to the input formats a Field Type accepts. In this case, you could have provided setField with either a hash, similar to the one you provided the Image\\Value constructor with, or the path to your image, as a string.

``` php
$contentCreateStruct->setField( 'image', '/path/to/image.png' );

// or

$contentCreateStruct->setField( 'image', array(
    'path' => '/path/to/image.png',
    'fileSize' => filesize( '/path/to/image.png' ),
    'fileName' => basename( 'image.png' ),
    'alternativeText' => 'My image'
);
```

## Create Content with XML Text

The XML Text Field Type is not officially supported by eZ Platform, it was replaced by RichText. PlatformUI also does not support WYSIWYG editing of Fields of this type.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateXmlContentCommand.php>

**Working with XML Text**

!!! warning

    The XML Text is not officially supported, it was replaced by RichText.

``` php
$xmlText = <<< EOX
<?xml version='1.0' encoding='utf-8'?>
<section>
<paragraph>This is a <strong>image test</strong></paragraph>
<paragraph><embed view='embed' size='medium' object_id='$imageId'/></paragraph>
</section>
EOX;
$contentCreateStruct->setField( 'body', $xmlText );
```

As for the last example above, use the multiple formats accepted by `setField()`, and provide your XML string as is. The only accepted format is internal XML, the one stored in the Legacy database.

!!! note

    The XSD for the internal XML representation can be found in a separate dependency: <https://github.com/ezsystems/ezplatform-xmltext-fieldtype>.

You embed an image in your XML, using the `<embed>` tag, providing an image Content ID as the `object_id` attribute.

!!! note "Using a custom format as input"

    More input formats will be added later. The API for that is actually already available: you simply need to implement the [`XmlText\Input`](https://github.com/ezsystems/ezplatform-xmltext-fieldtype/tree/master/lib/FieldType/XmlText/Input) interface. It contains one method, `getInternalRepresentation()` that must return an internal XML string. Create your own bundle, add your implementation to it, and use it in your code.

``` php
$input = new \My\XmlText\CustomInput( 'My custom format string' );
$contentCreateStruct->setField( 'body', $input );
```

## Assigning Section to content

!!! note "Full code"

    [https://github.com/ezsystems/CookbookBundle/tree/master/Command/AssignContentToSectionCommand.php](https://github.com/docb22/ez-publish-cookbook/tree/master/EzSystems/CookBookBundle/Command/AssignContentToSectionCommand.php)

The Section that a Content item belongs to can be set during creation, using the `ContentCreateStruct::$sectionId` property. However, as for many Repository objects properties, the Section can't be changed using a `ContentUpdateStruct`. The reason is still the same: changing a Content item's Section will affect the subtrees referenced by its Locations. For this reason, it is required that you use the `SectionService`. to change the Section of a Content item.

**assign section to content**

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
$section = $sectionService->loadSection( $sectionId );
$sectionService->assignSection( $contentInfo, $section );
```

This operation involves the `SectionService`, as well as the `ContentService`.

**assign section to content**

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

Use `ContentService::loadContentInfo()` to get the Content you want to update the Section for.

**assign section to content**

``` php
$section = $sectionService->loadSection( $sectionId );
```

`SectionService::loadSection()` is then used to load the Section you want to assign your Content to. Note that there is no `SectionInfo` object. Sections are quite simple, and you don't need to separate their metadata from their actual data. However, `SectionCreateStruct` and [`SectionUpdateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/SectionUpdateStruct.html) objects must still be used to create and update Sections.

**assign section to content**

``` php
$sectionService->assignSection( $contentInfo, $section );
```

The actual update operation is done using `SectionService::assignSection()`, with the `ContentInfo` and the Section as arguments.

`SectionService::assignSection()` won't return the updated Content, as it has no knowledge of those objects. To get the Content with the newly assigned Location, you need to reload the `ContentInfo` using [`ContentService::loadContentInfo()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadContentInfo). This is also valid for descendants of the Content item. If you have any stored in your execution state, you need to reload them. Otherwise you would be using outdated Content data.

## Creating a Content Type

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateContentTypeCommand.php>

Creating a `ContentType` is actually almost more complex than creating Content. It really isn't as common, and does not require the same kind of API as Content.

Let's split the code in three major parts.

``` php
try
{
    $contentTypeGroup = $contentTypeService->loadContentTypeGroupByIdentifier( 'content' );
}
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "content type group with identifier $groupIdentifier not found" );
    return;
}


$contentTypeCreateStruct = $contentTypeService->newContentTypeCreateStruct( 'mycontenttype' );
$contentTypeCreateStruct->mainLanguageCode = 'eng-GB';
$contentTypeCreateStruct->nameSchema = '<title>';
$contentTypeCreateStruct->names = array(
    'eng-GB' => 'My content type'
);
$contentTypeCreateStruct->descriptions = array(
    'eng-GB' => 'Description for my content type',
);
```

First, you need to load the `ContentTypeGroup` your `ContentType` will be created in. You do this using [`ContentTypeService::loadContentTypeGroupByIdentifier()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_loadContentTypeGroupByIdentifier), which gives you back a `ContentTypeGroup` object. As for content, you then request a `ContentTypeCreateStruct` from the `ContentTypeService`, using `ContentTypeService::newContentTypeCreateStruct()`, with the desired identifier as the argument.

Using the create struct's properties, you can set the Type's properties:

-   the main language (`mainLanguageCode`) for the Type is set to eng-GB,
-   the content name generation pattern (`nameSchema`) is set to '&lt;title&gt;': Content items of this type will be named the same as their 'title' field.
-   the human-readable name for your Type is set using the `names` property. You give it a hash, indexed by the locale ('eng-GB') the name is set in. This locale must exist in the system.
-   the same way that you have set the `names` property, you can set human-readable descriptions, again as hashes indexed by locale code.

The next big part is to add `FieldDefinition` objects to your Content Type.

```php
// add a TextLine Field with identifier 'title'
$titleFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( 'title', 'ezstring' );
$titleFieldCreateStruct->names = array( 'eng-GB' => 'Title' );
$titleFieldCreateStruct->descriptions = array( 'eng-GB' => 'The Title' );
$titleFieldCreateStruct->fieldGroup = 'content';
$titleFieldCreateStruct->position = 10;
$titleFieldCreateStruct->isTranslatable = true;
$titleFieldCreateStruct->isRequired = true;
$titleFieldCreateStruct->isSearchable = true;
$contentTypeCreateStruct->addFieldDefinition( $titleFieldCreateStruct );


// add a TextLine Field body field
$bodyFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( 'body', 'ezstring' );
$bodyFieldCreateStruct->names = array( 'eng-GB' => 'Body' );
$bodyFieldCreateStruct->descriptions = array( 'eng-GB' => 'Description for Body' );
$bodyFieldCreateStruct->fieldGroup = 'content';
$bodyFieldCreateStruct->position = 20;
$bodyFieldCreateStruct->isTranslatable = true;
$bodyFieldCreateStruct->isRequired = true;
$bodyFieldCreateStruct->isSearchable = true;
$contentTypeCreateStruct->addFieldDefinition( $bodyFieldCreateStruct );
```

You need to create a `FieldDefinitionCreateStruct` object for each `FieldDefinition` your `ContentType` will be made of. Those objects are obtained using [`ContentTypeService::newFieldDefinitionCreateStruct()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_newFieldDefinitionCreateStruct). This method expects the `FieldDefinition` identifier and its type as arguments. The identifiers match the ones from eZ Publish 4 (`ezstring` for TextLine, etc.).

Each field's properties are set using the create struct's properties:

-   `names` and `descriptions` are set using hashes indexed by the locale code, and with the name or description as an argument.
-   The `fieldGroup` is set to 'content'
-   Fields are ordered using the `position` property, ordered numerically in ascending order. It is set to an integer.
-   The translatable, required and searchable boolean flags are set using their respective property: `isTranslatable`, `isRequired` and `isSearchable`.

Once the properties for each create struct are set, the field is added to the Content Type create struct using [`ContentTypeCreateStruct::addFieldDefinition()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/ContentType/ContentTypeCreateStruct.html#method_addFieldDefinition).

``` php
try
{
    $contentTypeDraft = $contentTypeService->createContentType( $contentTypeCreateStruct, array( $contentTypeGroup ) );
    $contentTypeService->publishContentTypeDraft( $contentTypeDraft );
}
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>" . $e->getMessage() . "</error>" );
}
catch ( \eZ\Publish\API\Repository\Exceptions\ForbiddenException $e )
{
    $output->writeln( "<error>" . $e->getMessage() . "</error>" );
}
```

The last step is the same as for Content: create a Content Type draft using `ContentTypeService::createContentType()`, with the `ContentTypeCreateStruct` and an array of `ContentTypeGroup` objects are arguments. Then publish the Content Type draft using `ContentTypeService::publishContentTypeDraft()`.

## Deleting Content

``` php
$contentService->deleteContent( $contentInfo );
```

[`ContentService::deleteContent()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_deleteContent) method expects a `ContentInfo` as an argument. It will delete the given Content item, all of its Locations, as well as all of the Content item's Locations' descendants and their associated Content.

!!! caution

    Use with caution as deleted content cannot be recovered.
