# Managing content

## Locations

You can manage [Locations](../guide/content_management.md#locations) that hold content
using [`LocationService`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php)

### Adding a new Location to a Content item

Every published Content item must have at least one Location.
One Content item can have more that one Location, which means it is presented in more than one place
in the content tree.

Creating a new Location, like creating content, requires using a struct,
because a Location value object is read-only.

To add a new Location to existing content you need to create
a [`LocationCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/LocationCreateStruct.php)
and pass it to the [`LocationService::createLocation`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L140) method:

``` php
$locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);
$contentInfo = $this->contentService->loadContentInfo($contentId);
$newLocation = $this->locationService->createLocation($contentInfo, $locationCreateStruct);
```

`LocationCreateStruct` must receive the parent Location ID.
It sets the `parentLocationId` property of the new Location.

You can also provide other properties for the Location, otherwise they will be set to their defaults:

``` php
$locationCreateStruct->priority = 500;
$locationCreateStruct->hidden = true;
```

### Changing the main Location

When a Content item has more that one Location, one Location is always considered the main one.
You can change the main Location using [`ContentService`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentService.php),
by updating the `ContentInfo` with a [`ContentUpdateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php)
that sets the new main Location:

``` php
$contentUpdateStruct = $this->contentService->newContentMetadataUpdateStruct();
$contentUpdateStruct->mainLocationId = $locationId;

$this->contentService->updateContentMetadata($contentInfo, $contentUpdateStruct);
```

### Hiding and revealing Locations

To hide or reveal (unhide) a Location you need to make use of
[`LocationService::hideLocation`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L174)
or [`LocationService::unhideLocation`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L188)

``` php
$hiddenLocation = $locationService->hideLocation($location);
$visibleLocation = $locationService->unhideLocation($location);
```

See [Location visibility](../guide/content_management/#location-visibility) for detailed information
on the behavior of visible and hidden Locations.

### Deleting a Location

You can remove a Location either by deleting it, or sending it to Trash.

Deleting makes use of [`LocationService::deleteLocation()`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L212)
It permanently deletes the Location, together with its whole subtree.

Content which has only this one Location will be permanently deleted as well.
Content which has more Locations will be still available in its other Locations.
If you delete the [main Location](#changing-the-main-location) of a Content item that has more Locations,
another Location will become the main one.

``` php
$this->locationService->deleteLocation($location);
```

To send the Location and its subtree to Trash,
use [`TrashService::trash`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/TrashService.php#L49)
Items in Trash can be later [restored, or deleted permanently](#trash).

``` php
$this->trashService->trash($location);
```

### Moving and copying a subtree

You can move a Location with its whole subtree using [`LocationService::moveSubtree`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L203)

``` php
$sourceLocation = $this->locationService->loadLocation($sourceLocationId);
$targetLocation = $this->locationService->loadLocation($targetLocationId);
$this->locationService->moveSubtree($sourceLocation, $targetLocation);
```

[`LocationService::copySubtree`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LocationService.php#L37) is used in the same way,
but it copies the Location and its subtree instead of moving it.

!!! tip

    To copy a subtree you can also make use of the built-in `copy-subtree` command:
    `bin/console ezplatform:copy-subtree <sourceLocationId> <targetLocationId>`.

!!! note

    [Copy subtree limit](../guide/config_back_office/#copy-subtree-limit) only applies to operations in the Back Office.
    It is ignored when copying subtrees using the PHP API.

## Trash

To empty the Trash (remove all Locations in Trash), use [`TrashService::emptyTrash`,](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/TrashService.php#L75)
which takes no arguments.

You can recover an item from Trash using [`TrashService::recover`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/TrashService.php#L63)
You must provide the method with the ID of the object in Trash.
Trash Location is identical to the origin Location of the object.

``` php
$this->trashService->recover($trashItem);
```

The Content item will be restored under its previous Location.
You can also provide a different Location to restore in as a second argument:

``` php
$newParent = $this->locationService->loadLocation($location);
$this->trashService->recover($trashItem, $newParent);
```

To sort Trash items by date, use [`TrashService::findTrashItems`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.2/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Trash/DateTrashed.php)

## Content Types

### Creating Content Types

To operate on Content Types, you need to make use of [`ContentTypeService`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentTypeService.php)

Creating a new Content Type, like creating content, must happen with the use of a struct, because a Content Type value object is read-only.
In this case you use [`ContentTypeCreateStruct`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/ContentType/ContentTypeCreateStruct.php)

A Content Type must have at least one name, in the main language, and at least one Field definition.

``` php
$contentTypeCreateStruct = $this->contentTypeService->newContentTypeCreateStruct($contentTypeIdentifier);
$contentTypeCreateStruct->mainLanguageCode = 'eng-GB';
$contentTypeCreateStruct->nameSchema = '<title>';

$contentTypeCreateStruct->names = [
    'eng-GB' => $contentTypeIdentifier,
];

$titleFieldCreateStruct = $this->contentTypeService->newFieldDefinitionCreateStruct('title', 'ezstring');
$titleFieldCreateStruct->names = ['eng-GB' => 'Title'];
$contentTypeCreateStruct->addFieldDefinition($titleFieldCreateStruct);

try {
    $contentTypeDraft = $this->contentTypeService->createContentType(
        $contentTypeCreateStruct,
        [$contentTypeGroup]
    );
    $this->contentTypeService->publishContentTypeDraft($contentTypeDraft);
    $output->writeln("Content type '$contentTypeIdentifier' with ID $contentTypeDraft->id created");
} catch //...
```

You can specify more details of the Field definition in the create struct, for example:

``` php
$titleFieldCreateStruct = $this->contentTypeService->newFieldDefinitionCreateStruct('title', 'ezstring');
$titleFieldCreateStruct->names = ['eng-GB' => 'Title'];
$titleFieldCreateStruct->descriptions = ['eng-GB' => 'The Title'];
$titleFieldCreateStruct->fieldGroup = 'content';
$titleFieldCreateStruct->position = 10;
$titleFieldCreateStruct->isTranslatable = true;
$titleFieldCreateStruct->isRequired = true;
$titleFieldCreateStruct->isSearchable = true;
$contentTypeCreateStruct->addFieldDefinition($titleFieldCreateStruct);
```

### Copying Content Types

To copy a Content Type, use [`ContentTypeService::copyContentType`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ContentTypeService.php#L241)

``` php
$copy = $this->contentTypeService->copyContentType($contentType);
```

The copy will automatically be given an identifier based on the original Content Type identifier
and the copy's ID, for example: `copy_of_folder_21`.

To change the identifier of the copy, use a [`ContentTypeUpdateStruct`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/ContentType/ContentTypeUpdateStruct.php)

``` php
$copyDraft = $this->contentTypeService->createContentTypeDraft($copiedContentType);
$copyUpdateStruct = $this->contentTypeService->newContentTypeUpdateStruct();
$copyUpdateStruct->identifier = $newIdentifier;
$this->contentTypeService->updateContentTypeDraft($copyDraft, $copyUpdateStruct);
$this->contentTypeService->publishContentTypeDraft($copyDraft);
```
