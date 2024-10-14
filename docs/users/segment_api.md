---
description: You can use PHP API to get segment information, create and manage segments, and assign users to them.
edition: experience
---

# Segment API

Segments enable you to profile the content displayed to specific users.

To manage segments, use the `SegmentationService`.

## Getting segment information

To load a segment group, use `SegmentationService::loadSegmentGroupByIdentifier()`.
Get all segments assigned to the group with `SegmentationService::loadSegmentsAssignedToGroup()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 54, 62) =]]
```

Similarly, you can load a segment by using `SegmentationService::loadSegmentByIdentifier()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 62, 63) =]]
```

## Checking assignment

You can check whether a user is assigned to a segment with `SegmentationService::isUserAssignedToSegment()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 66, 71) =]]
```

## Assigning users

To assign a user to a segment, use `SegmentationService::assignUserToSegment()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 64, 65) =]]
```

## Creating segments

Each segment must be assigned to a segment group.

To create a segment group, use `SegmentationService::createSegmentGroup()` and provide it with a `SegmentGroupCreateStruct`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 38, 45) =]]
```

To add a segment, use `SegmentationService::createSegment()` and provide it with a `SegmentCreateStruct`, which takes an existing group as one of the parameters:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 46, 53) =]]
```

## Updating segments

To update a segment or a segment group, use `SegmentationService::updateSegment()` or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct` or `SegmentGroupUpdateStruct`.

## Deleting segments

To delete a segment or a segment group, use `SegmentationService::removeSegment()` or `SegmentationService::removeSegmentGroup()`:

``` php
$this->segmentationService->removeSegmentGroup($group);
```
