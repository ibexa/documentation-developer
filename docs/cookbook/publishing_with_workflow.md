# Publishing with workflow

## Publish content that reaches final stage

[Editorial workflow](../guide/workflow.md) does not automatically publish a Content item
when it reaches the final stage of a workflow.

To do it, you need to set up an event subscriber.

You can use the [`PublishOnLastStageSubscriber.php`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.0/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php) from eZ Platform demo as a basis for the subscriber.

!!! note

    This example only works if your workflow is a [direct acycling graph](https://en.wikipedia.org/wiki/Directed_acyclic_graph)
    (it doesn't have directed cycles).

The subscriber listens for the `WorkflowEvents::WORKFLOW_STAGE_CHANGE` event
([line 61](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.0/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php#L61)).
When the event occurs, it publishes the relevant Content item
([line 87](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.0/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php#L87)).

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
which will automatically move content to the last stage of the workflow after it has been published.

You can use the [`EndWorkflowSubscriber.php`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.0/src/AppBundle/Event/Subscriber/EndWorkflowSubscriber.php) from eZ Platform demo as a basis for the subscriber.

The [`doEndWorkflows()`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.0/src/AppBundle/Event/Subscriber/EndWorkflowSubscriber.php#L105) function
applies all transitions that are needed to bring the Content item to the final workflow stage.

The subscriber must also be registered as a service:

``` yaml
services:
    # ...
    AppBundle\Event\Subscriber\EndWorkflowSubscriber: ~
```
