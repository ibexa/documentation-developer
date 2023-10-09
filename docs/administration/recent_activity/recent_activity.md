---
description: Log and monitor activity through UI, PHP API and REST API.
---

# Recent activity

TODO: Feature introduction and description, link to the user doc, …

## PHP API

The ActivityLogService PHP API can be used to browse activity logs and write new entries.

### Searching in the Activity Log entries

TODO: Move to a PHP file

```php
<?php

namespace App\Command;

use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\ActivityLogInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause\LoggedAtSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MonitorRecentContentCreationCommand extends Command {
    
    private ActivityLogServiceInterface $activityLogService;

    public function __construct(ActivityLogServiceInterface $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    protected function configure(): void {
        $this->setDescription('List last 25 Content item creations in the last hour');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new Query(new Criterion\LogicalAnd([
            new Criterion\ObjectCriterion(Content::class),
            new Criterion\ActionCriterion('create'),
            new Criterion\LoggedAtCriterion(new DateTime('- 1 hour'), Criterion\LoggedAtCriterion::GTE),
        ]), new LoggedAtSortClause(LoggedAtSortClause::DESC), 0, 25);
        /** @var ActivityLogInterface $activityLog */
        foreach ($this->activityLogService->find($query) as $activityLog) {
            $output->writeln("{$activityLog->getUser()->login} created Content {$activityLog->getObjectId()} at {$activityLog->getLoggedAt()}");
        }
    }
}
```

See [Activity Log Search Criteria reference](activity_log_search.md) to discover query possibilities.

### Adding custom Activity Log entries

Your custom features could write into the activity log.

First, inject `Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface` into your custom event subscriber, event listener, service, controller or whatever class that will have to log an activity.

In the following example, an event subscriber is subscribing to an event dispatched by a custom feature. 

TODO: Move to a PHP file

```php
<?php

namespace App\EventSubscriber;

use App\Event\MyFeatureEvent;
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyFeatureEventSubscriber extends EventSubscriberInterface {

    private ActivityLogServiceInterface $activityLogService;

    public function __construct(ActivityLogServiceInterface $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public static function getSubscribedEvents(): array
    {
        MyFeatureEvent::class => 'onMyFeatureEvent',
    }

    public function onMyFeatureEvent(MyFeatureEvent $event): void
    {
        $className = MyFeature::class;
        $id = (string)$event->getId();
        $action = $event->getAction();
        $activityLog = $this->activityLogService->build($className, $id, $action);
        $this->activityLogService->save($activityLog);
    }
}
```

`ActivityLogService::build` function returns an `Ibexa\Contracts\ActivityLog\Values\CreateActivityLogStruct` which can then be passed to `ActivityLogService::save`.

ActivityLogService::build has three arguments:

* `$className` is the PHP class name of the object actually manipulated by the feature. For example `Ibexa\Contracts\Core\Repository\Values\Content\Content::class`
* `$id` is the ID or identifier of the manipulated object. For example, the Content ID.
* `$action` is the identifier of the performed object manipulation. For example, `create`, `update` or `delete`.

The returned `CreateActivityLogStruct` is, by default, related to the currently logged-in user.

## REST API

REST API can be used to browse activity logs or write new entries.

See in the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#activity-log) routes starting with `/activity-log/`.
