# Segment API

You can use PHP API to get segment information, create and manage segments, and assign users to them.

Editions: Experience

Segments enable you to profile the content displayed to specific users.

To manage segments, use the `SegmentationService`.

## Getting segment information

To load a segment group, use `SegmentationService::loadSegmentGroupByIdentifier()`. Get all segments assigned to the group with `SegmentationService::loadSegmentsAssignedToGroup()`:

```php
$segmentGroup = $this->segmentationService->loadSegmentGroupByIdentifier('custom_group');

$segments = $this->segmentationService->loadSegmentsAssignedToGroup($segmentGroup);

foreach ($segments as $segment) {
    $output->writeln('Segment identifier: ' . $segment->getIdentifier() . ', name: ' . $segment->getName());
}
```

Similarly, you can load a segment by using `SegmentationService::loadSegmentByIdentifier()`:

```php
$segment = $this->segmentationService->loadSegmentByIdentifier('segment_1');
```

## Checking assignment

You can check whether a user is assigned to a segment with `SegmentationService::isUserAssignedToSegment()`:

```php
$output->writeln((
    $this->segmentationService->isUserAssignedToSegment($user, $segment)
    ? 'The user is assigned to the segment.'
    : 'The user is not assigned to the segment.'
));
```

## Assigning users

To assign a user to a segment, use `SegmentationService::assignUserToSegment()`:

```php
$this->segmentationService->assignUserToSegment($user, $segment);
```

## Creating segments

Each segment must be assigned to a segment group.

To create a segment group, use `SegmentationService::createSegmentGroup()` and provide it with a `SegmentGroupCreateStruct`:

```php
$segmentGroupCreateStruct = new SegmentGroupCreateStruct([
    'name' => 'Custom Group',
    'identifier' => 'custom_group',
    'createSegments' => [],
]);

$newSegmentGroup = $this->segmentationService->createSegmentGroup($segmentGroupCreateStruct);
```

To add a segment, use `SegmentationService::createSegment()` and provide it with a `SegmentCreateStruct`, which takes an existing group as one of the parameters:

```php
$segmentCreateStruct = new SegmentCreateStruct([
    'name' => 'Segment 1',
    'identifier' => 'segment_1',
    'group' => $newSegmentGroup,
]);

$newSegment = $this->segmentationService->createSegment($segmentCreateStruct);
```

## Updating segments

To update a segment or a segment group, use `SegmentationService::updateSegment()` or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct` or `SegmentGroupUpdateStruct`.

## Deleting segments

To delete a segment or a segment group, use `SegmentationService::removeSegment()` or `SegmentationService::removeSegmentGroup()`:

```php
$this->segmentationService->removeSegmentGroup($segmentGroup);
```
