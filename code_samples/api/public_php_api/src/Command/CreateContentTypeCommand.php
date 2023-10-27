<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateContentTypeCommand extends Command
{
    private $contentTypeService;

    private $userService;

    private $permissionResolver;

    public function __construct(ContentTypeService $contentTypeService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentTypeService = $contentTypeService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:create_content_type');
    }

    protected function configure()
    {
        $this->setDefinition([
            new InputArgument('identifier', InputArgument::REQUIRED, 'Content Type identifier'),
            new InputArgument('group_identifier', InputArgument::REQUIRED, 'Content Type group identifier'),
            new InputArgument('copy_identifier', InputArgument::OPTIONAL, 'Identifier of the CT copy'),
        ])
            ->addOption('copy', 'c', InputOption::VALUE_NONE, 'Do you want to make a copy the Content Type?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $groupIdentifier = $input->getArgument('group_identifier');
        $contentTypeIdentifier = $input->getArgument('identifier');
        if ($input->getArgument('copy_identifier')) {
            $copyIdentifier = $input->getArgument('copy_identifier');
        }

        try {
            $contentTypeGroup = $this->contentTypeService->loadContentTypeGroupByIdentifier($groupIdentifier);
        } catch (\eZ\Publish\API\Repository\Exceptions\NotFoundException $e) {
            $output->writeln("Content Type group with identifier $groupIdentifier not found");

            return self::FAILURE;
        }

        $contentTypeCreateStruct = $this->contentTypeService->newContentTypeCreateStruct($contentTypeIdentifier);
        $contentTypeCreateStruct->mainLanguageCode = 'eng-GB';
        $contentTypeCreateStruct->nameSchema = '<name>';

        $contentTypeCreateStruct->names = [
            'eng-GB' => $contentTypeIdentifier,
        ];

        $titleFieldCreateStruct = $this->contentTypeService->newFieldDefinitionCreateStruct('name', 'ezstring');
        $titleFieldCreateStruct->names = ['eng-GB' => 'Name'];
        $titleFieldCreateStruct->descriptions = ['eng-GB' => 'The name'];
        $titleFieldCreateStruct->fieldGroup = 'content';
        $titleFieldCreateStruct->position = 10;
        $titleFieldCreateStruct->isTranslatable = true;
        $titleFieldCreateStruct->isRequired = true;
        $titleFieldCreateStruct->isSearchable = true;

        $contentTypeCreateStruct->addFieldDefinition($titleFieldCreateStruct);

        $contentTypeDraft = $this->contentTypeService->createContentType(
            $contentTypeCreateStruct,
            [$contentTypeGroup]
        );

        $this->contentTypeService->publishContentTypeDraft($contentTypeDraft);
        $output->writeln("Content type '$contentTypeIdentifier' with ID $contentTypeDraft->id created");

        if ($input->getOption('copy')) {
            $contentTypeToCopy = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);

            $copy = $this->contentTypeService->copyContentType($contentTypeToCopy);
            $copyDraft = $this->contentTypeService->createContentTypeDraft($copy);
            $copyUpdateStruct = $this->contentTypeService->newContentTypeUpdateStruct();
            $copyUpdateStruct->identifier = $copyIdentifier;
            $copyUpdateStruct->names = ['eng-GB' => $copyIdentifier];
            $this->contentTypeService->updateContentTypeDraft($copyDraft, $copyUpdateStruct);
            $this->contentTypeService->publishContentTypeDraft($copyDraft);
            $output->writeln('Copy of the new CT created with identifier ' . $copyIdentifier);
        }

        return self::SUCCESS;
    }
}
