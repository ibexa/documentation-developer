<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\MyFeature\MyFeature;
use App\MyFeature\MyFeatureService;
use Ibexa\Contracts\ActivityLog\Event\PostActivityGroupListLoadEvent;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyFeaturePostActivityListLoadEventSubscriber implements EventSubscriberInterface
{
    private MyFeatureService $myFeatureService;

    public function __construct(
        MyFeatureService $myFeatureService
    ) {
        $this->myFeatureService = $myFeatureService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostActivityGroupListLoadEvent::class => ['loadMyFeature'],
        ];
    }

    public function loadMyFeature(PostActivityGroupListLoadEvent $event): void
    {
        $visitedIds = [];
        $list = $event->getList();
        foreach ($list as $logGroup) {
            foreach ($logGroup->getActivityLogsInvalid() as $log) {
                if ($log->getObjectClass() !== MyFeature::class) {
                    continue;
                }

                $id = (int)$log->getObjectId();
                try {
                    if (!array_key_exists($id, $visitedIds)) {
                        $visitedIds[$id] = $this->myFeatureService->load($id);
                    }

                    if ($visitedIds[$id] === null) {
                        continue;
                    }

                    $log->setRelatedObject($visitedIds[$id]);
                } catch (NotFoundException|UnauthorizedException $e) {
                    $visitedIds[$id] = null;
                }
            }
        }
    }
}
