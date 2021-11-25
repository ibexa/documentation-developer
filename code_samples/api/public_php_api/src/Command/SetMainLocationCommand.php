<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\UserService;
use eZ\Publish\API\Repository\PermissionResolver;

class SetMainLocationCommand extends Command
{
    private $contentService;

    private $userService;

    private $permissionResolver;

    public function __construct(ContentService $contentService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:set_main_location');
    }

    protected function configure()
    {
        $this
            ->setDescription('Set a Location as Content item\'s main')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'The Content ID'),
                new InputArgument('locationId', InputArgument::REQUIRED, 'One of the Locations of the Content')
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentId = $input->getArgument('contentId');
        $locationId = $input->getArgument('locationId');

        $contentInfo = $this->contentService->loadContentInfo($contentId);

        $contentUpdateStruct = $this->contentService->newContentMetadataUpdateStruct();
        $contentUpdateStruct->mainLocationId = $locationId;

        $this->contentService->updateContentMetadata($contentInfo, $contentUpdateStruct);

        $output->writeln('Location ' . $locationId . ' is now the main Location for ' . $contentInfo->name);

        return self::SUCCESS;
    }
}
