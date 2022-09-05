---
description: PHP API enables you to get workflow information and apply specific workflow transitions.
---

# Workflow API

You can manage [workflows](workflow.md) with PHP API by using `WorkflowServiceInterface`.

## Getting workflow information

To get information about a specific workflow for a Content item, use `WorkflowServiceInterface::loadWorkflowMetadataForContent`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 53, 57) =]]
```

!!! tip

    `marking`, a term from [Symfony Workflow,]([[= symfony_doc =]]/components/workflow.html)
    refers to a state in a workflow.

To get a list of all workflows that can be used for a given Content item, use `WorkflowRegistry`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 47, 48) =]]
```

## Applying workflow transitions

To place a Content item in a workflow, use `WorkflowService::start`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 52, 53) =]]
```

To apply a transition to a Content item, use `Workflow::apply`.
Additionally, you can check if the transition is possible for the given object using `WorkflowService::can`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 59, 62) =]]    }
```

!!! tip

    `Ibexa\Workflow\Value\WorkflowMetadata` object contains all 
    information about a workflow, such as ID, name, transitions and current stage.
    `Ibexa\Workflow\Value\WorkflowMetadata::$workflow` gives you direct 
    access to native Symfony Workflow object.
