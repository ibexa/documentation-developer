<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
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
        $relationList = $this->contentService->loadRelationList($versionInfo);

        $items = [];

        foreach ($relationList as $relationListItem) {
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
