# Injecting parameters in content views

## Description

It is possible to dynamically inject variables in content view templates by listening to the `ezpublish.pre_content_view` event.

The event listener method receives an` eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent `object

## Example

The following example will inject `foo` and `osTypes` variables in all content view templates.

``` php
<?php

namespace Acme\DemoBundle\EventListener;
use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;

class PreContentViewListener
{
    public function onPreContentView( PreContentViewEvent $event )
    {
        // Get content view object and inject whatever no need.
        // You may add some custom business logic here.
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

``` yaml
# Service configuration
parameters:
    ezdemo.pre_content_view_listener.class: Acme\DemoBundle\EventListener\PreContentViewListener

services:
    ezdemo.pre_content_view_listener:
        class: %ezdemo.pre_content_view_listener.class%
        tags:
            - {name: kernel.event_listener, event: ezpublish.pre_content_view, method: onPreContentView}
```
