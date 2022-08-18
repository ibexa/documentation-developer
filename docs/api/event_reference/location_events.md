---
description: Events that are triggered when working with content Locations.
---

# Location events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateLocationEvent`|`LocationService::createLocation`|`ContentInfo $contentInfo`</br>`LocationCreateStruct $locationCreateStruct`</br>`Location|null $location`|
|`CreateLocationEvent`|`LocationService::createLocation`|`Location $location`</br>`ContentInfo $contentInfo`</br>`LocationCreateStruct $locationCreateStruct`|
|`BeforeUpdateLocationEvent`|`LocationService::updateLocation`|`Location $location`</br>`LocationUpdateStruct $locationUpdateStruct`</br>`Location|null $updatedLocation`|
|`UpdateLocationEvent`|`LocationService::updateLocation`|`Location $updatedLocation`</br>`Location $location`</br>`LocationUpdateStruct $locationUpdateStruct`|
|`BeforeDeleteLocationEvent`|`LocationService::deleteLocation`|`Location $location`|
|`DeleteLocationEvent`|`LocationService::deleteLocation`|`Location $location`|

## Hiding and revealing

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeHideLocationEvent`|`LocationService::hideLocation`|`Location $location`</br>`Location|null $hiddenLocation`|
|`HideLocationEvent`|`LocationService::hideLocation`|`Location $hiddenLocation`</br>`Location $location`|
|`BeforeUnhideLocationEvent`|`LocationService::unhideLocation`|`Location $location`</br>`Location|null $revealedLocation`|
|`UnhideLocationEvent`|`LocationService::unhideLocation`|`Location $revealedLocation`</br>`Location $location`|

## Subtree and Location management

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCopySubtreeEvent`|`LocationService::copySubtree`|`Location $subtree`</br>`Location $targetParentLocation`</br>`Location|null $location`|
|`CopySubtreeEvent`|`LocationService::copySubtree`|`Location $location`</br>`Location $subtree`</br>`Location $targetParentLocation`|
|`BeforeMoveSubtreeEvent`|`LocationService::moveSubtree`|`Location $location`</br>`Location $newParentLocation`|
|`MoveSubtreeEvent`|`LocationService::moveSubtree`|`Location $location`</br>`Location $newParentLocation`|
|`BeforeSwapLocationEvent`|`LocationService::swapLocation`|`Location $location1`</br>`Location $location2`|
|`SwapLocationEvent`|`LocationService::swapLocation`|`Location $location1`</br>`Location $location2`|
