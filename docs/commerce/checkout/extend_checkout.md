---
description: Extend checkout workflow
edition: commerce
---

# Extend checkout workflow

Depending on your needs, the [checkout](checkout.md) process can be customized, as it is highly [configurable](configure_checkout.md) and extensible. 

To start, use the default workflow that comes with the storefront module as a basis 
and follow detailed instruction in [Customize checkout](customize_checkout.md).

## Define custom checkout workflow

This example shows how to create custom checkout `new_workflow` and its strategy.
Defined strategy assumes that the checkout process depends on the currency used in the basket.

## Create custom strategy

Create a PHP definition of the new strategy that allows for workflow manipulation.
In this example, custom checkout workflow applies when specific currency code ('EUR') is used in the basket. 

``` php
[[= include_file('code_samples/workflow/strategy/NewWorkflow.php', 0, 25) =]]
```

### Add conditional step

Defining strategy allows to add conditional step for workflow if needed. 
If you add conditional step, the checkout process uses provided workflow and goes to defined step if the condition described in the strategy is met.
By default conditional step is set as null.

To use conditional step you need to pass second argument to constructor in the strategy definition:

``` php hl_lines="18"
[[= include_file('code_samples/workflow/strategy/NewWorkflowConditionalStep.php', 0, 25) =]]
```

### Register strategy

Now, register the strategy as a service:

``` yaml
[[= include_file('code_samples/workflow/services/workflow.yaml', 0, 5) =]]
```

## Override default workflow 

Next, you must inform the application that your repository will use the configured workflow.

!!! note

    The configuration allows to override the default workflow, but it's not mandatory. Checkout supports multiple workflows.

You do it in repository configuration, under the `ibexa.repositories.<repository_name>.checkout.workflow` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    repositories:
        <repository_name>: 
            checkout:
                workflow: new_workflow
```