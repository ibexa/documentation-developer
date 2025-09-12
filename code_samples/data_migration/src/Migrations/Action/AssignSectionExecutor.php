<?php declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\SectionService;
use Ibexa\Contracts\Core\Repository\Values\ValueObject as APIValueObject;
use Ibexa\Migration\StepExecutor\ActionExecutor\ExecutorInterface;
use Ibexa\Migration\ValueObject;

final readonly class AssignSectionExecutor implements ExecutorInterface
{
    public function __construct(
        private ContentService $contentService,
        private SectionService $sectionService
    ) {
    }

    /**
     * @param \App\Migrations\Action\AssignSection $action
     * @param \Ibexa\Contracts\Core\Repository\Values\Content\Content $content
     */
    public function handle(ValueObject\Step\Action $action, APIValueObject $content): void
    {
        $contentInfo = $this->contentService->loadContentInfo($content->id);
        $section = $this->sectionService->loadSectionByIdentifier($action->getValue());
        $this->sectionService->assignSection($contentInfo, $section);
    }
}
