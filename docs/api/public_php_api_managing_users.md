# Managing Users

!!! enterprise

    ## Segments

    Segments enable you to profile the content displayed to specific users.

    To manage segments, use the `SegmentationService`.

    ### Getting segment information

    To load a segment group, use `SegmentationService::loadSegmentGroup()`.
    Get all segments assigned to the group with `SegmentationService::loadSegmentsAssignedToGroup()`:

    ``` php
    $segmentGroup = $this->segmentationService->loadSegmentGroup(1);

    $segments = $this->segmentationService->loadSegmentsAssignedToGroup($segmentGroup);

    foreach ($segments as $segment) {
        $output->writeln($segment->name);
    }
    ```

    Similarly, you can load a segment in a group using `SegmentationService::loadSegmentGroup()`:

    ``` php
    $segment = $this->segmentationService->loadSegment(12);
    ```

    ### Checking assignation

    You can check whether a User is assigned to a segment with `SegmentationService::isUserAssignedToSegment()`:

    ``` php
    $user = $this->userService->loadUserByLogin('admin');
    $segment = $this->segmentationService->loadSegment(12);

    $isAssigned = $this->segmentationService->isUserAssignedToSegment($user, $segment);
    ```

    ### Assigning Users

    To assign a User to a segment, use `SegmentationService::assignUserToSegment()`:

    ``` php
    $user = $this->userService->loadUserByLogin('admin');
    $segment = $this->segmentationService->loadSegment(12);

    $this->segmentationService->assignUserToSegment($user, $segment);
    ```

    ### Creating segments

    Each segment must be assigned to a segment group.

    To create a segment group, use `SegmentationService::createSegmentGroup()`
    and provide it with a SegmentGroupCreateStruct:

    ``` php
    $segmentGroupCreateStruct = new SegmentGroupCreateStruct([
        'name' => 'Custom Group',
        'identifier' => 'custom_group',
    ]);

    $newSegmentGroup = $this->segmentationService->createSegmentGroup($segmentGroupCreateStruct);
    ```

    To create a segment, use `SegmentationService::createSegment()`
    and provide it a SegmentCreateStruct, which takes the group as one of the parameters:

    ``` php
    $segmentCreateStruct = new SegmentCreateStruct([
        'name' => 'Segment 1',
        'identifier' => 'segment_1',
        'group' => $newSegmentGroup,
    ]);

    $newSegment = $this->segmentationService->createSegment($segmentCreateStruct);
    ```

    ### Updating segments

    To update a segment or a segment group, use `SegmentationService::updateSegment()`
    or `SegmentationService::updateSegmentGroup()` and provide it with `SegmentUpdateStruct`
    or `SegmentGroupUpdateStruct` respectively.

    ### Deleting segments

    To delete a segment or a segment group, use `SegmentationService::removeSegment()`
    or `SegmentationService::removeSegmentGroup()` respectively:

    ``` php
    $this->segmentationService->removeSegmentGroup($group);
    ```
