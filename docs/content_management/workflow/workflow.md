---
description: Workflow controls how content items pass between stages and allows setting up editorial flows, for example for reviews and proofreading.
---

# Workflow

The workflow functionality passes a content item version through a series of stages.

For example, an editorial workflow can pass a content item from draft stage through design and proofreading.

By default, [[= product_name =]] comes pre-configured with a Quick Review workflow.
You can disable the default workflow and define different workflows in configuration. 
Workflows are permission-aware.

## Workflow configuration

Each workflow consists of stages and transitions between them.

The following example configuration defines a workflow where you can optionally pass a draft to be checked by the legal team.

![Diagram of custom workflow](workflow_custom_diagram.png)

``` yaml
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 0, 33) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 38, 51) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 54, 62) =]]
```

### Matchers

Matchers define when the workflow is used.
Their configuration is optional.

`content_type` contains an array of content type identifiers that use this workflow.

`content_status` lists the statuses of content items which fall under this workflow.
The available values are: `draft` and `published`. 

If set to `draft`, applies for new content (newly created).

If set to `published`, applies for content that has already been published (for example, edit after the content was published).

``` yaml
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 6, 9) =]]
```

### Stages

Each stage in the workflow has an identifier and can have a label and a color.

The optional `last_stage` key indicates that content in this stage doesn't appear on the dashboard or in Review Queue.

One stage, listed under `initial_stage`, is the one that the workflow starts with.

``` yaml hl_lines="13 14"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 9, 23) =]]
```

### Transitions

Each transition has an identifier and can have a label, a color, and an icon.

A transition must state between which stages it transitions (lines 3-4), or be `reverse` to a different transition (line 9).

``` yaml hl_lines="3 4 9"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 23, 30) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 38, 43) =]]
```

### Reviewers

When moving a content item through a transition, the user can select a reviewer.
Assigning a reviewer is mandatory if you set `reviewers.required` to `true` for this transition.
You can restrict who can review the content item by setting `reviewers.user_group` to a location ID of the user group.

To be able to search for users for review, the user must have the `content/read` policy without any limitation, or with a limitation that allows reading users.
This means that, in addition to your own settings for this policy, you must add the /Users subtree to the limitation and add users in the [content type limitation](limitation_reference.md#content-type-limitation).

``` yaml hl_lines="8 9"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 23, 32) =]]
```

#### Notifications

To ensure that the assigned reviewers get a notification of a transition, configure the `actions.notify_reviewer` action for a stage.

``` yaml hl_lines="4 5"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 13, 18) =]]
```

The notification is displayed in the user menu:

![Notification about content to review](workflow_notification.png)

#### Draft locking

You can configure draft assignment in a way that when a user sends a draft to review, only the first editor of the draft can either edit the draft or unlock it for editing, and no other user can take it over. 

Use the [Version Lock limitation](limitation_reference.md#version-lock-limitation), set to "Assigned only", together with the `content/edit` and `content/unlock` policies to prevent users from editing and unlocking drafts that are locked by another user.

### Content publishing

You can automatically publish a content item once it goes through a specific transition.
To do so, configure the `publish` action for the transition:

``` yaml hl_lines="7 8"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 54, 62) =]]
```

### Disable Quick Review

You can disable the default workflow, for example, if your project doesn't use workflows, or Quick Review entries clog your database:

``` yaml
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 0, 4) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 63, 67) =]]
```

## Custom actions

Besides the built-in actions of publishing content and notifying the reviewers, you can also [create custom workflow actions](add_custom_workflow_action.md).

## Workflow event timeline

Workflow event timeline displays workflow transitions.

You can also use it to render custom entries in the timeline, for example system alerts on workflows.

### Custom entry type

To add a custom entry type, create a custom class extending `Ibexa\Workflow\WorkflowTimeline\Value\AbstractEntry`.
Use an `Ibexa\Contracts\Workflow\Event\TimelineEvents::COLLECT_ENTRIES` event to add your entries to the timeline.

### Custom templates

To provide custom templates for new event timeline entries, use the following configuration:

``` yaml
ibexa:
    system:
        default:
            workflows_config:
                timeline_entry_templates:
                    - { template: '@IbexaWorkflow/ibexa_workflow/timeline/entries.html.twig', priority: 10 }
```

The template has to provide a block named `ez_workflow_timeline_entry_{ENTRY_IDENTIFIER}`.

## Permissions

You can limit access to workflows at stage and transition level.

The `workflow/change_stage` policy grants permission to change stages in a specific workflow.

You can limit this policy with the [Workflow Transition limitation](limitation_reference.md#workflow-transition-limitation) to only allow sending content in the selected transition.

For example, by using the example above, a `workflow/change_stage` policy with `WorkflowTransitionLimitation` set to `Approved by legal` allows a legal team to send content forward after they're done with their review.

You can also use the [Workflow Stage Limitation](limitation_reference.md#workflow-stage-limitation) together with the `content/edit` and `content/publish` Policies to limit the ability to edit content in specific stages.
For example, you can use it to only allow a legal team to edit content in the `legal` stage.

## Validation

### Validate form before workflow transition

By default, sending content to the next stage of the workflow doesn't validate the form in UI, so with the publish action, the form isn't verified for errors in UI.
However, during the publish action, the sent form is validated in the service.

Therefore, if there are any errors in the form, you return to the edit page but errors aren't triggered, which can be confusing when you have two or more tabs.

To enable form validation in UI before sending it to the next stage of the workflow, add `validate: true` to the transitions of the stage.
In the example below the form is validated in two stages:` to_legal` and `done`:

``` yaml hl_lines="15 28"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 23, 43) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 55, 63) =]]
```

You can check validation for a particular stage of the workflow even if the stage doesn't have any actions.
