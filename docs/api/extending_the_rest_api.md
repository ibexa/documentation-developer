# Extending the REST API

The [[= product_name =]] REST API comes with a framework that makes it easy to extend the API, so that it suits your requirements.

## Requirements

REST routes must use the [[= product_name =]] REST API prefix, `/api/ezp/v2`. 
You create new resources below this prefix.

To do so, you create:

-   a controller that handles your route actions
-   a route in your routing file
-   a controller action
-   optionally, a `ValueObjectVisitor` (if the controller returns an object that doesn't already have a converter)
-   optionally, an `InputParser`

### Controller

To create a REST controller, you extend the `Ibexa\Rest\Server\Controller` service, as well as the `Ibexa\Rest\Server\Controller` class.

First, create a simple controller with a `sayHello()` method that takes a name as an argument.
It can be, for example, `src/Rest/Controller/DefaultController.php`.

``` php
namespace App\Rest\Controller;

use Ibexa\Rest\Server\Controller as BaseController;

class DefaultController extends BaseController
{
    public function sayHello(string $name)
    {
        // @todo Implement me
    }
}
```

### Route

Your REST routes must use the REST URI prefix. 
To ensure that they do, in the `config/routes.yaml` file, import your routing file by using this prefix.

``` yaml
my_rest_routes:
    resource: routes_rest.yaml
    prefix: '%ezpublish_rest.path_prefix%'
```

When you have a distinct file for the REST routes, you can apply the prefix to all the routes from this file, without affecting other routes.

Next, you create the REST route. 
In the `config/routes_rest.yaml` file, define the route's [controller as a service]([[= symfony_doc =]]/cookbook/controller/service.html) because your controller was defined as such.

``` yaml
my_rest_hello_world:
    path: '/my_rest_bundle/hello/{name}'
    defaults:
        _controller: App\Rest\Controller\DefaultController::sayHello
    methods: [GET]
```

To configure whether the endpoint uses CSRF validation, add the `csrf_protection` setting to the route:

``` yaml
my_rest_hello_world:
    path: '/my_rest_bundle/hello/{name}'
    defaults:
        _controller: App\Rest\Controller\DefaultController::sayHello
        csrf_protection: false
    methods: [GET]
```

CSRF protection is enabled by default for all POST, PUT, and DELETE requests.

Due to [EZP-23016 - Custom REST API routes (v2) are not accessible from the legacy backend](https://jira.ez.no/browse/EZP-23016), 
custom REST routes must be prefixed with `ezpublish_rest_`, or they are not recognized.
Modify the `config/services.yaml` file by adding the following code:

``` yaml
services:
    App\Controller\Rest\DefaultController:
        parent: Ibexa\Rest\Server\Controller
        tags: ['controller.service_arguments']
```

## Controller action

Unlike standard Symfony controllers, REST controllers return `ValueObject` instead of 
the `HttpFoundation\Response` object. 
During the kernel run, `ValueObjectVisitor` converts `ValueObject` into a proper Symfony response. 
One benefit of such behavior is that the visitor is reused when multiple controllers return 
the same object, for example, a Content item or a Location.

For the controller to return `App\Rest\Values\Hello`, add the following code to the `src/Rest/Values/Hello.php` file.

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

An instance of this class is returned from the `sayHello()` controller method in the `src/Rest/Controller/DefaultController.php` file.

``` php
namespace App\Controller\Rest;

use Ibexa\Rest\Server\Controller as BaseController;
use App\Rest\Values\Hello as HelloValue;

class DefaultController extends BaseController
{
    public function sayHello($name): HelloValue
    {
        return new HelloValue($name);
    }
}
```

Outputting this object in the response requires that you create `ValueObjectVisitor`.

## ValueObjectVisitor

`ValueObjectVisitor` takes a Value returned by the REST controller, whatever the class, and 
transforms the Value into data that can be converted, either to JSON or XML format. 
Visitors are registered as services, and tagged with `ibexa.rest.output.value_object.visitorr`. 
The tag attribute corresponds to a class, which this visitor applies to.

In the `config/services.yaml` file, create a service for your `ValueObjectVisitor`.

``` yaml
services:
    App\Rest\ValueObjectVisitor\Hello:
        parent: Ibexa\Contracts\Rest\Output\ValueObjectVisitor
        tags:
            - { name: ibexa.rest.output.value_object.visitor, type: App\Rest\Values\Hello }
```

Then create your visitor. 
It must extend the  `Ibexa\Contracts\Rest\Output\ValueObjectVisitor` abstract class, and implement 
the `visit()` method.
The visitor receives the following arguments:

|Argument|Description|
|--------|-----------|
|`$visitor`| The output visitor. Can be used to set custom response headers ( `setHeader( $name, $value )`), HTTP status code ( `setStatus( $statusCode )` )|
|`$generator`| The actual response generator. It provides you with a DOM like API.|
|`$data`| The visited data. The exact object that you returned from the controller|

In the `src/Rest/ValueObjectVisitor/Hello.php` file, add the following code:

``` php
namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;

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

The easiest way to handle cache is to reuse the `CachedValue` value object. 
The `CachedValue` value object acts as a proxy and adds the cache headers, depending on the configuration, 
for a given object and a set of options.

For the response to be cached, return an instance of `CachedValue`, with the value object as an argument. 
You can also pass the Location ID as the second argument, so that the response is tagged with it:

``` php
use Ibexa\Rest\Server\Values\CachedValue;
//...
    public function sayHello(string $name)
    {
        return new CachedValue(
            new HelloValue($name),
            ['locationId'=> 42]
        );

    }

```

The corresponding response header, when using Varnish as reverse proxy, looks as follows:

```
Age →30
Cache-Control →private, no-cache
Via →1.1 varnish-v4
X-Cache →HIT
X-Cache-Hits →2
```

## Input parser

To provide your controller with parameters, either in JSON or XML format, the parameter struct requires 
an input parser so that the payload can be converted to an actual `ValueObject`.

Each payload is dispatched to its input parser based on the request's `Content-Type` header. 
For example, a request with a `Content-Type` of `application/vnd.ez.api.ContentCreate` is parsed 
by `Ibexa\Contracts\Rest\Input\Parser`. 
This parser builds and returns `ContentCreateStruct` that can then be used to create content with the Public API.

Input parsers are provided with a pre-parsed version of the input payload, as an associative array.
Parsers are format-insensitive (whether it is XML or JSON).

The following paragraphs discuss processing a `Content-Type` of `application/vnd.my.Greetings` that sends the following XML:

``` xml
<?xml version="1.0" encoding="utf-8"?>
<Greetings>
    <name>John doe</name>
</Greetings>
```

Create a service with the appropriate tag in the `config/services.yaml` file.
The `mediaType` attribute of the `ezpublish\_rest.input.parser` tag maps the Content Type to the input parser.

``` yaml
services:
    App\Rest\InputParser\Greetings:
        parent: Ibexa\Rest\Server\Common\Parser
        tags:
            - { name: ibexa.rest.input.parser, mediaType: application/vnd.my.Greetings }
```

Then, implement the parser. 
It must extend `Ibexa\Contracts\Rest\Input\Parser`, and implement the `parse()` method. 
As an argument, the `parse()` method accepts the `$data` array with input payload, and an instance 
of `ParsingDispatcher` that can be used to forward the parsing of embedded content.

For convenience, consider that the input parser returns an instance of `Value\Hello` class.
Add the following code to the `src/Rest/InputParser/Greetings.php` file.

``` php
namespace App\Rest\InputParser;

use Ibexa\Rest\Input\BaseParser;
use Ibexa\Rest\Input\ParsingDispatcher;
use App\Rest\Value\Hello;
use Ibexa\Rest\Server\Exceptions;

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

Modify the existing `DefaultController` by adding a method to handle the new POST request:

``` php
use Ibexa\Rest\Message;
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

The `inputDispatcher` is responsible for matching the `Content-Type` from the header with the Greetings' `InputParser` class.

Finally, add a new Route to `routes_rest.yaml`.

``` yaml
my_rest_hello_world_using_post:
    path: /my_rest_bundle/hello/
    defaults:
        _controller: App\Rest\Controller\DefaultController::sayHelloUsingPostAction
    methods: [POST]
```

!!! note

    POST requests are unable to access the Repository without performing user authentication. For more information, see [REST API Authentication](rest_api_authentication.md).

For more examples, examine the built-in `InputParsers` in `Ibexa\Rest\Server\Input\Parser`.

## Registering resources in the REST root

You can register newly added resources so that they show up in the REST root resource for automatic discovery.

You can register new resources with code similar the following example, where `someresource` is a unique key:

``` yaml
ez_publish_rest:
    system:
        <siteaccess>:
            rest_root_resources:
                someresource:
                    mediaType: Content
                    href: 'router.generate("ezpublish_rest_loadContent", {"contentId": 2})'
```

The `router.generate` call dynamically renders a URI based on the name of the route and the optional parameters that are passed as the other arguments.
In the above code sample, `contentId` is the additional parameter.

The syntax is based on the Symfony's [expression language]([[= symfony_doc =]]/components/expression_language/index.html), an extensible component that allows limited/readable scripting to be used outside of the code context.

The above configuration adds the following entry to the root resource:

`<someresource media-type="application/vnd.ez.api.Content+xml" href="/api/ezp/v2/content/objects/2"/>`

`<someresource media-type="application/vnd.ez.api.Content+xml" href="/api/ezp/v2/content/objects/2"/>
