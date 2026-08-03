# Creating new REST resource

Extend REST API by creating a new resource.

To create a new REST resource, you need to prepare:

- the REST route leading to a controller action
- the controller and its action
- one or several `InputParser` objects if the controller needs to receive a payload to treat, one or several value classes to represent this payload and potentially one or several new media types to type this payload in the `Content-Type` header (optional)
- one or several new value classes to represent the controller action result, their `ValueObjectVisitor` to help the generator to turn this into XML or JSON and potentially one or several new media types to claim in the `Accept` header the desired value (optional)
- the addition of this resource route to the REST root (optional)

In the following example, you add a greeting resource to the REST API. It's available through `GET` and `POST` methods. `GET` sets default values while `POST` allows inputting custom values.

## Route

New REST routes should use the [REST URI prefix](../../rest_api_usage/rest_api_usage/index.md#uri-prefix) for consistency. To ensure that they do, in the `config/routes.yaml` file, while importing a REST routing file, use `ibexa.rest.path_prefix` parameter as a `prefix`.

```yaml
app.rest:
    resource: routes_rest.yaml
    prefix: '%ibexa.rest.path_prefix%'
```

The `config/routes_rest.yaml` file imported above is created with the following configuration:

```yaml
app.rest.greeting:
    path: '/greet'
    controller: App\Rest\Controller\DefaultController::helloWorld
    methods: [GET]
```

### CSRF protection

If a REST route is designed to be used with [unsafe methods](../../rest_api_usage/rest_requests/index.md#request-method), the CSRF protection is enabled by default like for built-in routes. You can disable it by using the route parameter `csrf_protection`.

```yaml
app.rest.greeting:
    path: '/greet'
    controller: App\Rest\Controller\DefaultController::helloWorld
    methods: [GET,POST]
    defaults:
        csrf_protection: false
```

## Controller

### Controller service

You can use the following configuration to have all controllers from the `App\Rest\Controller\` namespace (files in the `src/Rest/Controller/` folder) to be set as REST controller services.

```yaml
services:
    #…
    App\Rest\Controller\:
        resource: '../src/Rest/Controller/'
        parent: Ibexa\Rest\Server\Controller
        autowire: true
        autoconfigure: true
        tags: [ 'controller.service_arguments' ]
```

Having the REST controllers set as services enables using features such as the `InputDispatcher` service in the [Controller action](#controller-action).

### Controller action

A REST controller should:

- return a value object and have a `Generator` and `ValueObjectVisitor`s producing the XML or JSON output
- extend `Ibexa\Rest\Server\Controller` to inherit utils methods and properties like `InputDispatcher` or `RequestParser`

```php
<?php declare(strict_types=1);

namespace App\Rest\Controller;

use App\Rest\Values\Greeting;
use Ibexa\Rest\Message;
use Ibexa\Rest\Server\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function greet(Request $request): Greeting
    {
        if ('POST' === $request->getMethod()) {
            return $this->inputDispatcher->parse(
                new Message(
                    ['Content-Type' => $request->headers->get('Content-Type')],
                    $request->getContent()
                )
            );
        }

        return new Greeting();
    }
}
```

If the returned value was depending on a location, it could have been wrapped in a `CachedValue` to be cached by the reverse proxy (like Varnish) for future calls.

`CachedValue` is used in the following way:

```php
use Ibexa\Rest\Server\Values\CachedValue;

$locationId = 12345;

return new CachedValue(
    new MyValue($args),
    ['locationId' => $locationId]
);
```

## Value and ValueObjectVisitor

```php
<?php declare(strict_types=1);

namespace App\Rest\Values;

class Greeting
{
    public function __construct(
        public string $salutation = 'Hello',
        public string $recipient = 'World'
    ) {
    }
}
```

A `ValueObjectVisitor` must implement the `visit` method.

| Argument     | Description                                                                                                                                        |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| `$visitor`   | The output visitor. Can be used to set custom response headers (`setHeader`), HTTP status code ( `setStatus`)                                      |
| `$generator` | The actual response generator. It provides you with a DOM-like API.                                                                                |
| `$data`      | The visited data. The exact object that you returned from the controller. It can't have a type declaration because the method signature is shared. |

```php
<?php declare(strict_types=1);

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Visitor;

class Greeting extends ValueObjectVisitor
{
    /**
     * @param \App\Rest\Values\Greeting $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data): void
    {
        $visitor->setHeader('Content-Type', $generator->getMediaType('Greeting'));
        $generator->startObjectElement('Greeting');
        $generator->attribute('href', $this->router->generate('app.rest.greeting'));
        $generator->valueElement('Salutation', $data->salutation);
        $generator->valueElement('Recipient', $data->recipient);
        $generator->valueElement('Sentence', "{$data->salutation} {$data->recipient}");
        $generator->endObjectElement('Greeting');
    }
}
```

The `Values/Greeting` class is linked to its `ValueObjectVisitor` through the service tag.

```yaml
services:
    #…
    App\Rest\ValueObjectVisitor\Greeting:
        parent: Ibexa\Contracts\Rest\Output\ValueObjectVisitor
        tags:
            - { name: ibexa.rest.output.value_object.visitor, type: App\Rest\Values\Greeting }
```

Here, the media type is `application/vnd.ibexa.api.Greeting` plus a format. To have a different vendor than the default, you could create a new `Output\Generator` or hard-code it in the `ValueObjectVisitor` like in the [`RestLocation` example](../adding_custom_media_type/index.md#new-restlocation-valueobjectvisitor).

## InputParser

A REST resource could use route parameters to handle input, but this example illustrates the usage of an input parser.

For this example, the structure is a `GreetingInput` root node with two leaf nodes, `Salutation` and `Recipient`.

```php
<?php declare(strict_types=1);

namespace App\Rest\InputParser;

use App\Rest\Values\Greeting;
use Ibexa\Contracts\Rest\Exceptions;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Input\BaseParser;

class GreetingInput extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): Greeting
    {
        if (!isset($data['Salutation'])) {
            throw new Exceptions\Parser("Missing or invalid 'Salutation' element for Greeting.");
        }

        return new Greeting($data['Salutation'], $data['Recipient'] ?? 'World');
    }
}
```

Here, this `InputParser` directly returns the right value object. In other cases, it could return whatever object is needed to represent the input for the controller to perform its action, like arguments to use with a Repository service.

```yaml
services:
    #…
    App\Rest\InputParser\GreetingInput:
        parent: Ibexa\Rest\Server\Common\Parser
        tags:
            - { name: ibexa.rest.input.parser, mediaType: application/vnd.ibexa.api.GreetingInput }
```

## Testing the new resource

Now you can test both `GET` and `POST` methods, and both `XML` and `JSON` format for inputs and outputs.

```bash
curl https://api.example.com/api/ibexa/v2/greet --include;
curl https://api.example.com/api/ibexa/v2/greet --include --request POST \
    --header 'Content-Type: application/vnd.ibexa.api.GreetingInput+xml' \
    --data '<GreetingInput><Salutation>Good morning</Salutation></GreetingInput>';
curl https://api.example.com/api/ibexa/v2/greet --include --request POST \
    --header 'Content-Type: application/vnd.ibexa.api.GreetingInput+json' \
    --data '{"GreetingInput": {"Salutation": "Good day", "Recipient": "Earth"}}' \
    --header 'Accept: application/vnd.ibexa.api.Greeting+json';
```

```http
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+xml

<?xml version="1.0" encoding="UTF-8"?>
<Greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet">
 <Salutation>Hello</Salutation>
 <Recipient>World</Recipient>
 <Sentence>Hello World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+xml

<?xml version="1.0" encoding="UTF-8"?>
<Greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet">
 <Salutation>Good morning</Salutation>
 <Recipient>World</Recipient>
 <Sentence>Good morning World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+json

{
    "Greeting": {
        "_media-type": "application\/vnd.ibexa.api.Greeting+json",
        "_href": "\/api\/ibexa\/v2\/greet",
        "Salutation": "Good day",
        "Recipient": "Earth",
        "Sentence": "Good day Earth"
    }
}
```

## Registering resources in REST root

You can add the new resource to the [root resource](../../rest_api_usage/rest_api_usage/index.md#rest-root) through a configuration with the following pattern:

```yaml
ibexa_rest:
    system:
        <scope>:
            rest_root_resources:
                <resourceName>:
                    mediaType: <MediaType>
                    href: 'router.generate("<resource_route_name>", {routeParameter: value})'
```

The `router.generate` renders a URI based on the name of the route and its parameters. The parameter values can be a real value or a placeholder. For example, `'router.generate("ibexa.rest.load_location", {locationPath: "1/2"})'` results in `/api/ibexa/v2/content/locations/1/2` while `'router.generate("ibexa.rest.load_location", {locationPath: "{locationPath}"})'` gives `/api/ibexa/v2/content/locations/{locationPath}`. This syntax is based on Symfony's [expression language](https://symfony.com/doc/7.4/components/expression_language.html), an extensible component that allows limited/readable scripting to be used outside the code context.

In this example, `app.rest.greeting` is available in every SiteAccess (`default`):

```yaml
ibexa_rest:
    system:
        default:
            rest_root_resources:
                greeting:
                    mediaType: Greeting
                    href: 'router.generate("app.rest.greeting")'
```

You can place this configuration in any regular config file, like the existing `config/packages/ibexa.yaml`, or a new `config/packages/ibexa_rest.yaml` file.

The above example adds the following entry to the root XML output:

```xml
<greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet"/>
```
