<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:view_content',
    description: 'Output Field values on provided content item.'
)]
class ViewContentCommand
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly ContentTypeService $contentTypeService,
        private readonly FieldTypeService $fieldTypeService
    ) {
    }

    public function __invoke(
        #[Argument(description: 'Content ID')] int $contentId,
        OutputInterface $output
    ): int {
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

        return Command::SUCCESS;
    }
}
