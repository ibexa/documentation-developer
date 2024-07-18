---
description: Events that are triggered when working with Segments.
page_type: reference
---

# Segmentation events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateSegmentGroupEvent`|`SegmentationService::createSegmentGroup`|`SegmentGroupCreateStruct $createStruct`</br>`?SegmentGroup $segmentGroupResult = null`|
|`CreateSegmentGroupEvent`|`SegmentationService::createSegmentGroup`|`SegmentGroupCreateStruct $createStruct`</br>`SegmentGroup $segmentGroupResult`|
|`BeforeUpdateSegmentGroupEvent`|`SegmentationService::updateSegmentGroup`|`SegmentGroup $segmentGroup`</br>`SegmentGroupUpdateStruct $updateStruct`</br>`?SegmentGroup $segmentGroupResult = null`|
|`UpdateSegmentGroupEvent`|`SegmentationService::updateSegmentGroup`|`SegmentGroup $segmentGroup`</br>`SegmentGroupUpdateStruct $updateStruct`</br>`SegmentGroup $segmentGroupResult`|
|`BeforeRemoveSegmentGroupEvent`|`SegmentationService::removeSegmentGroup`|`SegmentGroup $segmentGroup`|
|`RemoveSegmentGroupEvent`|`SegmentationService::removeSegmentGroup`|`SegmentGroup $segmentGroup`|
|`BeforeCreateSegmentEvent`|`SegmentationService::createSegment`|`SegmentCreateStruct $createStruct`</br>`?Segment $segmentResult = null`|
|`CreateSegmentEvent`|`SegmentationService::createSegment`|`SegmentCreateStruct $createStruct`</br>`Segment $segmentResult`|
|`BeforeUpdateSegmentEvent`|`SegmentationService::updateSegment`|`Segment $segment`</br>`SegmentUpdateStruct $updateStruct`</br>`?Segment $segmentResult = null`|
|`UpdateSegmentEvent`|`SegmentationService::updateSegment`|`Segment $segment`</br>`SegmentUpdateStruct $updateStruct`</br>`Segment $segmentResult`|
|`BeforeRemoveSegmentEvent`|`SegmentationService::removeSegment`|`Segment $segment`|
|`RemoveSegmentEvent`|`SegmentationService::removeSegment`|`Segment $segment`|

## Assigning segments

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignUserToSegmentEvent.php`|`SegmentationService::assignUserToSegment`|`User $user` </br> `Segment $segment`|
|`AssignUserToSegmentEvent.php`|`SegmentationService::assignUserToSegment`|`User $user` </br> `Segment $segment`|
|`BeforeUnassignUserFromSegmentEvent.php`|`SegmentationService::unassignUserFromSegment`|`User $user` </br> `Segment $segment`|
|`UnassignUserFromSegmentEvent.php`|`SegmentationService::unassignUserFromSegment`|`User $user` </br> `Segment $segment`|
