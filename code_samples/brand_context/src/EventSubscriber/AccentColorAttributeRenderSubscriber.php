<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\SiteContext\Event\BrandContextAttributeRenderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final readonly class AccentColorAttributeRenderSubscriber
{
    #[AsEventListener]
    public function onAttributeRender(BrandContextAttributeRenderEvent $event): void
    {
        if ($event->getAttributeValue()->getDefinition()->getIdentifier() !== 'color_accent') {
            return;
        }

        $event->prependTemplate('@ibexadesign/brand_context/accent_color_blocks.html.twig');
    }
}
