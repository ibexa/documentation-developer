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
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 49, 55, remove_indent=True) =]]
```

Similarly, you can load a segment by using `SegmentationService::loadSegmentByIdentifier()`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 57, 57, remove_indent=True) =]]
```

The returned `Segment` includes [audience metadata](cdp_audience_metadata.md) synced from your CDP: the number of profiles in the audience, its description, tags, and the timestamp of the last update.
This metadata is read-only through the API, as it's kept up to date by the synchronization process rather than by manual updates.

## Checking assignment

You can check whether a user is assigned to a segment with `SegmentationService::isUserAssignedToSegment()`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 61, 65, remove_indent=True) =]]
```

## Assigning users

To assign a user to a segment, use `SegmentationService::assignUserToSegment()`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 59, 59, remove_indent=True) =]]
```

## Creating segments

Each segment must be assigned to a segment group.

To create a segment group, use `SegmentationService::createSegmentGroup()` and provide it with a `SegmentGroupCreateStruct`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 33, 39, remove_indent=True) =]]
```

To add a segment, use `SegmentationService::createSegment()` and provide it with a `SegmentCreateStruct`, which takes an existing group as one of the parameters:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 41, 47, remove_indent=True) =]]
```

## Updating segments

To update a segment or a segment group, use `SegmentationService::updateSegment()` or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct` or `SegmentGroupUpdateStruct`.

## Deleting segments

To delete a segment or a segment group, use `SegmentationService::removeSegment()` or `SegmentationService::removeSegmentGroup()`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/SegmentCommand.php', 67, 67, remove_indent=True) =]]
```
