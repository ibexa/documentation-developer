<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\MyFeatureEvent;
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyFeatureEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly ActivityLogServiceInterface $activityLogService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MyFeatureEvent::class => 'onMyFeatureEvent',
        ];
    }

    public function onMyFeatureEvent(MyFeatureEvent $event): void
    {
        /** @var \App\MyFeature\MyFeature $object */
        $object = $event->getObject();
        $className = $object::class;
        $id = (string)$object->id;
        $action = $event->getAction();
        $activityLog = $this->activityLogService->build($className, $id, $action);
        $activityLog->setObjectName($object->name);
        $this->activityLogService->save($activityLog);
    }
}
