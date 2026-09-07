---
description: PHP API enables you to get workflow information and apply specific workflow transitions.
---

# Workflow API

You can manage [workflows](workflow.md) with PHP API by using `WorkflowServiceInterface`.

## Workflow service

Workflow uses the Symfony [Workflow Component]([[= symfony_doc =]]/workflow.html),
extended in the workflow service.

The service implements the following methods:

- `start` - places a content item in a workflow
- `apply` - performs a transition
- `can` - checks if a transition is possible

The methods `apply` and `can` are the same as in Symfony Workflow,
but the implementation in workflow service extends them, for example by providing messages.

## Getting workflow information

To get information about a specific workflow for a content item, use `WorkflowServiceInterface::loadWorkflowMetadataForContent`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 52, 56, remove_indent=True) =]]
```

!!! tip

    `marking`, a term from [Symfony Workflow]([[= symfony_doc =]]/workflow.html),
    refers to a state in a workflow.

If you already have a `VersionInfo` object, use `WorkflowServiceInterface::loadWorkflowMetadataForVersionInfo` to avoid loading the full `Content`.
This method is more efficient when iterating over draft versions:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 64, 65, remove_indent=True) =]]
```

To get a list of all workflows that can be used for a given content item, use `WorkflowRegistryInterface::getSupportedWorkflows`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 46, 46, remove_indent=True) =]]
```

## Applying workflow transitions

To place a content item in a workflow, use `WorkflowServiceInterface::start`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 51, 51, remove_indent=True) =]]
```

To apply a transition to a content item, use `Workflow::apply`.
Additionally, you can check if the transition is possible for the given object by using `WorkflowServiceInterface::can`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 58, 62, remove_indent=True) =]]
```

!!! tip

    `Ibexa\Workflow\Value\WorkflowMetadata` object contains all 
    information about a workflow, such as ID, name, transitions and current stage.
    `Ibexa\Workflow\Value\WorkflowMetadata::$workflow` gives you direct 
    access to native Symfony Workflow object.
