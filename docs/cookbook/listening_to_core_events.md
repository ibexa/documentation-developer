# Listening to Core events

When you interact with the Public API, and with the content repository in particular, **Signals** may be sent out,
allowing you to react to actions triggered by the repository.
Those signals can be received by dedicated services called **Slots**.

This recipe will describe how to register a Slot for a dedicated Signal.

## Registering a Slot for a given Signal

As described in the [SignalSlot documentation](../guide/signalslots.md),
a Slot is the eZ Platform equivalent of a Symfony event listener and must extend `eZ\Publish\Core\SignalSlot\Slot`.

A typical implementation is the following:

``` php
namespace Acme\ExampleBundle\Slot;
 
use eZ\Publish\Core\SignalSlot\Slot as BaseSlot;
use eZ\Publish\Core\SignalSlot\Signal;
use eZ\Publish\API\Repository\ContentService;

class OnPublishSlot extends BaseSlot
{
    /**
     * @var \eZ\Publish\API\Repository\ContentService
     */
    private $contentService;

    public function __construct( ContentService $contentService )
    {
        $this->contentService = $contentService;
    }

    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\ContentService\PublishVersionSignal )
        {
            return;
        }

        // Load published content
        $content = $this->contentService->loadContent( $signal->contentId, null, $signal->versionNo );
        // Do stuff with it...
    }
}
```

You now need to register `OnPublishSlot` as a service in the ServiceContainer and identify it as a valid Slot.

In `services.yml` (in your bundle):

``` yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true
        public: false
 
    Acme\ExampleBundle\Slot\OnPublishSlot:
        tags:
            - { name: ezpublish.api.slot, signal: ContentService\PublishVersionSignal }
```

Service tag `ezpublish.api.slot` identifies your service as a valid Slot.
The signal part (mandatory) says that this Slot is listening to `ContentService\PublishVersionSignal`
(shortcut for `\eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`).

!!! note

    Internal signals emitted by Repository services are always relative to `eZ\Publish\Core\SignalSlot\Signal` namespace.

    Hence `ContentService\PublishVersionSignal` means `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`.

!!! tip

    You can register a Slot for any kind of signal by setting `signal` to `*` in the service tag.

## Using a basic Symfony event listener

eZ Platform comes with a generic Slot that converts signals (including ones defined by user code)
to regular event objects and exposes them via the EventDispatcher.
This makes it possible to implement a simple event listener/subscriber if you're more comfortable with this approach.

All you need to do is to implement an event listener or subscriber and register it.

## Example

This very simple example will just log the received signal.

In `services.yml` (in your bundle):

``` yaml 
services:
    _defaults:
        autowire: true
        autoconfigure: true
        public: false

    Acme\ExampleBundle\EventListener\SignalListener: ~
```

``` php
<?php
namespace Acme\ExampleBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\SignalEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SignalListener implements EventSubscriberInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct( LoggerInterface $logger )
    {
        $this->logger = $logger;
    }

    public function onAPISignal( SignalEvent $event )
    {
        $signal = $event->getSignal();
        // You may want to check the signal type here to react accordingly
        $this->logger->debug( 'Received Signal: ' . print_r( $signal, true ) );
    }

    public static function getSubscribedEvents()
    {
        return [
            MVCEvents::API_SIGNAL => 'onAPISignal'
        ];
    }
}
```
