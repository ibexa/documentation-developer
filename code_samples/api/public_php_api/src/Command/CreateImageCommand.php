<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\FieldType\Image\Value;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateImageCommand extends Command
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
        parent::__construct('doc:create_image');
    }

    protected function configure()
    {
        $this
            ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'Content for the Name field'),
                new InputArgument('file', InputArgument::REQUIRED, 'Content for the Image field'),
            ])
            ->addOption('publish', 'p', InputOption::VALUE_NONE, 'Do you want to publish the Content item?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $name = $input->getArgument('name');
        $file = $input->getArgument('file');
        $publish = $input->getOption('publish');

        $contentType = $this->contentTypeService->loadContentTypeByIdentifier('image');
        $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
        $contentCreateStruct->setField('name', $name);
        $imageValue = new Value(
            [
                'path' => $file,
                'fileSize' => filesize($file),
                'fileName' => basename($file),
                'alternativeText' => $name,
            ]
        );
        $contentCreateStruct->setField('image', $imageValue);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct(51);

        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

        $output->writeln('Created a draft of ' . $contentType->getName() . ' with name ' . $draft->getName());

        if ($publish == true) {
            $content = $this->contentService->publishVersion($draft->versionInfo);
            $output->writeln('Published Content item ' . $content->getName());
        }

        return self::SUCCESS;
    }
}
