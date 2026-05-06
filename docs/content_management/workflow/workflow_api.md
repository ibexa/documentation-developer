---
description: PHP API enables you to get workflow information and apply specific workflow transitions.
---

# Workflow API

You can manage [workflows](workflow.md) with PHP API by using [`WorkflowServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Service-WorkflowServiceInterface.html).

## Workflow service

Workflow uses the Symfony [Workflow Component]([[= symfony_doc =]]/components/workflow.html),
extended in the workflow service.

The service implements the following methods:

- `start` - places a content item in a workflow
- `apply` - performs a transition
- `can` - checks if a transition is possible

The methods `apply` and `can` are the same as in Symfony Workflow,
but the implementation in workflow service extends them, for example by providing messages.

## Getting workflow information

To get information about a specific workflow for a content item, use [`WorkflowServiceInterface::loadWorkflowMetadataForContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Service-WorkflowServiceInterface.html#method_loadWorkflowMetadataForContent):

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 54, 58) =]]
```

!!! tip

    `marking`, a term from [Symfony Workflow]([[= symfony_doc =]]/components/workflow.html),
    refers to a state in a workflow.

If you already have a [`VersionInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-VersionInfo.html) object, 
use [`WorkflowServiceInterface::loadWorkflowMetadataForVersionInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Service-WorkflowServiceInterface.html#method_loadWorkflowMetadataForVersionInfo) to avoid loading the full [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html),
This method is more efficient when iterating over draft versions:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 65, 67) =]]
```

To get a list of all workflows that can be used for a given content item, use [`WorkflowRegistryInterface::getSupportedWorkflows`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Registry-WorkflowRegistryInterface.html#method_getSupportedWorkflows):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 47, 48) =]]
```

## Applying workflow transitions

To place a content item in a workflow, use [`WorkflowServiceInterface::start`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Service-WorkflowServiceInterface.html#method_start):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 52, 53) =]]
```

To apply a transition to a content item, use `Workflow::apply`.
Additionally, you can check if the transition is possible for the given object using [`WorkflowServiceInterface::can`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Workflow-Service-WorkflowServiceInterface.html#method_can):

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 60, 62, remove_indent=True) =]]    
}
```

!!! tip

    `Ibexa\Workflow\Value\WorkflowMetadata` object contains all 
    information about a workflow, such as ID, name, transitions and current stage.
    `Ibexa\Workflow\Value\WorkflowMetadata::$workflow` gives you direct 
    access to native Symfony Workflow object.
