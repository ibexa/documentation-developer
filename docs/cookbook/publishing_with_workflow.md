# Publishing with workflow

## Publish content that reaches final stage

[Editorial workflow](../guide/workflow.md) does not automatically publish a Content item
when it reaches the final stage of a workflow.

To do it, you need to set up an event subscriber.

The subscriber below listens for the `WorkflowEvents::WORKFLOW_STAGE_CHANGE` event (line 57).
When the event occurs, it publishes the relevant Content item (line 83).

``` php hl_lines="57 83"
<?php

declare(strict_types=1);

namespace AppBundle\Event\Workflow;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\Repository;
use EzSystems\EzPlatformWorkflow\Event\StageChangeEvent;
use EzSystems\EzPlatformWorkflow\Event\WorkflowEvents;
use EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Transition;

class PublishOnLastStageSubscriber implements EventSubscriberInterface
{
    /** @var \eZ\Publish\API\Repository\PermissionResolver */
    private $permissionResolver;

    /** @var \EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry */
    private $workflowMetadataRegistry;

    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \EzSystems\FlexWorkflow\API\Repository\RepositoryInterface */
    private $repository;

    private $publishOnLastStageWorkflows;

    /**
     * @param \eZ\Publish\API\Repository\PermissionResolver $permissionResolver
     * @param \eZ\Publish\API\Repository\Repository $repository
     * @param \eZ\Publish\API\Repository\ContentService $contentService
     * @param \EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry $workflowMetadataRegistry
     * @param array $publishOnLastStageWorkflows
     */
    public function __construct(
        PermissionResolver $permissionResolver,
        Repository $repository,
        ContentService $contentService,
        WorkflowDefinitionMetadataRegistry $workflowMetadataRegistry,
        array $publishOnLastStageWorkflows
    ) {
        $this->permissionResolver = $permissionResolver;
        $this->workflowMetadataRegistry = $workflowMetadataRegistry;
        $this->contentService = $contentService;
        $this->repository = $repository;
        $this->publishOnLastStageWorkflows = $publishOnLastStageWorkflows;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            WorkflowEvents::WORKFLOW_STAGE_CHANGE => ['onStageChange', 30],
        ];
    }

    public function onStageChange(StageChangeEvent $event): void
    {
        $workflowName = $event->getWorkflowMetadata()->name;

        if (!\in_array($workflowName, $this->publishOnLastStageWorkflows, true)
            || !$this->workflowMetadataRegistry->hasWorkflowMetadata($workflowName)
        ) {
            return;
        }

        $workflowDefinitionMetadata = $this->workflowMetadataRegistry->getWorkflowMetadata($workflowName);
        $workflowDefinition = $event->getWorkflowMetadata()->workflow->getDefinition();

        $transitionName = $event->getTransitionMetadata()->name;
        $workflowTos = $this->getWorkflowTransitionTos($transitionName, $workflowDefinition);

        foreach ($workflowTos as $stageName) {
            $isLastStage = $workflowDefinitionMetadata->getStageMetadata($stageName)->isLastStage();

            if ($isLastStage) {
                $this->permissionResolver->sudo(function () use ($event) {
                    if ($event->getWorkflowMetadata()->versionInfo->isDraft()) {
                        $this->contentService->publishVersion($event->getWorkflowMetadata()->versionInfo);
                    }
                }, $this->repository);
            }
        }
    }

    private function getWorkflowTransitionTos(string $transitionName, Definition $workflowDefinition)
    {
        $workflowTransitions = array_filter($workflowDefinition->getTransitions(), function (Transition $item) use ($transitionName) {
            return $transitionName === $item->getName();
        });

        $tos = [];

        return array_reduce($workflowTransitions, function ($tos, Transition $item) {
            return array_merge($tos, $item->getTos());
        }, $tos);
    }
}
```

The subscriber must be registered as a service:

``` yaml hl_lines="5"
services:
    # ...
    AppBundle\Event\Workflow\PublishOnLastStageSubscriber:
        arguments:
            $publishOnLastStageWorkflows: '%app.workflow.publish_on_last_stage%'
```

You must also provide the identifier of the workflow you want the subscriber to apply to.
Do it in the `app.workflow.publish_on_last_stage` parameter:

``` yaml
parameters:
    app.workflow.publish_on_last_stage: [editorial_workflow, legal_workflow]
```

## Finish workflow for published content

