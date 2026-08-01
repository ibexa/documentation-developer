# Workflow API

PHP API enables you to get workflow information and apply specific workflow transitions.

You can manage [workflows](../workflow/index.md) with PHP API by using [`Ibexa\Contracts\Workflow\Service\WorkflowServiceInterface`](../../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php).

## Workflow service

Workflow uses the Symfony [Workflow Component](https://symfony.com/doc/7.4/components/workflow.html), extended in the workflow service.

The service implements the following methods:

- `start` - places a content item in a workflow
- `apply` - performs a transition
- `can` - checks if a transition is possible

The methods `apply` and `can` are the same as in Symfony Workflow, but the implementation in workflow service extends them, for example by providing messages.

## Getting workflow information

To get information about a specific workflow for a content item, use [`WorkflowServiceInterface::loadWorkflowMetadataForContent`](../../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php):

```php
$workflowMetadata = $this->workflowService->loadWorkflowMetadataForContent($content, $workflowName);

foreach ($workflowMetadata->markings as $marking) {
    $output->writeln($content->getName() . ' is in stage ' . $marking->name . ' in workflow ' . $workflowMetadata->workflow->getName());
}
```

> **Tip: Tip**
>
> `marking`, a term from [Symfony Workflow](https://symfony.com/doc/7.4/components/workflow.html), refers to a state in a workflow.

If you already have a [`Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/VersionInfo.php) object, use [`WorkflowServiceInterface::loadWorkflowMetadataForVersionInfo`](../../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php) to avoid loading the full [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php). This method is more efficient when iterating over draft versions:

```php
$versionInfo = $content->getVersionInfo();
$workflowMetadataByVersion = $this->workflowService->loadWorkflowMetadataForVersionInfo($versionInfo, $workflowName);
```

To get a list of all workflows that can be used for a given content item, use [`WorkflowRegistryInterface::getSupportedWorkflows`](../../../../../../ibexa/workflow/src/contracts/Registry/WorkflowRegistryInterface.php):

```php
$supportedWorkflows = $this->workflowRegistry->getSupportedWorkflows($content);
```

## Applying workflow transitions

To place a content item in a workflow, use [`WorkflowServiceInterface::start`](../../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php):

```php
$this->workflowService->start($content, $workflowName);
```

To apply a transition to a content item, use `Workflow::apply`. Additionally, you can check if the transition is possible for the given object by using [`WorkflowServiceInterface::can`](../../../../../../ibexa/workflow/src/contracts/Service/WorkflowServiceInterface.php):

```php
if ($this->workflowService->can($workflowMetadata, $transitionName)) {
    $workflow = $this->workflowRegistry->getWorkflow($workflowName);
    $workflow->apply($workflowMetadata->content, $transitionName, ['message' => 'done', 'reviewerId' => 14]);
    $output->writeln('Moved ' . $content->getName() . ' through transition ' . $transitionName);
}
```

> **Tip: Tip**
>
> `Ibexa\Workflow\Value\WorkflowMetadata` object contains all information about a workflow, such as ID, name, transitions and current stage. `Ibexa\Workflow\Value\WorkflowMetadata::$workflow` gives you direct access to native Symfony Workflow object.
