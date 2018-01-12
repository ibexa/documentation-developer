# Injecting parameters in content views

You can dynamically inject variables in content view templates by listening to the `ezpublish.pre_content_view` event.

The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent` object

The following example injects `foo` and `osTypes` variables in all content view templates.

TODO fix example for view not contentView?

``` php
<?php
namespace Acme\ExampleBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;

class PreContentViewListener
{
    public function onPreContentView( PreContentViewEvent $event )
    {
        // Get content view object and inject whatever you need.
        // You may add custom business logic here.
        $contentView = $event->getContentView();
        $contentView->addParameters(
            array(
                 'foo'          => 'bar',
                 'osTypes'      => array( 'osx', 'linux', 'win' )
            )
        );
    }
}
```

Service configuration:

``` yaml
parameters:
    app.pre_content_view_listener.class: Acme\ExampleBundle\EventListener\PreContentViewListener

services:
    app.pre_content_view_listener:
        class: '%ezdemo.pre_content_view_listener.class%'
        tags:
            - {name: kernel.event_listener, event: ezpublish.pre_content_view, method: onPreContentView}
```