With proper permissions, you can publish content even before it has gone through a whole workflow.
Afterwards it will still be visible in the review queue
and in the relevant stage of **Content item(s) under review** tab under **Workflow** in the Admin panel.

To avoid cluttering the tables with published content, you can use an event subscriber
which will automatically move content to the last stage of the workflow after it has been published:

``` php hl_lines="1 12"
public static function getSubscribedEvents(): array
{
    return [
        MVCEvents::API_SIGNAL => ['onPublishVersionSignal', -50],
    ];
}

public function onPublishVersionSignal(SignalEvent $event): void
{
    $signal = $event->getSignal();

    if (!$signal instanceof PublishVersionSignal) {
        return;
    }

    $this->doEndWorkflows((int)$signal->contentId, (int)$signal->versionNo);
}
```

The `doEndWorkflows()` function applies all transitions that are needed to bring the Content item
to the final workflow stage.

``` php  hl_lines="21 22"
private function doEndWorkflows(int $contentId, int $versionNo): void
{
    $content = $this->contentService->loadContent($contentId, [], $versionNo);
    $supportedWorkflows = $this->workflowRegistry->getSupportedWorkflows($content);

    foreach ($supportedWorkflows as $workflow) {
        try {
            $workflowMetadata = $this->workflowService->loadWorkflowMetadataForContent($content, $workflow->getName());
        } catch (NotFoundException $e) {
            continue;
        }

        $workflowCurrentState = !empty($workflowMetadata->markings) ? end($workflowMetadata->markings)->name : '';
        $transitions = $workflowMetadata->workflow->getDefinition()->getTransitions();
        $lastStage = $this->getLastStage($transitions, $workflow->getName());

        if (!$lastStage) {
            continue;
        }

        $transitionsToMake = $this->findPathToLastStage($transitions, $workflowCurrentState, $lastStage);
        $this->applyTransitions($transitionsToMake, $workflowMetadata);
    }
}
```

