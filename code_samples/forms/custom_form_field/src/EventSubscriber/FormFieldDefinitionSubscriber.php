<?php declare(strict_types=1);

namespace App\EventSubscriber;

use EzSystems\EzPlatformFormBuilder\Definition\FieldAttributeDefinitionBuilder;
use EzSystems\EzPlatformFormBuilder\Event\FieldDefinitionEvent;
use EzSystems\EzPlatformFormBuilder\Event\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormFieldDefinitionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::getFieldDefinitionEventName('single_line') => 'onSingleLineFieldDefinition',
        ];
    }

    public function onSingleLineFieldDefinition(FieldDefinitionEvent $event): void
    {
        $isReadOnlyAttribute = new FieldAttributeDefinitionBuilder();
        $isReadOnlyAttribute->setIdentifier('custom');
        $isReadOnlyAttribute->setName('Custom attribute');
        $isReadOnlyAttribute->setType('string');

        $definitionBuilder = $event->getDefinitionBuilder();
        $definitionBuilder->addAttribute($isReadOnlyAttribute->buildDefinition());
    }
}
