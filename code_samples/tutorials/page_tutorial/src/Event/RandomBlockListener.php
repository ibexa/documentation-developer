<?php

declare(strict_types=1);

namespace App\Event;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Location;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RandomBlockListener implements EventSubscriberInterface
{
    private ContentService $contentService;

    private LocationService $locationService;

    private SearchService $searchService;

    public function __construct(
        ContentService $contentService,
        LocationService $locationService,
        SearchService $searchService
    ) {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->searchService = $searchService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('random') => 'onBlockPreRender',
        ];
    }

    public function onBlockPreRender(PreRenderEvent $event): void
    {
        $blockValue = $event->getBlockValue();
        $renderRequest = $event->getRenderRequest();

        $parameters = $renderRequest->getParameters();

        $contentIdAttribute = $blockValue->getAttribute('parent');
        $location = $this->loadLocationByContentId((int) $contentIdAttribute->getValue());
        $contents = $this->findContentItems($location);
        shuffle($contents);

        $parameters['randomContent'] = reset($contents);

        $renderRequest->setParameters($parameters);
    }

    private function findContentItems(Location $location): array
    {
        $query = new Query();
        $query->query = new Criterion\LogicalAnd(
            [
                new Criterion\ParentLocationId($location->id),
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            ]
        );

        $searchHits = $this->searchService->findContent($query)->searchHits;

        $contentArray = [];
        foreach ($searchHits as $searchHit) {
            $contentArray[] = $searchHit->valueObject;
        }

        return $contentArray;
    }

    private function loadLocationByContentId(int $contentId): Location
    {
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        return $this->locationService->loadLocation($contentInfo->mainLocationId);
    }
}
