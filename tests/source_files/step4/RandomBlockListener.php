<?php

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 *
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Event;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RandomBlockListener implements EventSubscriberInterface
{
    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \eZ\Publish\API\Repository\LocationService */
    private $locationService;

    /** @var \eZ\Publish\API\Repository\SearchService */
    private $searchService;

    /**
     * @param \eZ\Publish\API\Repository\ContentService $contentService
     * @param \eZ\Publish\API\Repository\LocationService $locationService
     * @param \eZ\Publish\API\Repository\SearchService $searchService
     */
    public function __construct(
        ContentService $contentService,
        LocationService $locationService,
        SearchService $searchService
    ) {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->searchService = $searchService;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('random') => 'onBlockPreRender',
        ];
    }

    /**
     * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
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

    /**
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
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

    /**
     * @param int $contentId
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Location
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    private function loadLocationByContentId(int $contentId): Location
    {
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        return $this->locationService->loadLocation($contentInfo->mainLocationId);
    }
}
