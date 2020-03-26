# Using RouteReference

Sometimes, when generating links to a resource, you need to modify the default router's behavior.

Example use cases are:

- [Language switch links](../guide/internationalization.md#language-switcher)
- Download links
- Passing a Content item instead of a Location (and using its `mainLocationId`)

`RouteReference` represents a route (to a Location object, a declared route, etc.) with its parameters and can be passed to the `Router` for generating a link.
`RouteReference` works like [Symfony's `ControllerReference`](http://api.symfony.com/4.3/Symfony/Component/HttpKernel/Controller/ControllerReference.html) for sub-requests.

The advantage of a `RouteReference` is that its parameters can be modified later,
and then passed to the router (e.g. to generate a link to the same location in several different languages).

Furthermore, the `RouteReference` generation process can be extended to fit specific needs.

## Twig

Prototype:

``` html+twig
ez_route( [routing_resource[, parameters_hash]] )
```

- `routing_resource` can be any valid resource (route name, Location object, etc.).
If omitted (`null`), the current route will be taken into account.
- `parameters_hash` is a hash with arbitrary key/values. It will be passed to the router in the end

Minimal usage is pretty straightforward:

``` html+twig
{# With a declared route. #}
{% set routeRef = ez_route( "my_route" ) %}

{# With a Location, given that the "location" variable is a valid Location object. #}
{% set routeRef = ez_route( location ) %}

{# Then pass the routeRef variable to ez_path() to generate the link #}
<a href="{{ ez_path( routeRef ) }}">My link</a>
```

Passing parameters and playing with the RouteReference:

``` html+twig
{% set routeRef = ez_route( "my_route", {"some": "thing"} ) %}

{# You can then add parameters further on #}
{% do routeRef.set( "foo", ["bar", "baz"] ) %}

{# Or even modify the route resource itself #}
{% do routeRef.setRoute( "another_route" ) %}

<a href="{{ ez_path( routeRef ) }}">My link</a>
```

## PHP

You can generate links based on a `RouteReference` from PHP too, with the `RouteReferenceGenerator` service.

Assuming you're in a controller:

``` php
/** @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator\RouteReferenceGeneratorInterface $routeRefGenerator */
$routeRefGenerator = $this->get( 'ezpublish.route_reference.generator' );
$routeRef = $routeRefGenerator->generate( 'my_route', [ 'some' => 'thing' ]);
$routeRef->set( 'foo', [ 'bar', 'baz' ] );
$routeRef->setRoute( 'another_route' );

$link = $this->generateUrl($routeRef);
```

## Extending the RouteReference generation process

When generating the route reference, the `RouteReferenceGenerator` service sends the `MVCEvents::ROUTE_REFERENCE_GENERATION` (`ezpublish.routing.reference_generation`) event.
This event can be listened to in order to modify the final route reference
(adding/changing parameters, changing the route name, etc.).

All listeners receive the `eZ\Publish\Core\MVC\Symfony\Event\RouteReferenceGenerationEvent` object,
which contains the current request object and the route reference.

``` php
<?php

namespace App\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\RouteReferenceGenerationEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyRouteReferenceListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            MVCEvents::ROUTE_REFERENCE_GENERATION => 'onRouteReferenceGeneration'
        ];
    }

    public function onRouteReferenceGeneration(RouteReferenceGenerationEvent $event)
    {
        $routeReference = $event->getRouteReference();
        $request = $event->getRequest();

        // Let's say you want to change the route name if "some_parameter" param is present
        if ( $routeReference->has( 'some_parameter' ) )
        {
            $routeReference->setRoute( 'a_specific_route' );
            // Remove "some_parameter", as you don't need it any more
            $routeReference->remove( 'some_parameter' );
            // Add another parameter
            $routeReference->set( 'another_parameter', [ 'parameters', 'are', 'fun' ] );
        }
    }
}
```

Service declaration (in `config/services.yaml`):

``` yaml
services:
    App\EventListener\MyRouteReferenceListener:
        tags:
            - { name: kernel.event_subscriber }
```

!!! tip "Example"

    A real-life implementation example on RouteReference is the [LanguageSwitcher](internationalization.md#language-switcher) (`eZ\Publish\Core\MVC\Symfony\EventListener\LanguageSwitchListener`).
