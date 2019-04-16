# Creating block with `richtext` attribute type

Start with creating an `app/config/layouts.yml` file containing:

``` yaml hl_lines="13"
ezplatform_page_fieldtype:
    blocks:
        richtext:
            name: 'My Richtext Block'
            thumbnail: 'assets/images/blocks/richtext.svg'
            views:
                default:
                    template: blocks/richtext/richtext.html.twig
                    name: 'My block view'
                    priority: -255
            attributes:
                name: 'Content'
                type: 'richtext'
                
``` 

This configuration defines a new block, its template and attribute type (line 13).

Remember to provide an icon for the block in the `assets/images/blocks/` folder.

Next, create a subscriber that will convert string of data into XML. 
Create an `AppBundle/Event/Subscriber/RichTextSubscriber.php` file containing:

```php hl_lines="30 38 39 40 41 42 43 44 45 46 47 48"
<?php

declare(strict_types=1);

namespace EzSystems\EzPlatformPageFieldType\Event\Subscriber;

use EzSystems\EzPlatformRichText\eZ\RichText\DOMDocumentFactory;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Twig\TwigRenderRequest;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RichTextBlockSubscriber implements EventSubscriberInterface
{
    /** @var \EzSystems\EzPlatformRichText\eZ\RichText\DOMDocumentFactory */
    private $domDocumentFactory;
    /**
     * @param \EzSystems\EzPlatformRichText\eZ\RichText\DOMDocumentFactory $domDocumentFactory
     */
    public function __construct(DOMDocumentFactory $domDocumentFactory)
    {
        $this->domDocumentFactory = $domDocumentFactory;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('richtext') => 'onBlockPreRender',
        ];
    }
    /**
     * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
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

The line 30 defines the name of the block and implements the `PreRender` method.
The lines 38-48 handle the conversion of content into XML string.

Next, create the template in `blocks/myblock/richtext.html.twig` and add to it the following:

``` html+twig hl_lines="8 9 10"
{% extends '@EzPlatformPageBuilder/page_builder/block/config.html.twig' %}

{% block meta %}
    {{ parent() }}
    <meta name="LanguageCode" content="{{ language_code }}" />
{% endblock %}

<div class="block-richtext {{ block_class }}">
    {{ document | richtext_to_html5 }}
</div>

```

Here, the lines 8-10 are responsible for rendering the content from XML to HTML5.

Complete the procedure with registering the subscriber as a service:

```yml
services:
    AppBundle\Event\Subscriber\RichTextSubscriber
        tags:
            - { name: kernel.event_subscriber }
```

For details on customizing additional options of the block or creating custom blocks with other attribute types, see [extending the Page](/docs/guide/extending_page.md).