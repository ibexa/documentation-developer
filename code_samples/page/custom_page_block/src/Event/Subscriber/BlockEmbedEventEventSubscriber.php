<?php declare(strict_types=1);

namespace App\Event\Subscriber;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlockEmbedEventEventSubscriber implements EventSubscriberInterface
{
    private ContentService $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('event') => 'onBlockPreRender',
        ];
    }

    public function onBlockPreRender(PreRenderEvent $event): void
    {
        $renderRequest = $event->getRenderRequest();
        $parameters = $event->getRenderRequest()->getParameters();
        $parameters['event_content'] = $this->contentService->loadContent($parameters['event']);
        $renderRequest->setParameters($parameters);
    }
}
