<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Events\Content\CopyContentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyEventSubcriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CopyContentEvent::class => ['onCopyContent', 0],
        ];
    }

    public function onCopyContent(CopyContentEvent $event): void
    {
        // your implementation
    }
}
