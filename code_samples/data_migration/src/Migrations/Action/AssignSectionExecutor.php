<?php declare(strict_types=1);

namespace App\Migrations\Action;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\SectionService;
use eZ\Publish\API\Repository\Values\ValueObject as APIValueObject;
use Ibexa\Platform\Migration\StepExecutor\ActionExecutor\ExecutorInterface;
use Ibexa\Platform\Migration\ValueObject;

final class AssignSectionExecutor implements ExecutorInterface
{
    /** @var \eZ\Publish\API\Repository\SectionService */
    private $sectionService;

    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    public function __construct(
        ContentService $contentService,
        SectionService $sectionService
    ) {
        $this->sectionService = $sectionService;
        $this->contentService = $contentService;
    }

    /**
     * @param \App\Migrations\Action\AssignSection $action
     * @param \eZ\Publish\API\Repository\Values\Content\Content $content
     */
    public function handle(ValueObject\Step\Action $action, APIValueObject $content): void
    {
        $contentInfo = $this->contentService->loadContentInfo($content->id);
        $section = $this->sectionService->loadSectionByIdentifier($action->getValue());
        $this->sectionService->assignSection($contentInfo, $section);
    }
}