??? note "Full `EndWorkflowSubscriber` code"

    The subscriber in this example is located in `AppBundle/Event/Subscriber/EndWorkflowSubscriber.php`.

    ``` php
    <?php

    declare(strict_types=1);

    namespace AppBundle\Event\Subscriber;

    use eZ\Publish\API\Repository\ContentService;
    use eZ\Publish\API\Repository\PermissionResolver;
    use eZ\Publish\API\Repository\Repository;
    use eZ\Publish\Core\MVC\Symfony\Event\SignalEvent;
    use eZ\Publish\Core\MVC\Symfony\MVCEvents;
    use eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal;
    use EzSystems\EzPlatformWorkflow\Exception\NotFoundException;
    use EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry;
    use EzSystems\EzPlatformWorkflow\Registry\WorkflowRegistryInterface;
    use EzSystems\EzPlatformWorkflow\Service\WorkflowServiceInterface;
    use EzSystems\EzPlatformWorkflow\Value\WorkflowMetadata;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\Workflow\Transition;

    class EndWorkflowSubscriber implements EventSubscriberInterface
    {
        /** @var \EzSystems\EzPlatformWorkflow\Service\WorkflowServiceInterface */
        private $workflowService;

        /** @var \EzSystems\EzPlatformWorkflow\Registry\WorkflowRegistryInterface */
        private $workflowRegistry;

        /** @var \eZ\Publish\API\Repository\ContentService */
        private $contentService;

        /** @var \EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry */
        private $workflowMetadataRegistry;

        /** @var \EzSystems\FlexWorkflow\API\Repository\RepositoryInterface */
        private $repository;

        /** @var \eZ\Publish\API\Repository\PermissionResolver */
        private $permissionResolver;

        /**
         * @param \EzSystems\EzPlatformWorkflow\Service\WorkflowServiceInterface $workflowService
         * @param \EzSystems\EzPlatformWorkflow\Registry\WorkflowRegistryInterface $workflowRegistry
         * @param \eZ\Publish\API\Repository\ContentService $contentService
         * @param \EzSystems\EzPlatformWorkflow\Registry\WorkflowDefinitionMetadataRegistry $workflowMetadataRegistry
         * @param \eZ\Publish\API\Repository\Repository $repository
         * @param \eZ\Publish\API\Repository\PermissionResolver $permissionResolver
         */
        public function __construct(
            WorkflowServiceInterface $workflowService,
            WorkflowRegistryInterface $workflowRegistry,
            ContentService $contentService,
            WorkflowDefinitionMetadataRegistry $workflowMetadataRegistry,
            Repository $repository,
            PermissionResolver $permissionResolver
        ) {
            $this->workflowService = $workflowService;
            $this->workflowRegistry = $workflowRegistry;
            $this->contentService = $contentService;
            $this->workflowMetadataRegistry = $workflowMetadataRegistry;
            $this->repository = $repository;
            $this->permissionResolver = $permissionResolver;
        }

        /**
         * {@inheritdoc}
         */
        public static function getSubscribedEvents(): array
        {
            return [
                MVCEvents::API_SIGNAL => ['onPublishVersionSignal', -50],
            ];
        }

        /**
         * Automatically removes content from workflow when it is published
         *
         * @param \eZ\Publish\Core\MVC\Symfony\Event\SignalEvent $event
         *
         * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
         * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
         */
        public function onPublishVersionSignal(SignalEvent $event): void
        {
            $signal = $event->getSignal();

            if (!$signal instanceof PublishVersionSignal) {
                return;
            }

            $this->doEndWorkflows((int)$signal->contentId, (int)$signal->versionNo);
        }

        /**
         * @param int $contentId
         * @param int $versionNo
         *
         * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
         * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
         */
        private function doEndWorkflows(int $contentId, int $versionNo): void
        {
            $content = $this->contentService->loadContent($contentId, [], $versionNo);
            $supportedWorkflows = $this->workflowRegistry->getSupportedWorkflows($content);

            foreach ($supportedWorkflows as $workflow) {
                try {
                    $workflowMetadata = $this->workflowService->loadWorkflowMetadataForContent($content, $workflow->getName());
                } catch (NotFoundException $e) {
                    continue;
                }

                $workflowCurrentState = !empty($workflowMetadata->markings) ? end($workflowMetadata->markings)->name : '';
                $transitions = $workflowMetadata->workflow->getDefinition()->getTransitions();
                $lastStage = $this->getLastStage($transitions, $workflow->getName());

                if (!$lastStage) {
                    continue;
                }

                $transitionsToMake = $this->findPathToLastStage($transitions, $workflowCurrentState, $lastStage);
                $this->applyTransitions($transitionsToMake, $workflowMetadata);
            }
        }

        private function applyTransitions(array $transitionsToMake, WorkflowMetadata $workflowMetadata): void
        {
            foreach ($transitionsToMake as $transitionToMake) {
                $this->permissionResolver->sudo(function () use ($workflowMetadata, $transitionToMake) {
                    if ($this->workflowService->can($workflowMetadata, $transitionToMake)) {
                        $this->workflowService->apply($workflowMetadata, $transitionToMake, '');

                    }
                }, $this->repository);
            }
        }

        private function getLastStage(array $transitions, string $workflowName): ?Transition
        {
            $workflowDefinitionMetadata = $this->workflowMetadataRegistry->getWorkflowMetadata($workflowName);

            /** @var Transition $transition */
            foreach ($transitions as $transition) {
                foreach ($transition->getTos() as $to) {
                    if ($workflowDefinitionMetadata->getStageMetadata($to)->isLastStage()) {
                        return $transition;
                    }
                }
            }

            return null;
        }

        private function findPathToLastStage(array $transitions, string $workflowCurrentState, Transition $transition)
        {
            $path = [$transition->getName()];

            while (true) {
                $matched = $this->getMatchedTransitions($transitions, $transition);

                if (empty($matched)) {
                    break;
                }

                if (in_array($matched[0]->getName(), $path, true)) {
                    break;
                }

                $path[] = $matched[0]->getName();

                if (in_array($workflowCurrentState, $matched[0]->getFroms(), true)) {
                    break;
                }

                $transition = $matched[0];
            }

            return array_reverse($path);
        }

        /**
         * @param array $transitions
         * @param Transition $baseTransition
         * @return Transition[]
         */
        private function getMatchedTransitions(array $transitions, Transition $baseTransition): array
        {
            $return = [];

            foreach ($baseTransition->getFroms() as $from) {
                /** @var Transition $transition */
                foreach($transitions as $transition) {
                    foreach ($transition->getTos() as $to) {
                        if ($from === $to) {
                            $return[] = $transition;
                        }
                    }
                }
            }

            return $return;
        }
    }
    ```

The subscriber must also be registered as a service:

``` yaml
services:
    # ...
    AppBundle\Event\Subscriber\EndWorkflowSubscriber: ~
```
