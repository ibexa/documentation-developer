# Ibexa Connect scenario block

Work with Ibexa Connect scenario block that retrieves and displays data from an Ibexa Connect webhook.

Editions: Experience

Ibexa Connect scenario block retrieves and displays data from an Ibexa Connect webhook. Scenario block is a regular [Page block](../page_blocks/index.md) and can be configured on field definition level as any other block.

> **Caution: Caution**
>
> When setting up your instance, ensure you have profiler enabled. To set up Page Builder in Ibexa DXP, follow the [Page and Form tutorial](../../../tutorials/page_and_form_tutorial/page_and_form_tutorial/index.md).

## Scenario block configuration

In the following example you can learn how to configure Ibexa Connect scenario block with two available templates: `company_customers` and `external_clients`.

### Block templates

First, in `config/packages/ibexa_connect.yaml` add the following configuration:

```yaml
ibexa_connect:
    scenario_block:
        block_templates:
            company_customers:
                template: 'blocks/default.html.twig'
            external_clients:
                label: External clients
                template: 'blocks/default.html.twig'
                parameters:
                    external_client_id: string
                    external_client_name:
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

Then, in `templates/blocks` directory under `default.html.twig`, provide your block configuration:

```html+twig
{{ dump(ibexa_connect_data) }}
```

In the following example, the configuration of the block is non-complex - block is only used to display the content transferred from an Ibexa Connect webhook. At this point the Ibexa Connect scenario block is ready to be used in Page Builder.

### Configure Ibexa Connect scenario block in Page Builder

Now, you can configure Ibexa Connect scenario block in Page Builder. To do it, in your Page add Ibexa Connect block by dragging it from the menu to a drop zone and enter block settings.

- In the **Basic** tab in **Webhook link** field, provide a link to an Ibexa Connect webhook, for example, `https://connect.ibexa.co/3/scenarios/688/edit`:

![Ibexa Connect Basic tab](https://doc.ibexa.co/en/5.0/content_management/img/ibexa_connect_basic_tab.png)

- In the **Design** tab, choose one of declared templates, in the following example, `company_customers` or `External clients`. To do it, extend drop-down list in the **View** field and choose one of the available options.

![Ibexa Connect Design tab](https://doc.ibexa.co/en/5.0/content_management/img/ibexa_connect_design_tab.png)

Click **Submit** button to confirm. After submitting the block, page refreshes and Ibexa Connect block displays data from provided Ibexa Connect webhook.

![Ibexa Connect webhook preview](https://doc.ibexa.co/en/5.0/content_management/img/ibexa_connect_webhook_preview.png)
