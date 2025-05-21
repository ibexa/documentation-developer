<?php declare(strict_types=1);

namespace App\EventListener;

use Ibexa\Contracts\Core\Repository\Events\Content\PublishVersionEvent;
use Ibexa\Contracts\Core\Repository\NotificationService;
use Ibexa\Contracts\Core\Repository\Values\Notification\CreateStruct;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ContentPublishEventListener implements EventSubscriberInterface
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public static function getSubscribedEvents(): array
    {
        return [PublishVersionEvent::class => 'onPublishVersion'];
    }

    public function onPublishVersion(PublishVersionEvent $event): void
    {
        $data = [
            'content_name' => $event->getContent()->getName(),
            'content_id' => $event->getContent()->id,
            'message' => 'published',
        ];

        $notification = new CreateStruct();
        $notification->ownerId = $event->getContent()->contentInfo->ownerId;
        $notification->type = 'ContentPublished';
        $notification->data = $data;

        $this->notificationService->createNotification($notification);
    }
}
