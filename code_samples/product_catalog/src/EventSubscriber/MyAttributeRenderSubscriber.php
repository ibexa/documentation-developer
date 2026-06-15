<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\ProductCatalog\Events\ProductAttributeRenderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final readonly class MyAttributeRenderSubscriber
{
    #[AsEventListener]
    public function onAttributeRender(ProductAttributeRenderEvent $event): void
    {
        $event->addTemplateBefore(
            'templates/product/attributes/integer_attribute.html.twig',
            '@ibexadesign/product_catalog/product/attributes/attribute_blocks.html.twig',
        );
    }
}
