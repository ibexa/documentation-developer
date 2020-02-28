# Extending Workflow

## Adding custom actions

[Built-in actions in the Editorial Workflow](../workflow.md#publishing-content-with-workflow)
enable you to automatically publish a Content item or to sent a notification to reviewers.

You can also create custom actions that will be called when content reaches a specific stage
or goes through a transition in a workflow.

``` yaml
custom_workflow:
    # ...
    transitions:
        # ...
        to_proofread:
            label: To proofreading
            color: '#8888ba'
            actions:
                transition_action:
                    data:
                        message: "This notification is called by content reaching a stage in workflow"
```

The configuration indicates the name of the custom action (`transition_action`) that will call the action.
`data` contains additional data that can be passed to the action. In this case it a message to display.

To define what the action does, create an Event Listener, in this case `src/EventListener/TransitionListener.php`:

``` php
// ...
use EzSystems\EzPlatformWorkflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

class TransitionListener extends AbstractTransitionWorkflowActionListener
{
    /// ...

    public function getIdentifier(): string
    {
        return 'transition_action';
    }

    public function onWorkflowEvent(TransitionEvent $event): void
    {
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin('admin'));

        $context = $event->getContext();
        $message = $context->message;

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );
    }
}
```

This Listener displays a notification bar at the bottom of the page when a Content item goes through the `to_proofread` transision.

The listener must be registered as a service:

``` yaml
App\EventListener\TransitionListener:
    tags:
        - { name: ezplatform.workflow.action_listener }
```

`$event->getContext()` gives you access to the context of the action.
The context contains:

- `$workflowId` - the ID of the current workflow
- `$message` - content of the message input by the user when sending the Content item through the transitions
- `$reviewerId`: ID of the User who was selected as a reviewer
- `$result`: an array of transition actions performed so far

Context enables you to take into account the transition history of the Content items.

You can set the `result` using the `setResult()` method.

For example, you can modify the message is the Content item has been previously sent back to proofreading:

``` php
$this->setResult($event, 'was_sent_back');
```

You can then use this result as a condition for other actions:

``` yaml
actions:
    stage_action:
        data:
            message: "This Content item had been sent back to proofreading"
        condition:
            - result.transition_action == `was_sent_back`
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
