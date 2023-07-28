<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Core\MVC\Symfony\View\View;

class RelationController
{
    private $contentService;

    private $locationService;

    public function __construct(ContentService $contentService, LocationService $locationService)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
    }

    public function showContentAction(View $view, $locationId)
    {
        $acceptedContentTypes = $view->getParameter('accepted_content_types');

        $location = $this->locationService->loadLocation($locationId);
        $contentInfo = $location->getContentInfo();
        $versionInfo = $this->contentService->loadVersionInfo($contentInfo);
        $relations = $this->contentService->loadRelations($versionInfo);

        $items = [];

        foreach ($relations as $relation) {
            if (in_array($relation->getDestinationContentInfo()->getContentType()->identifier, $acceptedContentTypes)) {
                $items[] = $this->contentService->loadContentByContentInfo($relation->getDestinationContentInfo());
            }
        }

        $view->addParameters([
            'items' => $items,
        ]);

        return $view;
    }
}
