<?php declare(strict_types=1);

namespace App\Event;

use Ibexa\Contracts\ImageEditor\Event\ConfigureImageOptimizersEvent;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RemovePngquantOptimizer implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureImageOptimizersEvent::class => 'onConfigureOptimizers',
        ];
    }

    public function onConfigureOptimizers(ConfigureImageOptimizersEvent $event): void
    {
        $event->removeOptimizer(Pngquant::class);
    }
}
