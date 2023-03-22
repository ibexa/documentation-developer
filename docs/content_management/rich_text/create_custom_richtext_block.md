---
description: Create a custom Page block containing rich text.
edition: experience
---

# Create custom RichText block

A RichText block is a specific example of a [custom block](create_custom_page_block.md) that you can use when 
you create a Page. 
To create a custom block, you must define the block's layout, provide templates, add a subscriber 
and register the subscriber as a service.

Follow the procedure below to create a RichText Page block.

First, provide the block configuration in `config/packages/ibexa_page_fieldtype.yaml`. 
The following code defines a new block, its view and configuration 
templates.
It also sets the attribute type to `richtext` (line 15):

``` yaml hl_lines="3 15"
[[= include_file('code_samples/back_office/online_editor/config/packages/ibexa_page_fieldtype.yaml') =]]
```

!!! note

    Make sure that you provide an icon for the block in the `assets/images/blocks/` folder.

Then, create a subscriber that converts a string of data into XML code.
Create a `src/Event/Subscriber/RichTextBlockSubscriber.php` file.

In line 32, `my_block` is the same name of the block that you defined in line 3 
of the `ibexa_page_fieldtype.yaml` file above.
Line 32 also implements the `PreRender` method.
Lines 41-51 handle the conversion of content into an XML string:


``` php hl_lines="32 41 42 43 44 45 46 47 48 49 50 51"
[[= include_file('code_samples/back_office/online_editor/src/event/subscriber/RichTextBlockSubscriber.php') =]]
```

Now you can create [templates](templates.md) that are used 
for displaying and configuring your block.

Create the view template in `templates/blocks/my_block/richtext.html.twig`.
Line 2 is responsible for rendering the content from XML to HTML5:

``` html+twig hl_lines="2"
<div class="block-richtext {{ block_class }}">
            {{ document | ibexa_richtext_to_html5 }}
</div>
```

Then, create a separate `templates/blocks/my_block/config.html.twig` template:

``` html+twig
{% extends '@IbexaPageBuilder/page_builder/block/config.html.twig' %}

{% block meta %}
    {{ parent() }}
    <meta name="LanguageCode" content="{{ language_code }}" />
{% endblock %}
```

Finally, register the subscriber as a service in `config/services.yaml`:

``` yaml
services:
    App\Event\Subscriber\RichTextBlockSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```


You have successfully created a custom RichText block. 
You can now add your block in the Site tab.

![RichText block](extending_richtext_block.png)

For more information about customizing additional options of the block or creating 
custom blocks with other attribute types, see [Create custom Page block](create_custom_page_block.md).
