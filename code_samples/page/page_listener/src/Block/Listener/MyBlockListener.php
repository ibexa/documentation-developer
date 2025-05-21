<?php declare(strict_types=1);

namespace App\Block\Listener;

use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyBlockListener implements EventSubscriberInterface
{
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

        $parameters['my_parameter'] = 'parameter_value';

        $renderRequest->setParameters($parameters);
    }
}
