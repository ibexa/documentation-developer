---
description: You can use PHP API to get Segment information, create and manage Segments, and assign users to them.
edition: experience
---

# Segment API

Segments enable you to profile the content displayed to specific users.

To manage Segments, use the `SegmentationService`.

## Getting Segment information

To load a Segment Group, use `SegmentationService::loadSegmentGroupByIdentifier()`.
Get all Segments assigned to the group with `SegmentationService::loadSegmentsAssignedToGroup()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 53, 60) =]]
```

Similarly, you can load a Segment in a group by using `SegmentationService::loadSegmentIdentifier()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 61, 62) =]]
```

## Checking assignment

You can check whether a User is assigned to a Segment with `SegmentationService::isUserAssignedToSegment()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 65, 69) =]]
```

## Assigning Users

To assign a User to a Segment, use `SegmentationService::assignUserToSegment()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 61, 64) =]]
```

## Creating Segments

Each Segment must be assigned to a Segment Group.

To create a Segment Group, use `SegmentationService::createSegmentGroup()`
and provide it with a `SegmentGroupCreateStruct`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 37, 44) =]]
```

To add a Segment, use `SegmentationService::createSegment()`
and provide it with a `SegmentCreateStruct`, which takes an existing group as one of the parameters:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 45, 52) =]]
```

## Updating Segments

To update a Segment or a Segment Group, use `SegmentationService::updateSegment()`
or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct`
or `SegmentGroupUpdateStruct`, respectively.

## Deleting Segments

To delete a Segment or a Segment Group, use `SegmentationService::removeSegment()`
or `SegmentationService::removeSegmentGroup()`, respectively:

``` php
$this->segmentationService->removeSegmentGroup($group);
```
