# Segmentation events

Events that are triggered when working with segments.

Editions: Experience

| Event                           | Dispatched by                             | Properties                                                                                                       |
| ------------------------------- | ----------------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateSegmentGroupEvent` | `SegmentationService::createSegmentGroup` | `SegmentGroupCreateStruct $createStruct` `?SegmentGroup $segmentGroupResult = null`                              |
| `CreateSegmentGroupEvent`       | `SegmentationService::createSegmentGroup` | `SegmentGroupCreateStruct $createStruct` `SegmentGroup $segmentGroupResult`                                      |
| `BeforeUpdateSegmentGroupEvent` | `SegmentationService::updateSegmentGroup` | `SegmentGroup $segmentGroup` `SegmentGroupUpdateStruct $updateStruct` `?SegmentGroup $segmentGroupResult = null` |
| `UpdateSegmentGroupEvent`       | `SegmentationService::updateSegmentGroup` | `SegmentGroup $segmentGroup` `SegmentGroupUpdateStruct $updateStruct` `SegmentGroup $segmentGroupResult`         |
| `BeforeRemoveSegmentGroupEvent` | `SegmentationService::removeSegmentGroup` | `SegmentGroup $segmentGroup`                                                                                     |
| `RemoveSegmentGroupEvent`       | `SegmentationService::removeSegmentGroup` | `SegmentGroup $segmentGroup`                                                                                     |
| `BeforeCreateSegmentEvent`      | `SegmentationService::createSegment`      | `SegmentCreateStruct $createStruct` `?Segment $segmentResult = null`                                             |
| `CreateSegmentEvent`            | `SegmentationService::createSegment`      | `SegmentCreateStruct $createStruct` `Segment $segmentResult`                                                     |
| `BeforeUpdateSegmentEvent`      | `SegmentationService::updateSegment`      | `Segment $segment` `SegmentUpdateStruct $updateStruct` `?Segment $segmentResult = null`                          |
| `UpdateSegmentEvent`            | `SegmentationService::updateSegment`      | `Segment $segment` `SegmentUpdateStruct $updateStruct` `Segment $segmentResult`                                  |
| `BeforeRemoveSegmentEvent`      | `SegmentationService::removeSegment`      | `Segment $segment`                                                                                               |
| `RemoveSegmentEvent`            | `SegmentationService::removeSegment`      | `Segment $segment`                                                                                               |

## Assigning segments

| Event                                    | Dispatched by                                  | Properties                      |
| ---------------------------------------- | ---------------------------------------------- | ------------------------------- |
| `BeforeAssignUserToSegmentEvent.php`     | `SegmentationService::assignUserToSegment`     | `User $user` `Segment $segment` |
| `AssignUserToSegmentEvent.php`           | `SegmentationService::assignUserToSegment`     | `User $user` `Segment $segment` |
| `BeforeUnassignUserFromSegmentEvent.php` | `SegmentationService::unassignUserFromSegment` | `User $user` `Segment $segment` |
| `UnassignUserFromSegmentEvent.php`       | `SegmentationService::unassignUserFromSegment` | `User $user` `Segment $segment` |
