# Working with Locations

## Adding a new Location to a Content item

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/AddLocationToContentCommand.php>

You have seen earlier how you can create a Location for a newly created `Content`. It is of course also possible to add a new [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php) to an existing `Content`.

``` php
try
{
    $locationCreateStruct = $locationService->newLocationCreateStruct( $parentLocationId );
    $contentInfo = $contentService->loadContentInfo( $contentId );
    $newLocation = $locationService->createLocation( $contentInfo, $locationCreateStruct );
    print_r( $newLocation );
}
// Content or location not found
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( $e->getMessage() );
}
// Permission denied
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( $e->getMessage() );
}
```

This is the required code. As you can see, both the Content Service and the Location Service are involved. Errors are handled the usual way, by intercepting the Exceptions the used methods may throw.

``` php
$locationCreateStruct = $locationService->newLocationCreateStruct( $parentLocationId );
```

Like during creation of a new Content item, you need to get a new `LocationCreateStruct`. You will use it to set your new [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php)'s properties. The new Location's parent ID is provided as a parameter to `LocationService::newLocationCreateStruct`.

In this example, the default values for the various `LocationCreateStruct` properties are used. You could of course have set custom values, like setting the Location as hidden ($location-&gt;hidden = true), or changed the remoteId (`$location->remoteId = $myRemoteId`).

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

To add a Location to a Content item, you need to specify the Content, using a [`ContentInfo`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentInfo.html) object. Load one using `ContentService::loadContentInfo()`, using the Content ID as the argument.

``` php
$newLocation = $locationService->createLocation( $contentInfo, $locationCreateStruct );
```

Finally use `LocationService::createLocation()`, providing the `ContentInfo` obtained above, together with your `LocationCreateStruct`. The method returns the newly created Location value object.

## Hide/Unhide Location

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/HideLocationCommand.php>

As mentioned earlier a Location's visibility could be set while creating the Location, using the hidden property of the `LocationCreateStruct`. Changing a Location's visibility may have a large impact in the Repository: doing so will affect the Location's subtree visibility. For this reason, a `LocationUpdateStruct` doesn't let you toggle this property. You need to use the `LocationService` to do so.

``` php
$hiddenLocation = $locationService->hideLocation( $location );
$unhiddenLocation = $locationService->unhideLocation( $hiddenLocation );
```

There are two methods for this: `LocationService::hideLocation`, and `LocationService::unhideLocation()`. Both expect the `LocationInfo` as their argument, and return the modified Location value object.

The explanation above is valid for most Repository objects. Modification of properties that affect other parts of the system will require that you use a custom service method.

## Deleting a Location

Deleting Locations can be done in two ways: delete, or trash.

``` php
$locationService->deleteLocation( $locationInfo );
```

[`LocationService::deleteLocation()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_deleteLocation) will permanently delete the Location, as well as all its descendants. Content that has only one Location will be permanently deleted as well. Those with more than one won't be, as they are still referenced by at least one Location.

``` php
$trashService->trash( $locationInfo );
```

`TrashService::trash()` will send the Location as well as all its descendants to the trash, where they can be found and restored until the Trash is emptied. Content isn't affected at all, since it is still referenced by the trash items.

The `TrashService` can be used to list, restore and delete Locations that were previously sent to trash using [`TrashService::trash()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/TrashService.html#method_trash).

## Setting a content item's main Location

This is done using the `ContentService`, by updating the `ContentInfo` with a `ContentUpdateStruct` that sets the new main location:

``` php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentInfo = $contentService->loadContentInfo( $contentId );

$contentUpdateStruct = $contentService->newContentMetadataUpdateStruct();
$contentUpdateStruct->mainLocationId = 123;

$contentService->updateContentMetadata( $contentInfo, $contentUpdateStruct );
```
