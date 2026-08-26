<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Iterator\BatchIterator;
use Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\RelationListIteratorAdapter;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Core\MVC\Symfony\View\View;

class RelationController
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly LocationService $locationService
    ) {
    }

    public function showContentAction(View $view, $locationId): View
    {
        $acceptedContentTypes = $view->getParameter('accepted_content_types');

        $location = $this->locationService->loadLocation($locationId);
        $contentInfo = $location->getContentInfo();
        $versionInfo = $this->contentService->loadVersionInfo($contentInfo);
        $relationListIterator = new BatchIterator(
            new RelationListIteratorAdapter(
                $this->contentService,
                $versionInfo
            )
        );

        $items = [];

        foreach ($relationListIterator as $relationListItem) {
            if ($relationListItem->hasRelation() && in_array($relationListItem->getRelation()->getDestinationContentInfo()->getContentType()->identifier, $acceptedContentTypes)) {
                $items[] = $this->contentService->loadContentByContentInfo($relationListItem->getRelation()->getDestinationContentInfo());
            }
        }

        $view->addParameters([
            'items' => $items,
        ]);

        return $view;
    }
}
