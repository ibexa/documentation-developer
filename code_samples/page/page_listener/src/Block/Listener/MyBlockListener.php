<?php

namespace App\Block\Listener;

use Ibexa\FieldTypePage\FieldType\Page\Block\Definition\BlockDefinitionEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Definition\Event\BlockAttributeDefinitionEvent;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Ibexa\FieldTypePage\FieldType\Page\Block\Attribute\ValueConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyBlockListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('my_block') => 'onBlockPreRender'
        ];
    }

    public function onBlockPreRender(PreRenderEvent $event)
    {
        $renderRequest = $event->getRenderRequest();

        $parameters = $event->getRenderRequest()->getParameters();

        $parameters['my_parameter'] = 'parameter_value';

        $renderRequest->setParameters($parameters);
    }
}
