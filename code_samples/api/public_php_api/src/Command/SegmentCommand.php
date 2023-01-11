<?php

namespace App\Command;

use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Ibexa\Platform\Segmentation\Value\SegmentCreateStruct;
use Ibexa\Platform\Segmentation\Value\SegmentGroupCreateStruct;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ibexa\Platform\Segmentation\Service\SegmentationService;

class SegmentCommand extends Command
{
    private $segmentationService;

    private $userService;

    private $permissionResolver;

    public function __construct(SegmentationService $segmentationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->segmentationService = $segmentationService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        parent::__construct('doc:segment');
    }

    protected function configure()
    {}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $segmentGroupCreateStruct = new SegmentGroupCreateStruct([
            'name' => 'Custom Group',
            'identifier' => 'custom_group',
            'createSegments' => []
        ]);

        $newSegmentGroup = $this->segmentationService->createSegmentGroup($segmentGroupCreateStruct);

        $segmentCreateStruct = new SegmentCreateStruct([
            'name' => 'Segment 1',
            'identifier' => 'segment_1',
            'group' => $newSegmentGroup,
        ]);

        $newSegment = $this->segmentationService->createSegment($segmentCreateStruct);

        $segmentGroup = $this->segmentationService->loadSegmentGroup(1);

        $segments = $this->segmentationService->loadSegmentsAssignedToGroup($segmentGroup);

        foreach ($segments as $segment) {
            $output->writeln('Segment ID: ' . $segment->id . ', name: ' . $segment->name);
        }

        $segment = $this->segmentationService->loadSegment(1);

        $this->segmentationService->assignUserToSegment($user, $segment);

        $output->writeln(($this->segmentationService->isUserAssignedToSegment($user, $segment)
            ? "The user is assigned to the segment."
            : "The user is not assigned to the segment."
        ));

        return self::SUCCESS;
    }
}
