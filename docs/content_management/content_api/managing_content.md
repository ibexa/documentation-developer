---
description: PHP API enables managing content Locations, content types, content in Trash, and Calendar events.
---

# Managing content

## Locations

You can manage [locations](locations.md) that hold content using [`LocationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html).

!!! tip "Location REST API"

    To learn how to manage locations using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-new-location-for-content-item).

### Adding a new location to a content item

Every published content item must have at least one location.
One content item can have more that one location, which means it's presented in more than one place in the content tree.

Creating a new location, like creating content, requires using a struct, because a location value object is read-only.

To add a new location to existing content you need to create a [`LocationCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LocationCreateStruct.html) and pass it to the [`LocationService::createLocation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_createLocation) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 55, 56) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 60, 62) =]]
```

`LocationCreateStruct` must receive the parent location ID.
It sets the `parentLocationId` property of the new location.

You can also provide other properties for the location, otherwise they're set to their defaults:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLocationToContentCommand.php', 57, 59) =]]
```

### Changing the main location

When a content item has more that one location, one location is always considered the main one.
You can change the main location using [`ContentService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html), by updating the `ContentInfo` with a [`ContentUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentUpdateStruct.html) that sets the new main location:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SetMainLocationCommand.php', 53, 57) =]]
```

### Hiding and revealing locations

To hide or reveal (unhide) a location you need to make use of [`LocationService::hideLocation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_hideLocation) or [`LocationService::unhideLocation`:](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_unhideLocation)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/HideLocationCommand.php', 51, 52) =]][[= include_file('code_samples/api/public_php_api/src/Command/HideLocationCommand.php', 54, 55) =]]
```

See [location visibility](locations.md#location-visibility) for detailed information on the behavior of visible and hidden Locations.

### Deleting a location

You can remove a location either by deleting it, or sending it to Trash.

Deleting makes use of [`LocationService::deleteLocation()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_deleteLocation).
It permanently deletes the location, together with its whole subtree.

Content which has only this one location is permanently deleted as well.
Content which has more locations is still available in its other locations.
If you delete the [main location](#changing-the-main-location) of a content item that has more locations, another location becomes the main one.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/DeleteContentCommand.php', 49, 50) =]]
```

To send the location and its subtree to Trash, use [`TrashService::trash`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#).
Items in Trash can be later [restored, or deleted permanently](#trash).

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TrashContentCommand.php', 59, 60) =]]
```

### Moving and copying a subtree

You can move a location with its whole subtree using [`LocationService::moveSubtree`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_moveSubtree):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/MoveContentCommand.php', 51, 54) =]]
```

[`LocationService::copySubtree`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_copySubtree) is used in the same way, but it copies the location and its subtree instead of moving it.

!!! tip

    To copy a subtree you can also make use of the built-in `copy-subtree` command: `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

!!! note

    [Copy subtree limit](back_office_configuration.md#copy-subtree-limit) only applies to operations in the back office.
    It's ignored when copying subtrees using the PHP API.

## Trash

!!! tip "Trash REST API"

    To learn how to manage Trash using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-list-trash-items).

To empty the Trash (remove all locations in Trash), use [`TrashService::emptyTrash`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#method_emptyTrash), which takes no arguments.

You can recover an item from Trash using [`TrashService::recover`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#method_recover).
You must provide the method with the ID of the object in Trash.
Trash location is identical to the origin location of the object.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TrashContentCommand.php', 69, 70) =]]
```

The content item is restored under its previous location.
You can also provide a different location to restore in as a second argument:

``` php
$newParent = $this->locationService->loadLocation($location);
$this->trashService->recover($trashItem, $newParent);
```

You can also search through Trash items and sort the results using several public PHP API Search Criteria and Sort Clauses that have been exposed for `TrashService` queries.
For more information, see [Searching in trash](search_api.md#searching-in-trash).

## Content types

!!! tip "Content type REST API"

    To learn how to manage content types using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-content-type-groups).

### Adding content types

To operate on content types, you need to make use of [`ContentTypeService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentTypeService.html).

Adding a new content type, like creating content, must happen with the use of a struct, because a content type value object is read-only.
In this case you use [`ContentTypeCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-ContentTypeCreateStruct.html).

A content type must have at least one name, in the main language, and at least one field definition.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 64, 74) =]][[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 81, 90) =]]
```

You can specify more details of the field definition in the create struct, for example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 72, 82) =]]
```

### Copying content types

To copy a content type, use [`ContentTypeService::copyContentType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentTypeService.html#method_copyContentType):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 94, 95) =]]
```

The copy is automatically getting an identifier based on the original content type identifier and the copy's ID, for example: `copy_of_folder_21`.

To change the identifier of the copy, use a [`ContentTypeUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-ContentTypeUpdateStruct.html):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentTypeCommand.php', 95, 101) =]]
```

## Calendar events

You can handle the calendar using `CalendarServiceInterface` (`Ibexa\Contracts\Calendar\CalendarServiceInterface`).

!!! tip "Calendar REST API"

    To learn how to manage the Calendar using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#calendar).

### Getting events

To get a list of events for a specified time period, use the `CalendarServiceInterface::getEvents` method.
You need to provide the method with an EventQuery, which takes a date range and a count as the minimum of parameters:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 44, 55) =]]
```

You can also get the first and last event in the list by using the `first()` and `last()` methods of an `EventCollection` (`Ibexa\Contracts\Calendar\EventCollection`):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 56, 58) =]]
```

You can process the events in a collection using the `find(Closure $predicate)`, `filter(Closure $predicate)`, `map(Closure $callback)` or `slice(int $offset, ?int $length = null)` methods of `EventCollection`, for example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 59, 62) =]]
```

### Performing calendar actions

You can perform a calendar action (for example, reschedule or unschedule calendar events) using the `CalendarServiceInterface::executeAction()` method.
You must pass an `Ibexa\Contracts\Calendar\EventAction\EventActionContext` instance as argument.
`EventActionContext` defines events on which the action is performed, and action-specific parameters, for example, a new date:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CalendarCommand.php', 64, 66) =]]
```

``` php
$context = new UnscheduleEventActionContext($eventCollection);
```
