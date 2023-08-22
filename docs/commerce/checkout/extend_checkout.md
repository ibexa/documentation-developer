---
description: Extend checkout workflow
edition: commerce
---

# Extend checkout workflow

Depending on your needs, the [checkout](checkout.md) process can be customized, as it is highly configurable and extensible. 
You can create [workflow](workflow.md) definitions under the `framework.workflows` [configuration key](configuration.md#configuration-files). 

To start, use the default workflow that comes with the storefront module as a basis 
and follow detailed instruction in [Customize checkout](customize_checkout.md).

# Define custom checkout workflow

This example shows how to create custom checkout `new_workflow` and its strategy.
Defined strategy assumes that the checkout process depends on the currency used in the basket.

# Create custom strategy

Create a PHP definition of the new strategy that allows for workflow manipulation.
In this example, custom checkout workflow applies when specific currency code ('EUR') is used in the basket. 

``` php
[[= include_file('code_samples/workflow/strategy/NewWorkflow.php', 0, 25) =]]
```

## Register strategy

Now, register the strategy as a service:

``` yaml
[[= include_file('code_samples/workflow/services/workflow.yaml', 0, 5) =]]
```

## Overwrite default workflow 

Now, you must inform the application that your repository will use the configured workflow.

You do it in repository configuration, under the `ibexa.repositories.<repository_name>.checkout.workflow` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    repositories:
        default: 
            checkout:
                workflow: new_workflow
```
