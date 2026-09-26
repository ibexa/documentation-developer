# Location events

Events that are triggered when working with content Locations.

| Event                       | Dispatched by                     | Properties                                                                                     |
| --------------------------- | --------------------------------- | ---------------------------------------------------------------------------------------------- |
| `BeforeCreateLocationEvent` | `LocationService::createLocation` | `ContentInfo $contentInfo` `LocationCreateStruct $locationCreateStruct` `?Location $location`  |
| `CreateLocationEvent`       | `LocationService::createLocation` | `Location $location` `ContentInfo $contentInfo` `LocationCreateStruct $locationCreateStruct`   |
| `BeforeUpdateLocationEvent` | `LocationService::updateLocation` | `Location $location` `LocationUpdateStruct $locationUpdateStruct` `?Location $updatedLocation` |
| `UpdateLocationEvent`       | `LocationService::updateLocation` | `Location $updatedLocation` `Location $location` `LocationUpdateStruct $locationUpdateStruct`  |
| `BeforeDeleteLocationEvent` | `LocationService::deleteLocation` | `Location $location`                                                                           |
| `DeleteLocationEvent`       | `LocationService::deleteLocation` | `Location $location`                                                                           |

## Hiding and revealing

| Event                       | Dispatched by                     | Properties                                         |
| --------------------------- | --------------------------------- | -------------------------------------------------- |
| `BeforeHideLocationEvent`   | `LocationService::hideLocation`   | `Location $location` `?Location $hiddenLocation`   |
| `HideLocationEvent`         | `LocationService::hideLocation`   | `Location $hiddenLocation` `Location $location`    |
| `BeforeUnhideLocationEvent` | `LocationService::unhideLocation` | `Location $location` `?Location $revealedLocation` |
| `UnhideLocationEvent`       | `LocationService::unhideLocation` | `Location $revealedLocation` `Location $location`  |

## Subtree and Location management

| Event                     | Dispatched by                   | Properties                                                                 |
| ------------------------- | ------------------------------- | -------------------------------------------------------------------------- |
| `BeforeCopySubtreeEvent`  | `LocationService::copySubtree`  | `Location $subtree` `Location $targetParentLocation` `?Location $location` |
| `CopySubtreeEvent`        | `LocationService::copySubtree`  | `Location $location` `Location $subtree` `Location $targetParentLocation`  |
| `BeforeMoveSubtreeEvent`  | `LocationService::moveSubtree`  | `Location $location` `Location $newParentLocation`                         |
| `MoveSubtreeEvent`        | `LocationService::moveSubtree`  | `Location $location` `Location $newParentLocation`                         |
| `BeforeSwapLocationEvent` | `LocationService::swapLocation` | `Location $location1` `Location $location2`                                |
| `SwapLocationEvent`       | `LocationService::swapLocation` | `Location $location1` `Location $location2`                                |
