<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ObjectStateService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:object_state'
)]
class ObjectStateCommand extends Command
{
    private ContentService $contentService;

    private UserService $userService;

    private ObjectStateService $objectStateService;

    private PermissionResolver $permissionResolver;

    public function __construct(ContentService $contentService, UserService $userService, ObjectStateService $objectStateService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->userService = $userService;
        $this->objectStateService = $objectStateService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates OS group with provided States and assigned the Lock OS to provided content item')
            ->setDefinition([
                new InputArgument('objectStateGroupIdentifier', InputArgument::REQUIRED, 'Identifier of new OG group to create'),
                new InputArgument('objectStateIdentifier', InputArgument::REQUIRED, 'Identifier(s) of a new Object State'),
                new InputArgument('contentID', InputArgument::OPTIONAL, 'Content ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $objectStateGroup = $this->objectStateService->loadObjectStateGroupByIdentifier('ez_lock');
        $objectState = $this->objectStateService->loadObjectStateByIdentifier($objectStateGroup, 'locked');

        $output->writeln($objectStateGroup->getName());
        $output->writeln($objectState->getName());

        $objectStateGroupIdentifier = $input->getArgument('objectStateGroupIdentifier');
        $objectStateIdentifierList = explode(',', $input->getArgument('objectStateIdentifier'));

        $objectStateGroupStruct = $this->objectStateService->newObjectStateGroupCreateStruct($objectStateGroupIdentifier);
        $objectStateGroupStruct->defaultLanguageCode = 'eng-GB';
        $objectStateGroupStruct->names = ['eng-GB' => $objectStateGroupIdentifier];
        $newObjectStateGroup = $this->objectStateService->createObjectStateGroup($objectStateGroupStruct);

        foreach ($objectStateIdentifierList as $objectStateIdentifier) {
            $stateStruct = $this->objectStateService->newObjectStateCreateStruct($objectStateIdentifier);
            $stateStruct->defaultLanguageCode = 'eng-GB';
            $stateStruct->names = ['eng-GB' => $objectStateIdentifier];
            $this->objectStateService->createObjectState($newObjectStateGroup, $stateStruct);
        }

        $output->writeln('Created new Object state group ' . $newObjectStateGroup->identifier . ' with Object states:');
        foreach ($this->objectStateService->loadObjectStates($newObjectStateGroup) as $objectState) {
            $output->writeln('* ' . $objectState->getName());
        }

        if ($input->getArgument('contentID')) {
            $contentId = (int) $input->getArgument('contentID');
            $objectStateToAssign = $objectStateIdentifierList[0];
            $contentInfo = $this->contentService->loadContentInfo($contentId);
            $objectStateGroup = $this->objectStateService->loadObjectStateGroupByIdentifier($objectStateGroupIdentifier);
            $objectState = $this->objectStateService->loadObjectStateByIdentifier($objectStateGroup, $objectStateToAssign);

            $this->objectStateService->setContentState($contentInfo, $objectStateGroup, $objectState);
            $output->writeln('Content ' . $contentInfo->name . ' assigned state ' . $objectState->getName());
        }

        return self::SUCCESS;
    }
}
