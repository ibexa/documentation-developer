<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Segmentation\Service\SegmentationService;
use Ibexa\Segmentation\Value\SegmentCreateStruct;
use Ibexa\Segmentation\Value\SegmentGroupCreateStruct;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:segment'
)]
class SegmentCommand extends Command
{
    private SegmentationService $segmentationService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(SegmentationService $segmentationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->segmentationService = $segmentationService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $segmentGroupCreateStruct = new SegmentGroupCreateStruct([
            'name' => 'Custom Group',
            'identifier' => 'custom_group',
            'createSegments' => [],
        ]);

        $newSegmentGroup = $this->segmentationService->createSegmentGroup($segmentGroupCreateStruct);

        $segmentCreateStruct = new SegmentCreateStruct([
            'name' => 'Segment 1',
            'identifier' => 'segment_1',
            'group' => $newSegmentGroup,
        ]);

        $newSegment = $this->segmentationService->createSegment($segmentCreateStruct);

        $segmentGroup = $this->segmentationService->loadSegmentGroupByIdentifier('custom_group');

        $segments = $this->segmentationService->loadSegmentsAssignedToGroup($segmentGroup);

        foreach ($segments as $segment) {
            $output->writeln('Segment ID: ' . $segment->id . ', name: ' . $segment->name);
        }

        $segment = $this->segmentationService->loadSegmentByIdentifier('segment_1');

        $this->segmentationService->assignUserToSegment($user, $segment);

        $output->writeln((
            $this->segmentationService->isUserAssignedToSegment($user, $segment)
            ? 'The user is assigned to the segment.'
            : 'The user is not assigned to the segment.'
        ));

        return self::SUCCESS;
    }
}
