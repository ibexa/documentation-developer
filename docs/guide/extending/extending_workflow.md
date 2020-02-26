# Extending Workflow

## Adding custom actions

[Built-in actions in the Editorial Workflow](../workflow.md#publishing-content-with-workflow)
enable you to automatically publish a Content item or to sent a notification to reviewers.

You can also create custom actions that will be called when content reaches a specific stage
or goes through a transition in a workflow.

``` yaml
custom_workflow:
    # ...
    stages:
        # ...
        proofread:
            label: Proofread
            color: '#5a10f1'
            actions:
                stage_action:
                    data:
                        message: "This notification is called by content reaching a stage in workflow"
                    condition:
                        - subject.contentType.identifier == "article"
```

The configuration indicates the name of the custom action (`stage_action`)
and the `condition` under which it is going to be called.
In this case, the action will be performed if the Content item to reach this stage belongs to the Article Content Type.

`data` contains additional data that can be passed to the action. In this case it a message to display.

To define what the action does, create an Event Listener, in this case `src/EventListener/StageListener.php`:

``` php
// ...
use EzSystems\EzPlatformWorkflow\Event\Action\AbstractStageWorkflowActionListener;
use Symfony\Component\Workflow\Event\Event;

class StageListener extends AbstractStageWorkflowActionListener
{
    /// ...

    public function getIdentifier(): string
    {
        return 'stage_action';
    }

    public function onWorkflowEvent(Event $event): void
    {
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin('admin'));

        $metadata = $this->getActionMetadata($event->getWorkflow(), $event->getMarking()->getPlaces());

        $message = $metadata['data']['message'];

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );
    }
}
```

This Listener displays a notification bar at the bottom of the page when an Article reaches the `proofread` stage.

The listener must be registered as a service:

``` yaml
App\EventListener\StageListener:
    tags:
        - { name: ezplatform.workflow.action_listener }
```

## Workflow event timeline

[Workflow event timeline](../workflow.md) is used out of the box to display workflow transitions.

You can also use it to render custom entries in the timeline, for example system alerts on workflows.

### Adding custom entry type

To add a custom entry type, create a custom class extending `\EzSystems\EzPlatformWorkflow\WorkflowTimeline\Value\AbstractEntry`.
Use an `\EzSystems\EzPlatformWorkflow\Event\TimelineEvents::COLLECT_ENTRIES` event to add your entries to the timeline.

### Providing custom templates

To provide custom templates for new event timeline entries, use the following configuration:

``` yaml
ezplatform:
    system:
        default:
            workflows_config:
                # Workflow Timeline
                timeline_entry_templates:
                    - { template: '@EzPlatformWorkflow/ezplatform_workflow/timeline/entries.html.twig', priority: 10 }
```

The template has to provide a block named `ez_workflow_timeline_entry_{ENTRY_IDENTIFIER}`.
