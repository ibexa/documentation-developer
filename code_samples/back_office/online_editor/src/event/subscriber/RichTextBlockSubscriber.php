<?php

declare(strict_types=1);

namespace App\Event\Subscriber;

use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Twig\TwigRenderRequest;
use Ibexa\FieldTypeRichText\RichText\DOMDocumentFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RichTextBlockSubscriber implements EventSubscriberInterface
{
    /** @var \Ibexa\FieldTypeRichText\RichText\DOMDocumentFactory */
    private $domDocumentFactory;

    /**
     * @param \Ibexa\FieldTypeRichText\RichText\DOMDocumentFactory $domDocumentFactory
     */
    public function __construct(DOMDocumentFactory $domDocumentFactory)
    {
        $this->domDocumentFactory = $domDocumentFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('my_block') => 'onBlockPreRender',
        ];
    }

    /**
     * @param \Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
     */
    public function onBlockPreRender(PreRenderEvent $event): void
    {
        $renderRequest = $event->getRenderRequest();
        if (!$renderRequest instanceof TwigRenderRequest) {
            return;
        }
        $parameters = $renderRequest->getParameters();
        $parameters['document'] = null;
        $xml = $event->getBlockValue()->getAttribute('content')->getValue();
        if (!empty($xml)) {
            $parameters['document'] = $this->domDocumentFactory->loadXMLString($xml);
        }
        $renderRequest->setParameters($parameters);
    }
}
