<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Contracts\Migration\StepExecutor\AbstractStepExecutor;
use Ibexa\Core\FieldType\TextLine\Value;
use Ibexa\Migration\ValueObject\Step\StepInterface;

final class ReplaceNameStepExecutor extends AbstractStepExecutor
{
    private ContentService $contentService;

    public function __construct(
        ContentService $contentService
    ) {
        $this->contentService = $contentService;
    }

    protected function doHandle(StepInterface $step): void
    {
        assert($step instanceof ReplaceNameStep);

        $contentItems = $this->contentService->find(new Filter());

        foreach ($contentItems as $contentItem) {
            $struct = $this->contentService->newContentUpdateStruct();

            foreach ($contentItem->getFields() as $field) {
                if ($field->fieldTypeIdentifier !== 'ezstring') {
                    continue;
                }

                if ($field->fieldDefIdentifier === 'identifier') {
                    continue;
                }

                if (str_contains($field->value, 'Company Name')) {
                    $newValue = str_replace('Company Name', $step->getReplacement(), $field->value);
                    $struct->setField($field->fieldDefIdentifier, new Value($newValue));
                }
            }

            try {
                $content = $this->contentService->createContentDraft($contentItem->contentInfo);
                $content = $this->contentService->updateContent($content->getVersionInfo(), $struct);
                $this->contentService->publishVersion($content->getVersionInfo());
            } catch (\Throwable $e) {
                // Ignore
            }
        }
    }

    public function canHandle(StepInterface $step): bool
    {
        return $step instanceof ReplaceNameStep;
    }
}
