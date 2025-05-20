<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'doc:create_content'
)]
class CreateContentCommand extends Command
{
    private ContentService $contentService;

    private ContentTypeService $contentTypeService;

    private LocationService $locationService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(ContentService $contentService, ContentTypeService $contentTypeService, LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->contentTypeService = $contentTypeService;
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('parentLocationId', InputArgument::REQUIRED, 'Parent Location ID'),
                new InputArgument('contentType', InputArgument::REQUIRED, 'Identifier of a content type with a Name and Description Field'),
                new InputArgument('name', InputArgument::REQUIRED, 'Content for the Name field'),
            ])
            ->addOption('publish', 'p', InputOption::VALUE_NONE, 'Do you want to publish the content item?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $parentLocationId = (int) $input->getArgument('parentLocationId');
        $contentTypeIdentifier = $input->getArgument('contentType');
        $name = $input->getArgument('name');

        $contentType = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);
        $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
        $contentCreateStruct->setField('name', $name);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

        $output->writeln('Created a draft of ' . $contentType->getName() . ' with name ' . $draft->getName());

        if ($input->getOption('publish')) {
            $content = $this->contentService->publishVersion($draft->versionInfo);
            $output->writeln('Published content item ' . $content->getName());
        }

        return self::SUCCESS;
    }
}
