# Managing Users [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

## Segments

Segments enable you to profile the content displayed to specific users.

To manage Segments, use the `SegmentationService`.

### Getting Segment information

To load a Segment Group, use `SegmentationService::loadSegmentGroup()`.
Get all Segments assigned to the group with `SegmentationService::loadSegmentsAssignedToGroup()`:

``` php
$segmentGroup = $this->segmentationService->loadSegmentGroup(1);

$segments = $this->segmentationService->loadSegmentsAssignedToGroup($segmentGroup);

foreach ($segments as $segment) {
    $output->writeln($segment->name);
}
```

Similarly, you can load a Segment in a group by using `SegmentationService::loadSegmentGroup()`:

``` php
$segment = $this->segmentationService->loadSegment(12);
```

### Checking assignment

You can check whether a User is assigned to a Segment with `SegmentationService::isUserAssignedToSegment()`:

``` php
$user = $this->userService->loadUserByLogin('admin');
$segment = $this->segmentationService->loadSegment(12);

$isAssigned = $this->segmentationService->isUserAssignedToSegment($user, $segment);
```

### Assigning Users

To assign a User to a Segment, use `SegmentationService::assignUserToSegment()`:

``` php
$user = $this->userService->loadUserByLogin('admin');
$segment = $this->segmentationService->loadSegment(12);

$this->segmentationService->assignUserToSegment($user, $segment);
```

### Creating Segments

Each Segment must be assigned to a Segment Group.

To create a Segment Group, use `SegmentationService::createSegmentGroup()`
and provide it with a `SegmentGroupCreateStruct`:

``` php
$segmentGroupCreateStruct = new SegmentGroupCreateStruct([
    'name' => 'Custom Group',
    'identifier' => 'custom_group',
    'createSegments' => []
]);

$newSegmentGroup = $this->segmentationService->createSegmentGroup($segmentGroupCreateStruct);
```

To create a Segment, use `SegmentationService::createSegment()`
and provide it with a `SegmentCreateStruct`, which takes an existing group as one of the parameters:

``` php
$segmentCreateStruct = new SegmentCreateStruct([
    'name' => 'Segment 1',
    'identifier' => 'segment_1',
    'group' => $segmentGroup,
]);

$newSegment = $this->segmentationService->createSegment($segmentCreateStruct);
```

### Updating Segments

To update a Segment or a Segment Group, use `SegmentationService::updateSegment()`
or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct`
or `SegmentGroupUpdateStruct`, respectively.

### Deleting Segments

To delete a Segment or a Segment Group, use `SegmentationService::removeSegment()`
or `SegmentationService::removeSegmentGroup()`, respectively:

``` php
$this->segmentationService->removeSegmentGroup($group);
```
