---
description: Extend REST API by creating a new resource.
---

# Creating new REST resource

To create a new REST resource, you need to prepare:

- the REST route leading to a controller action
- the controller and its action
- one or several input denormalizers if the controller needs to receive a payload to treat, one or several value classes to represent this payload, and potentially one or several new media types to type this payload in the `Content-Type` header (optional)
- one or several new value classes to represent the controller action result, their normalizers to help the generator to turn this into XML or JSON, and potentially one or several new media types to claim in the `Accept` header the desired value (optional)
- the addition of this resource route to the REST root (optional)

In the following example, you add a greeting resource to the REST API.
It's available through `GET` and `POST` methods. `GET` sets default values while `POST` allows inputting custom values.

## Route

New REST routes should use the [REST URI prefix](rest_api_usage.md#uri-prefix) for consistency.
To ensure that they do, in the `config/routes.yaml` file, while importing a REST routing file, use `ibexa.rest.path_prefix` parameter as a `prefix`.

``` yaml
[[= include_file('code_samples/api/rest_api/config/routes.yaml', 0, 3) =]]
```

The `config/routes_rest.yaml` file imported above is created with the following configuration:

``` yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml', 0, 3) =]]    methods: [GET]
```

### CSRF protection

If a REST route is designed to be used with [unsafe methods](rest_requests.md#request-method), the CSRF protection is enabled by default like for built-in routes.
You can disable it by using the route parameter `csrf_protection`.

``` yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml') =]]
```

## Controller

### Controller service

You can use the following configuration to have all controllers from the `App\Rest\Controller\` namespace (files in the `src/Rest/Controller/` folder) to be set as REST controller services.

``` yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 36, 42) =]]
```

Having the REST controllers set as services enables using features such as

- TODO: `controller.service_arguments`??
- TODO: `ibexa.api_platform.resource` tag is needed to have the route available in live doc (/api/ibexa/v2/doc#/App/api_greet_get)

### Controller action

A REST controller should:

- return an object (passed automatically to a normaliser) or a `Response` (to customize it further)
- TODO: extend `Ibexa\Rest\Server\Controller` to inherit utils methods and properties like `InputDispatcher` or `RequestParser`

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Controller/DefaultController.php', 0, 14) =]]
[[= include_file('code_samples/api/rest_api/src/Rest/Controller/DefaultController.php', 246) =]]
```

<details>
<summary>TODO</summary>

If the returned value was depending on a location, it could have been wrapped in a `CachedValue` to be cached by the reverse proxy (like Varnish) for future calls.

`CachedValue` is used in the following way:

```php
return new CachedValue(
    new MyValue($args…),
    ['locationId'=> $locationId]
);
```

</details>

## Value and Normalizer

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Values/Greeting.php') =]]
```

``` yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 43, 48) =]]
```

A normalizer must implement the `supportsNormalization` and `normalize` methods.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Serializer/GreetingNormalizer.php') =]]
```

## Input denormalizer

A REST resource could use route parameters to handle input, but this example illustrates the usage of denormalized payload.

For this example, the structure is a `GreetingInput` root node with two leaf nodes, `salutation` and `recipient`.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Serializer/GreetingInputDenormalizer.php') =]]
```

## Testing the new resource

Now you can test both `GET` and `POST` methods, and both `XML` and `JSON` format for inputs and outputs.

```shell
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
Content-Type: application/vnd.ibexa.api.Greeting+xml

<?xml version="1.0" encoding="UTF-8"?>
<Greeting>
 <Salutation>Hello</Salutation>
 <Recipient>World</Recipient>
 <Sentence>Hello World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.Greeting+xml

<?xml version="1.0"?>
<Greeting>
  <Salutation>Good morning</Salutation>
  <Recipient>World</Recipient>
  <Sentence>Good morning World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+json

{
    "Greeting": {
        "Salutation": "Good day",
        "Recipient": "Earth",
        "Sentence": "Good day Earth"
    }
}
```

## Describe resource in OpenAPI schema

TODO

```php
[[= include_file('code_samples/api/rest_api/src/Rest/Controller/DefaultController.php', 0, 246) =]]
```

<details>
<summary>

## Registering resources in REST root

</summary>

You can add the new resource to the [root resource](rest_api_usage.md#rest-root) through a configuration with the following pattern:

```yaml
ibexa_rest:
    system:
        <scope>:
            rest_root_resources:
                <resourceName>:
                    mediaType: <MediaType>
                    href: 'router.generate("<resource_route_name>", {routeParameter: value})'
```

The `router.generate` renders a URI based on the name of the route and its parameters.
The parameter values can be a real value or a placeholder.
For example, `'router.generate("ibexa.rest.load_location", {locationPath: "1/2"})'` results in `/api/ibexa/v2/content/locations/1/2` while `'router.generate("ibexa.rest.load_location", {locationPath: "{locationPath}"})'` gives `/api/ibexa/v2/content/locations/{locationPath}`.
This syntax is based on Symfony's [expression language]([[= symfony_doc =]]/components/expression_language/index.html), an extensible component that allows limited/readable scripting to be used outside the code context.

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

</details>
