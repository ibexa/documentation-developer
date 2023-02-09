---
description: PHP API enables managing content Locations, Content Types, as well as content in Trash and Calendar events.
---

# Managing content

## Locations

You can manage [Locations](locations.md) that hold content
using [`LocationService`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php)

!!! tip "Location REST API"

    To learn how to manage Locations using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-new-location-for-content-item).

### Adding a new Location to a Content item

Every published Content item must have at least one Location.
One Content item can have more that one Location, which means it is presented in more than one place
in the content tree.

Creating a new Location, like creating content, requires using a struct,
because a Location value object is read-only.

To add a new Location to existing content you need to create
a [`LocationCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LocationCreateStruct.php)
and pass it to the [`LocationService::createLocation`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L141) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 51, 52) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 56, 58) =]]
```

`LocationCreateStruct` must receive the parent Location ID.
It sets the `parentLocationId` property of the new Location.

You can also provide other properties for the Location, otherwise they will be set to their defaults:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 53, 55) =]]
```

### Changing the main Location

When a Content item has more that one Location, one Location is always considered the main one.
You can change the main Location using [`ContentService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php),
by updating the `ContentInfo` with a [`ContentUpdateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php)
that sets the new main Location:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SetMainLocationCommand.php', 48, 52) =]]
```

### Hiding and revealing Locations

To hide or reveal (unhide) a Location you need to make use of
[`LocationService::hideLocation`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L175)
or [`LocationService::unhideLocation`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L189)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/HideLocationCommand.php', 46, 47) =]][[= include_file('code_samples/api/public_php_api/src/Command/HideLocationCommand.php', 49, 50) =]]
```

See [Location visibility](#location-visibility) for detailed information
on the behavior of visible and hidden Locations.

### Deleting a Location

You can remove a Location either by deleting it, or sending it to Trash.

Deleting makes use of [`LocationService::deleteLocation()`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L215)
It permanently deletes the Location, together with its whole subtree.

Content which has only this one Location will be permanently deleted as well.
Content which has more Locations will be still available in its other Locations.
If you delete the [main Location](#changing-the-main-location) of a Content item that has more Locations,
another Location will become the main one.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/DeleteContentCommand.php', 45, 46) =]]
```

To send the Location and its subtree to Trash,
use [`TrashService::trash`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/TrashService.php#L49)
Items in Trash can be later [restored, or deleted permanently](#trash).

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TrashContentCommand.php', 54, 55) =]]
```

### Moving and copying a subtree

You can move a Location with its whole subtree using [`LocationService::moveSubtree`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L206)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/MoveContentCommand.php', 47, 50) =]]
```

[`LocationService::copySubtree`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L38) is used in the same way,
but it copies the Location and its subtree instead of moving it.

!!! tip

    To copy a subtree you can also make use of the built-in `copy-subtree` command:
    `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

!!! note

    [Copy subtree limit](#copy-subtree-limit) only applies to operations in the Back Office.
    It is ignored when copying subtrees using the PHP API.

## Trash

!!! tip "Trash REST API"

    To learn how to manage Trash using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-list-trash-items).

To empty the Trash (remove all Locations in Trash), use [`TrashService::emptyTrash`,](https://github.com/ibexa/core/blob/main/src/contracts/Repository/TrashService.php#L75)
which takes no arguments.

You can recover an item from Trash using [`TrashService::recover`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/TrashService.php#L63)
You must provide the method with the ID of the object in Trash.
Trash Location is identical to the origin Location of the object.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TrashContentCommand.php', 64, 65) =]]
```

The Content item will be restored under its previous Location.
You can also provide a different Location to restore in as a second argument:

``` php
$newParent = $this->locationService->loadLocation($location);
$this->trashService->recover($trashItem, $newParent);
```

You can also search through Trash items and sort the results using several public PHP API search criteria and sort clauses that have been exposed for `TrashService` queries.
For more information, see [Searching in trash](search_api.md#searching-in-trash).

## Content Types

!!! tip "Content Type REST API"

    To learn how to manage Content Types using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-content-type-groups).

### Adding Content Types

To operate on Content Types, you need to make use of [`ContentTypeService`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentTypeService.php)

Adding a new Content Type, like creating content, must happen with the use of a struct, because a Content Type value object is read-only.
In this case you use [`ContentTypeCreateStruct`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/ContentType/ContentTypeCreateStruct.php)

A Content Type must have at least one name, in the main language, and at least one Field definition.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 58, 68) =]][[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 75, 84) =]]
```

You can specify more details of the Field definition in the create struct, for example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 66, 76) =]]
```

### Copying Content Types

To copy a Content Type, use [`ContentTypeService::copyContentType`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentTypeService.php#L241)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 89, 90) =]]
```

The copy will automatically be given an identifier based on the original Content Type identifier
and the copy's ID, for example: `copy_of_folder_21`.

To change the identifier of the copy, use a [`ContentTypeUpdateStruct`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/ContentType/ContentTypeUpdateStruct.php)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 90, 96) =]]
```

## Calendar events

You can handle the calendar using `CalendarServiceInterface` (`Ibexa\Contracts\Calendar\CalendarServiceInterface`).

!!! tip "Calendar REST API"

    To learn how to manage the Calendar using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#calendar).

### Getting events

To get a list of events for a specified time period, use the `CalendarServiceInterface::getEvents` method.
You need to provide the method with an EventQuery, which takes a date range and a count as the minimum of parameters:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 39, 50) =]]
```

You can also get the first and last event in the list by using the `first()` and `last()` methods of an `EventCollection` (`Ibexa\Contracts\Calendar\EventCollection`) respectively:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 51, 53) =]]
```

You can process the events in a collection using the `find(Closure $predicate)`, `filter(Closure $predicate)`,
`map(Closure $callback)` or `slice(int $offset, ?int $length = null)` methods of `EventCollection`, for example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 54, 57) =]]
```

### Performing calendar actions

You can perform a calendar action (e.g. reschedule or unschedule calendar events) using the `CalendarServiceInterface::executeAction()` method.
You must pass an `Ibexa\Contracts\Calendar\EventAction\EventActionContext` instance as argument.
`EventActionContext` defines events on which the action is performed, as well as action-specific parameters e.g. a new date:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 59, 61) =]]
```

``` php
$context = new UnscheduleEventActionContext($eventCollection);
```
