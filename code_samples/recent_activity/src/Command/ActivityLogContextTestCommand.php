<?php declare(strict_types=1);

namespace App\Command;

use App\Event\MyFeatureEvent;
use App\MyFeature\MyFeature;
use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationCreateStruct;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'doc:test:activity-log-context',
    description: 'Test activity log context usage'
)]
class ActivityLogContextTestCommand extends Command
{
    private ActivityLogServiceInterface $activityLogService;

    private ContentService $contentService;

    private ContentTypeService $contentTypeService;

    private EventDispatcherInterface $eventDispatcher;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    public function __construct(
        ActivityLogServiceInterface $activityLogService,
        ContentService $contentService,
        ContentTypeService $contentTypeService,
        EventDispatcherInterface $eventDispatcher,
        PermissionResolver $permissionResolver,
        UserService $userService
    ) {
        $this->activityLogService = $activityLogService;
        $this->contentService = $contentService;
        $this->contentTypeService = $contentTypeService;
        $this->eventDispatcher = $eventDispatcher;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'A test number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin('admin'));

        $this->activityLogService->prepareContext('my_feature', 'Operation description');

        $activityLogStruct = $this->activityLogService->build(MyFeature::class, $id, 'init');
        $activityLogStruct->setObjectName("My Feature #$id");
        $this->activityLogService->save($activityLogStruct);

        $contentCreateStruct = $this->contentService->newContentCreateStruct($this->contentTypeService->loadContentTypeByIdentifier('folder'), 'eng-GB');
        $contentCreateStruct->setField('name', "My Feature Folder #$id", 'eng-GB');
        $locationCreateStruct = new LocationCreateStruct(['parentLocationId' => 2]);
        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);
        $this->contentService->publishVersion($draft->versionInfo);

        $event = new MyFeatureEvent(new MyFeature(['id' => $id, 'name' => "My Feature #$id"]), 'simulate');
        $this->eventDispatcher->dispatch($event);

        $activityLogStruct = $this->activityLogService->build(MyFeature::class, $id, 'complete');
        $activityLogStruct->setObjectName("My Feature #$id");
        $this->activityLogService->save($activityLogStruct);

        $this->activityLogService->dismissContext();

        return Command::SUCCESS;
    }
}
