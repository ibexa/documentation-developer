---
description: Work with Ibexa Connect scenario block that retrieves and displays data from an Ibexa Connect webhook. 
---

# Ibexa Connect scenario block

Ibexa Connect scenario block retrieves and displays data from an Ibexa Connect webhook. 

Scenario block is regular [Page block](page_blocks.md) and can be configured on field definition level as any other block.

!!! caution
    
    When setting up your instance, ensure you have profiler enabled.
    To set up Page Builder in Ibexa DXP, follow the [Page and Form tutorial](page_and_form_tutorial.md).

## Scenario block configuration

In the following example you will learn how to configure Ibexa Connect scenario block with two available templates: `foo` and `bar`.

### Block templates

First, in `config/packages/ibexa_connect.yaml` add the following configuration:

``` yaml
ibexa_connect:
    scenario_block:
        block_templates:
            foo:
                template: 'blocks/default.html.twig'
            bar:
                label: Bar
                template: 'blocks/default.html.twig'
                parameters:
                    foo: string
                    bar:
                        type: string
                        required: true
```

For each block template you can set up additional settings, for example, label, type or parameters. 

### Define page layouts

To preview your block in the frontend, define page layouts in `config/packages/views.yaml` directory. This file defines, which layouts are used to render Page Builder. 

```yaml
ibexa:
    system:
        site:
            page_layout: pagelayout.html.twig
            user:
                layout: pagelayout.html.twig
```

You also need to create `pagelayout.html.twig` file in `templates` folder:

```html+twig
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sriracha|Roboto|Open+Sans">

    {% if content is defined %}
        {% set title = ez_content_name(content) %}
    {% endif %}
    <title>{{ title|default('Home'|trans) }} - {{ "It's a Dog's World!"|trans }}</title>
</head>
<body>
<div class="container">
    <div class="row main">
        {% block content %}{% endblock %}
    </div>
</div>
</body>
</html>
```

Then, in `templates/block` directory under `default.html.twig`, provide your block configuration:

```html+twig
{{ dump(ibexa_connect_data) }}
```

In the following example, the configuration of the block is very simple - block is only used to display the content transferred from an Ibexa Connect webhook.

At this point the Ibexa Connect scenario block is ready to be used in Page Builder.

### Configure Ibexa Connect scenario block in Page Builder

Now, you can configure Ibexa Connect scenario block in Page Builder.

To do it, in your Page add Ibexa Connect block by dragging it from the menu to a drop zone and enter block settings. 

- In the **Basic** tab in **Webhook link** field, provide a link to an Ibexa Connect webhook, 
for example, `https://ibexa.integromat.celonis.com/3/scenarios/688/edit`:

![Ibexa Connect Basic tab](ibexa_connect_basic_tab.png)

- In the **Design** tab, choose one of declared templates, in the following example, `foo` or `Bar`. 
To do it, extend drop-down list in the **View** field and choose one of the available options.

![Ibexa Connect Design tab](ibexa_connect_design_tab.png)

When everything is configured in the Block settings, click **Submit** button.

After submitting the block, Page will refresh and Ibexa Connect block will display data from provided Ibexa Connect webhook. 

![Ibexa Connect webhook preview](ibexa_connect_webhook_preview.png)