---
description: Work with Ibexa Connect scenario block that retrieves and displays data from an Ibexa Connect webhook. 
---

# Ibexa Connect scenario block

Ibexa Connect scenario block retrieves and displays data from an Ibexa Connect webhook. 
Scenario block is a regular [Page block](page_blocks.md) and can be configured on field definition level as any other block.

!!! caution
    
    When setting up your instance, ensure you have profiler enabled.
    To set up Page Builder in Ibexa DXP, follow the [Page and Form tutorial](page_and_form_tutorial.md).

## Scenario block configuration

In the following example you can learn how to configure Ibexa Connect scenario block with two available templates: `company_customers` and `external_clients`.

### Block templates

First, in `config/packages/ibexa_connect.yaml` add the following configuration:

``` yaml
[[= include_file('code_samples/page/ibexa_connect_scenario_block/config/packages/ibexa_connect.yaml') =]]
```

For each block template you can set up additional settings, for example, label, type or parameters. 

### Define page layouts

To preview your block in the frontend, define page layouts in `config/packages/views.yaml` directory. This file defines, which layouts are used to render Page Builder. 

```yaml
[[= include_file('code_samples/page/ibexa_connect_scenario_block/config/packages/views.yaml') =]]
```

You also need to create `pagelayout.html.twig` file in `templates` folder:

```html+twig
[[= include_file('code_samples/page/ibexa_connect_scenario_block/templates/pagelayout.html.twig') =]]
```

Then, in `templates/block` directory under `default.html.twig`, provide your block configuration:

```html+twig
[[= include_file('code_samples/page/ibexa_connect_scenario_block/templates/block/default.html.twig') =]]
```

In the following example, the configuration of the block is non-complex - block is only used to display the content transferred from an Ibexa Connect webhook.
At this point the Ibexa Connect scenario block is ready to be used in Page Builder.

### Configure Ibexa Connect scenario block in Page Builder

Now, you can configure Ibexa Connect scenario block in Page Builder.
To do it, in your Page add Ibexa Connect block by dragging it from the menu to a drop zone and enter block settings. 

- In the **Basic** tab in **Webhook link** field, provide a link to an Ibexa Connect webhook, 
for example, `https://connect.ibexa.co/3/scenarios/688/edit`:

![Ibexa Connect Basic tab](ibexa_connect_basic_tab.png)

- In the **Design** tab, choose one of declared templates, in the following example, `company_customers` or `External clients`. 
To do it, extend drop-down list in the **View** field and choose one of the available options.

![Ibexa Connect Design tab](ibexa_connect_design_tab.png)

Click **Submit** button to confirm.
After submitting the block, Page refreshes and Ibexa Connect block displays data from provided Ibexa Connect webhook. 

![Ibexa Connect webhook preview](ibexa_connect_webhook_preview.png)