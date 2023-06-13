<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewContentCommand extends Command
{
    private ContentService $contentService;

    private ContentTypeService $contentTypeService;

    private FieldTypeService $fieldTypeService;

    public function __construct(ContentService $contentService, ContentTypeService $contentTypeService, FieldTypeService $fieldTypeService)
    {
        $this->contentService = $contentService;
        $this->contentTypeService = $contentTypeService;
        $this->fieldTypeService = $fieldTypeService;
        parent::__construct('doc:view_content');
    }

    protected function configure()
    {
        $this
            ->setDescription('Output Field values on provided Content item.')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'Location ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentId = $input->getArgument('contentId');

        $content = $this->contentService->loadContent($contentId);
        $contentType = $this->contentTypeService->loadContentType($content->contentInfo->contentTypeId);

        foreach ($contentType->fieldDefinitions as $fieldDefinition) {
            $output->writeln('Field: ' . $fieldDefinition->identifier);
            $fieldType = $this->fieldTypeService->getFieldType($fieldDefinition->fieldTypeIdentifier);
            $field = $content->getFieldValue($fieldDefinition->identifier);
            $valueHash = $fieldType->toHash($field);
            $output->writeln('Value:');
            $output->writeln($valueHash);
        }

        return self::SUCCESS;
    }
}
