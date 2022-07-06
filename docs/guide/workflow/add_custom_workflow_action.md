---
description: Add custom actions that are performed during specific workflow transitions.
---

# Add custom workflow action

Built-in workflow actions enable you to [automatically publish a Content item](workflow.md#content-publishing)
or to [send a notification to reviewers](workflow.md#notifications).

You can also create custom actions that are called when content reaches a specific stage
or goes through a transition in a workflow.

The following example shows how to configure two custom actions that send customized notifications.

## Configure custom action

Configure the first custom action in the following way:

``` yaml hl_lines="15-18"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 0, 5) =]][[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 23, 36) =]]
```

The configuration indicates the name of the custom action (`legal_transition_action`).
`data` contains additional data that is passed to the action. In this case, it is a message to display.

## Create event listener

To define what the action does, create an event listener `src/EventListener/LegalTransitionListener.php`:

``` php hl_lines="27 36"
[[= include_file('code_samples/workflow/custom_workflow/src/EventListener/LegalTransitionListener.php') =]]
```

This listener displays a notification bar at the bottom of the page when a Content item goes through the `to_legal` transition.

The content of the notification is the message configured in `actions.legal_transition_action.data`.
To get it, access the metadata for this transition through `getActionMetadata()` (line 27).

Register the listener as a service (in `config/services.yaml`):

``` yaml
[[= include_file('code_samples/workflow/custom_workflow/config/custom_services.yaml', 0, 4) =]]
```

## Use custom transition value

Line 36 in the listener above sets a custom result value for the transition.
You can use this value in other stages and transitions for this Content item, for example:

``` yaml hl_lines="10 11"
[[= include_file('code_samples/workflow/custom_workflow/config/packages/workflows.yaml', 42, 53) =]]
```

The action indicated here is performed only if the result from the `legal_transition_action` is set to `true`.
Then, the following `src/EventListener/ApprovedTransitionListener` is called:

``` php hl_lines="27"
[[= include_file('code_samples/workflow/custom_workflow/src/EventListener/ApprovedTransitionListener.php') =]]
```

Register this listener as a service:

``` yaml
[[= include_file('code_samples/workflow/custom_workflow/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/workflow/custom_workflow/config/custom_services.yaml', 4, 7) =]]
```

This listener also displays a notification, but in this case its content is taken from the message
that the user types when choosing the `Done` transition.

The message is contained in the context of the action.

`$event->getContext()` (line 27) gives you access to the context.
The context contains:

- `$workflowId` - the ID of the current workflow
- `$message` - content of the user's message when sending the Content item through the transitions
- `$reviewerId` - ID of the user who was selected as a reviewer
- `$result` - an array of transition actions performed so far

You can also modify the context using the `setContext()` method.
For example, you can override the message typed by the user:

``` php
$new_context = $context;
$new_context['message'] = "This article went through proofreading";
$event->setContext($new_context);
```
