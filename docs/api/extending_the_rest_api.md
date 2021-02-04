# Extending the REST API

The [[= product_name =]] REST API comes with a framework that makes it easy to extend the API for your own needs.

## Requirements

REST routes are required to use the [[= product_name =]] REST API prefix, `/api/ezp/v2`. You can create new resources below this prefix.

To do so, you will/may need to create:

-   a controller that will handle your route actions
-   a route, in your bundle's routing file
-   a controller action
-   optionally, a `ValueObjectVisitor` (if your controller returns an object that doesn't already have a converter)
-   optionally, an `InputParser`

### Controller

To create a REST controller, you need to extend the `ezpublish_rest.controller.base` service, as well as the `EzSystems\EzPlatformRest\Server\Controller` class.

First create a simple controller that has a `sayHello()` method which takes a name as an argument.

**src/Rest/Controller/DefaultController.php**

``` php
namespace App\Rest\Controller;

use EzSystems\EzPlatformRest\Server\Controller as BaseController;

class DefaultController extends BaseController
{
    public function sayHello(string $name)
    {
        // @todo Implement me
    }
}
```

### Route

As mentioned earlier, your REST routes are required to use the REST URI prefix. To do so, the easiest way is to import your routing file using this prefix.

**config/routes.yaml**

``` yaml
my_rest_routes:
    resource: routing_rest.yaml
    prefix: '%ezpublish_rest.path_prefix%'
```

Using a distinct file for REST routes allows you to use the prefix for all this file's routes without affecting other routes from your bundle.

Next, you need to create the REST route. Define the route's [controller as a service](http://symfony.com/doc/5.0/cookbook/controller/service.html) since your controller was defined as such.

**config/routes_rest.yaml**

``` yaml
my_rest_hello_world:
    path: '/my_rest_bundle/hello/{name}'
    defaults:
        _controller: App\Rest\Controller\DefaultController::sayHello
    methods: [GET]
```

Due to [EZP-23016](https://jira.ez.no/browse/EZP-23016) - Custom REST API routes (v2) are not accessible from the legacy backend, custom REST routes must be prefixed with `ezpublish_rest_`, or they won't be detected correctly.

**config/services.yaml**

``` yaml
services:
    App\Controller\Rest\DefaultController:
        parent: ezpublish_rest.controller.base
        tags: ['controller.service_arguments']
```

## Controller action

Unlike standard Symfony controllers, the REST ones don't return an `HttpFoundation\Response` object, but a `ValueObject`. This object will during the kernel run be converted, using a `ValueObjectVisitor`, to a proper Symfony response. One benefit is that when multiple controllers return the same object, such as a Content item or a Location, the visitor will be re-used.

Let's say that your controller will return a `App\Rest\Values\Hello`

**src/Rest/Values/Hello.php**

``` php
namespace App\Rest\Values;

class Hello
{
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
```

An instance of this class will be returned from `sayHello()` controller method.

**src/Rest/Controller/DefaultController.php**

``` php
namespace App\Controller\Rest;

use EzSystems\EzPlatformRest\Server\Controller as BaseController;
use App\Rest\Values\Hello as HelloValue;

class DefaultController extends BaseController
{
    public function sayHello($name): HelloValue
    {
        return new HelloValue($name);
    }
}
```

Outputting this object in the response requires that you create a `ValueObjectVisitor`.

## ValueObjectVisitor

A `ValueObjectVisitor` will take a Value returned by a REST controller, whatever the class, and will transform it into data that can be converted, either to JSON or XML format. Those visitors are registered as services, and tagged with `ezpublish_rest.output.value_object_visitor`. The tag attribute says which class this visitor applies to.

Create the service for your `ValueObjectVisitor` first.

**config/services.yaml**

``` yaml
services:
    App\Rest\ValueObjectVisitor\Hello:
        parent: ezpublish_rest.output.value_object_visitor.base
        tags:
            - { name: ezpublish_rest.output.value_object_visitor, type: App\Rest\Values\Hello }
```

Create your visitor next. It must extend the  `EzSystems\EzPlatformRest\Output\ValueObjectVisitor` abstract class, and implement the `visit()` method.
It will receive as arguments:

|Argument|Description|
|--------|-----------|
|`$visitor`| The output visitor. Can be used to set custom response headers ( `setHeader( $name, $value )`), HTTP status code ( `setStatus( $statusCode )` )|
|`$generator`| The actual response generator. It provides you with a DOM like API.|
|`$data`| The visited data. The exact object you returned from the controller|

**src/Rest/ValueObjectVisitor/Hello.php**

``` php
namespace App\Rest\ValueObjectVisitor;

use EzSystems\EzPlatformRest\Output\ValueObjectVisitor;
use EzSystems\EzPlatformRest\Output\Generator;
use EzSystems\EzPlatformRest\Output\Visitor;

class Hello extends ValueObjectVisitor
{
    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('contentList');

        $generator->startValueElement('Hello', $data->name);
        $generator->endValueElement('Hello');

        $generator->endObjectElement('contentList');
        $visitor->setStatus(200); // default
    }
}
```

The easiest way to handle cache is to re-use the `CachedValue` value object. It acts as a proxy, and adds the cache headers, depending on the configuration, for a given object and set of options.

When you want the response to be cached, return an instance of `CachedValue`, with your Value Object as the argument. You can also pass a Location ID using the second argument, so that the response is tagged with it:

```
use EzSystems\EzPlatformRest\Server\Values\CachedValue;
//...
    public function sayHello(string $name)
    {
        return new CachedValue(
            new HelloValue($name),
            ['locationId'=> 42]
        );

    }

```

Below you can find the corresponding response header when using Varnish as reverse proxy:

```
Age →30
Cache-Control →private, no-cache
Via →1.1 varnish-v4
X-Cache →HIT
X-Cache-Hits →2
```

## Input parser

If you need to provide your controller with parameters, either in JSON or XML, the parameter struct requires an input parser so that the payload can be converted to an actual `ValueObject`.

Each payload is dispatched to its input parser based on the request's Content-Type header. For example, a request with a Content-Type of `application/vnd.ez.api.ContentCreate` will be parsed by `EzSystems\EzPlatformRest\Server\Input\Parser`. This parser will build and return a `ContentCreateStruct` that can then be used to create content with the Public API.

Those input parsers are provided with a pre-parsed version of the input payload, as an associative array, and don't have to care about the actual format (XML or JSON).

Let's see what it would look like with a Content-Type of `application/vnd.my.Greetings`, that would send this as XML:

**application/vnd.my.Greetings+xml**

``` xml
<?xml version="1.0" encoding="utf-8"?>
<Greetings>
    <name>John doe</name>
</Greetings>
```

First, you need to create a service with the appropriate tag in `services.yaml`.

**config/services.yaml**

``` yaml
services:
    App\Rest\InputParser\Greeting:
        parent: ezpublish_rest.input.parser
        tags:
            - { name: ezpublish_rest.input.parser, mediaType: application/vnd.my.Greetings }
```

The mediaType attribute of the `ezpublish\_rest.input.parser` tag maps our Content Type to the input parser.

Implement your parser. It must extend `EzSystems\EzPlatformRest\Server\Input\Parser`, and implement the `parse()` method. It accepts as an argument the input payload, `$data`, as an array, and an instance of `ParsingDispatcher` that can be used to forward parsing of embedded content.

For convenience, consider that your input parser returns an instance of `Value\Hello` class.

**src/Rest/InputParser/Greetings.php**

``` php
namespace App\Rest\InputParser;

use EzSystems\EzPlatformRest\Input\BaseParser;
use EzSystems\EzPlatformRest\Input\ParsingDispatcher;
use App\Rest\Value\Hello;
use EzSystems\EzPlatformRest\Exceptions;

class Greetings extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
        // re-using the REST exceptions will make sure that those already have a ValueObjectVisitor
        if (!isset($data['name'])) {
            throw new Exceptions\Parser("Missing or invalid 'name' element for Greetings.");
        }

        return new Hello($data['name']);
    }
}
```

You should then add a new method to the previous `DefaultController` to handle the new POST request:

```
use EzSystems\EzPlatformRest\Message;
//...
    public function sayHelloUsingPost()
    {
        $createStruct = $this->inputDispatcher->parse(
            new Message(
              ['Content-Type' => $request->headers->get('Content-Type')],
              $request->getContent()
            )
        );

        $name = $createStruct->name;
        //...
    }
```

The `inputDispatcher` is responsible for matching the `Content-Type` sent in the header with the Greetings `InputParser` class.

Finally, a new Route should be added to `routing_rest.yaml`

``` yaml
my_rest_hello_world_using_post:
    path: /my_rest_bundle/hello/
    defaults:
        _controller: App\Rest\Controller\DefaultController::sayHelloUsingPostAction
    methods: [POST]
```

!!! note

    POST requests are not able to access the Repository without performing a user authentication. For more information check [REST API Authentication](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta5/doc/specifications/rest/REST-API-V2.rst#authentication).

You can look into the built-in `InputParsers`, in `eZ/Publish/Core/REST/Server/Input/Parser`, for more examples.

## Registering resources in the REST root

You can register newly added resources so that they show up in the REST root resource for automatic discovery.

New resources can be registered with code like this:

``` yaml
ez_publish_rest:
    system:
        <siteaccess>:
            rest_root_resources:
                someresource:
                    mediaType: Content
                    href: 'router.generate("ezpublish_rest_loadContent", {"contentId": 2})'
```

with `someresource` being a unique key.

The `router.generate` call dynamically renders a URI based on the name of the route and the optional parameters that are passed as the other arguments (in the code above this is the `contentId`).

This syntax is based on [Symfony's expression language](http://symfony.com/doc/5.0/components/expression_language/index.html), an extensible component that allows limited/readable scripting to be used outside code context.

The above configuration will add the following entry to the root resource:

`<someresource media-type="application/vnd.ez.api.Content+xml" href="/api/ezp/v2/content/objects/2"/>`
