<?php declare(strict_types=1);

namespace App\src\EventSubscriber;

use App\src\Event\MyFeatureEvent;
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyFeatureEventSubscriber implements EventSubscriberInterface
{
    private ActivityLogServiceInterface $activityLogService;

    public function __construct(ActivityLogServiceInterface $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MyFeatureEvent::class => 'onMyFeatureEvent',
        ];
    }

    public function onMyFeatureEvent(MyFeatureEvent $event): void
    {
        $className = get_class($event->getObject());
        $id = (string)$event->getObject()->id;
        $action = $event->getAction();
        $activityLog = $this->activityLogService->build($className, $id, $action);
        $this->activityLogService->save($activityLog);
    }
}
