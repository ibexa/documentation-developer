<?php

namespace App\Block\Listener;

use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinitionEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\Event\BlockAttributeDefinitionEvent;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\ValueConverter;
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
