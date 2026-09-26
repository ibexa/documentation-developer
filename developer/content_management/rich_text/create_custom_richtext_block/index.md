# Create custom RichText block

Create a custom Page block containing rich text.

Editions: Experience

A RichText block is a specific example of a [custom block](../../pages/create_custom_page_block/index.md) that you can use when you create a page. To create a custom block, you must define the block's layout, provide templates, add a subscriber, and register the subscriber as a service.

Follow the procedure below to create a RichText page block.

First, provide the block configuration under the `ibexa_page_fieldtype.blocks` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files). The following code defines a new block, its view and configuration templates. It also sets the attribute type to `richtext` (line 15):

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name: My Richtext Block
            thumbnail: assets/images/blocks/richtext_block_icon.svg
            configuration_template: '@ibexadesign/blocks/my_block/config.html.twig'
            views:
                default:
                    template: '@ibexadesign/blocks/my_block/default.html.twig'
                    name: My block view
                    priority: -255                    
            attributes:
                content:
                    name: Content
                    type: richtext
```

> **Note: Note**
>
> Make sure that you provide an icon for the block in the `assets/images/blocks/` folder.

Then, create a subscriber that converts a string of data into XML code. Create a `src/Event/Subscriber/RichTextBlockSubscriber.php` file.

In line 28, `my_block` is the same name of the block that you defined in line 3 above. Line 28 links this block `PreRenderEvent` to a method using `BlockRenderEvents::getBlockPreRenderEventName()`. Lines 37-47 handle the conversion of content into an XML string:

```php
<?php

declare(strict_types=1);

namespace App\Event\Subscriber;

use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Twig\TwigRenderRequest;
use Ibexa\FieldTypeRichText\RichText\DOMDocumentFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RichTextBlockSubscriber implements EventSubscriberInterface
{
    /**
     * @param \Ibexa\FieldTypeRichText\RichText\DOMDocumentFactory $domDocumentFactory
     */
    public function __construct(private readonly DOMDocumentFactory $domDocumentFactory)
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('my_block') => 'onBlockPreRender',
        ];
    }

    /**
     * @param \Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
     */
    public function onBlockPreRender(PreRenderEvent $event): void
    {
        $renderRequest = $event->getRenderRequest();
        if (!$renderRequest instanceof TwigRenderRequest) {
            return;
        }
        $parameters = $renderRequest->getParameters();
        $parameters['document'] = null;
        $xml = $event->getBlockValue()->getAttribute('content')->getValue();
        if (!empty($xml)) {
            $parameters['document'] = $this->domDocumentFactory->loadXMLString($xml);
        }
        $renderRequest->setParameters($parameters);
    }
}
```

Now you can create [templates](../../../templating/templates/templates/index.md) that are used for displaying and configuring your block.

Create the view template in `templates/themes/<your-theme>/blocks/my_block/richtext.html.twig`. Line 2 is responsible for rendering the content from XML to HTML5:

```html+twig
<div class="block-richtext {{ block_class }}">
            {{ document | ibexa_richtext_to_html5 }}
</div>
```

Then, create a separate `templates/themes/admin/blocks/my_block/config.html.twig` template:

```html+twig
{% extends '@IbexaPageBuilder/page_builder/block/config.html.twig' %}

{% block meta %}
    {{ parent() }}
    <meta name="LanguageCode" content="{{ language_code }}" />
{% endblock %}
```

Finally, register the subscriber as a service in `config/services.yaml`:

```yaml
services:
    App\Event\Subscriber\RichTextBlockSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```

You have successfully created a custom RichText block. You can now add your block in the **Site** tab.

![RichText block](https://doc.ibexa.co/en/5.0/content_management/img/extending_richtext_block.png)

For more information about customizing additional options of the block or creating custom blocks with other attribute types, see [Create custom Page block](../../pages/create_custom_page_block/index.md).
