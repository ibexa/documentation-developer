# Adding custom media type

Add a custom media type to REST API request headers.

In this example case, you pass a new media type in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its controller action (`Controller/Location::loadLocation`).

By default, this resource takes an `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header. The following example adds the handling of a new media type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different response with the same controller.

You need the following elements:

- `ValueObjectVisitor` - to create the new response corresponding to the new media type
- `ValueObjectVisitorDispatcher` - to have this `ValueObjectVisitor` used to visit the default controller result
- `Output\Visitor` - service associating this new `ValueObjectVisitorDispatcher` with the new media type

> **Note: Note**
>
> You can change the vendor name (from default `vnd.ibexa.api` to new `app.api` like in this example), or you can create a new media type in the default vendor (like `vnd.ibexa.api.Greeting` in the [Creating a new REST resource](../creating_new_rest_resource/index.md) example). To do so, tag your new ValueObjectVisitor with `ibexa.rest.output.value_object.visitor` to add it to the existing `ValueObjectVisitorDispatcher`, and a new one isn't needed. This way, the `media-type` attribute is also easier to create, because the default `Output\Generator` uses this default vendor. This example presents creating a new vendor as a good practice, to highlight that this is custom extensions that isn't available in a regular Ibexa DXP installation.

## New `RestLocation` `ValueObjectVisitor`

The controller action returns a `Values\RestLocation` object wrapped in `Values\CachedValue`. The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new `Response`.

To be accepted by the `ValueObjectVisitorDispatcher`, all new `ValueObjectVisitor` need to extend the abstract class `Output\ValueObjectVisitor`. In this example, this new `ValueObjectVisitor` extends the built-in `RestLocation` visitor to reuse it. This way, the abstract class is implicitly inherited.

```php
<?php declare(strict_types=1);

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Core\Repository\URLAliasService;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;
use Ibexa\Rest\Server\Output\ValueObjectVisitor\RestLocation as BaseRestLocation;
use Ibexa\Rest\Server\Values\URLAliasRefList;

class RestLocation extends BaseRestLocation
{
    public function __construct(private readonly URLAliasService $urlAliasService)
    {
    }

    #[\Override]
    public function visit(Visitor $visitor, Generator $generator, $data): void
    {
        // Not using $generator->startObjectElement to not have the XML Generator adding its own media-type attribute with the default vendor
        $generator->startHashElement('Location');
        $generator->attribute(
            'media-type',
            'application/app.api.Location+' . strtolower((new \ReflectionClass($generator))->getShortName())
        );
        $generator->attribute(
            'href',
            $this->router->generate(
                'ibexa.rest.load_location',
                ['locationPath' => trim($data->location->pathString, '/')]
            )
        );
        parent::visit($visitor, $generator, $data);
        $visitor->visitValueObject(new URLAliasRefList(array_merge(
            $this->urlAliasService->listLocationAliases($data->location, false),
            $this->urlAliasService->listLocationAliases($data->location, true)
        ), $this->router->generate(
            'ibexa.rest.list_location_url_aliases',
            ['locationPath' => trim($data->location->pathString, '/')]
        )));
        $generator->endHashElement('Location');
    }
}
```

This new `ValueObjectVisitor` receives a new tag `app.rest.output.value_object.visitor` to be associated to the new `ValueObjectVisitorDispatcher` in the next step. This tag has a `type` property to associate the new `ValueObjectVisitor` with the type of value is made for.

```yaml
services:
    #…
    App\Rest\ValueObjectVisitor\RestLocation:
        class: App\Rest\ValueObjectVisitor\RestLocation
        parent: Ibexa\Contracts\Rest\Output\ValueObjectVisitor
        arguments:
            $urlAliasService: '@ibexa.api.service.url_alias'
        tags:
            - { name: app.rest.output.value_object.visitor, type: Ibexa\Rest\Server\Values\RestLocation }
```

## New `ValueObjectVisitorDispatcher`

The new `ValueObjectVisitorDispatcher` receives the `ValueObjectVisitor`s tagged `app.rest.output.value_object.visitor`. As not all value FQCNs are handled, the new `ValueObjectVisitorDispatcher` also receives the default one as a fallback.

```yaml
services:
    #…
    App\Rest\Output\ValueObjectVisitorDispatcher:
        class: App\Rest\Output\ValueObjectVisitorDispatcher
        arguments:
            - !tagged_iterator { tag: 'app.rest.output.value_object.visitor', index_by: 'type' }
            - '@Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher'
```

```php
<?php declare(strict_types=1);

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use Ibexa\Contracts\Rest\Output\Visitor;

class ValueObjectVisitorDispatcher // extends BaseValueObjectVisitorDispatcher TODO: Rewrite this example in  https://issues.ibexa.co/browse/IBX-8190
{
    private array $visitors;

    private Visitor $outputVisitor;

    private Generator $outputGenerator;

    public function __construct(
        iterable $visitors,
        private readonly BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher
    ) {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
    }

    public function setOutputVisitor(Visitor $outputVisitor): void
    {
        $this->outputVisitor = $outputVisitor;
        $this->valueObjectVisitorDispatcher->setOutputVisitor($outputVisitor);
    }

    public function setOutputGenerator(Generator $outputGenerator): void
    {
        $this->outputGenerator = $outputGenerator;
        $this->valueObjectVisitorDispatcher->setOutputGenerator($outputGenerator);
    }

    public function visit($data)
    {
        $className = $data::class;
        if (isset($this->visitors[$className])) {
            return $this->visitors[$className]->visit($this->outputVisitor, $this->outputGenerator, $data);
        }

        return $this->valueObjectVisitorDispatcher->visit($data);
    }
}
```

## New `Output\Visitor` service

The following new pair of `Ouput\Visitor` entries associates `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorDispatcher` for both XML and JSON. A priority is set higher than other `ibexa.rest.output.visitor` tagged built-in services.

```yaml
parameters:
    #…
    app.rest.output.visitor.xml.regexps: ['(^application/app\.api\.[A-Za-z]+\+xml$)']
    app.rest.output.visitor.json.regexps: ['(^application/app\.api\.[A-Za-z]+\+json$)']

services:
    #…
    app.rest.output.visitor.xml:
        class: Ibexa\Contracts\Rest\Output\Visitor
        arguments:
            - '@Ibexa\Rest\Output\Generator\Xml'
            - '@App\Rest\Output\ValueObjectVisitorDispatcher'
        tags:
            - { name: ibexa.rest.output.visitor, regexps: app.rest.output.visitor.xml.regexps, priority: 20 }

    app.rest.output.visitor.json:
        class: Ibexa\Contracts\Rest\Output\Visitor
        arguments:
            - '@Ibexa\Rest\Output\Generator\Json'
            - '@App\Rest\Output\ValueObjectVisitorDispatcher'
        tags:
            - { name: ibexa.rest.output.visitor, regexps: app.rest.output.visitor.json.regexps, priority: 20 }
```

## Testing the new media-type

In the following example, `curl` and `diff` commands are used to compare the default media type (`application/vnd.ibexa.api.Location+xml`) with the new `application/app.api.Location+xml`.

```bash
diff --ignore-space-change \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2) \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2 --header 'Accept: application/app.api.Location+xml');
```

```diff
2c2,3
< <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
---
> <Location media-type="application/app.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
>  <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
37a39,42
>  </Location>
>  <UrlAliasRefList media-type="application/vnd.ibexa.api.UrlAliasRefList+xml" href="/api/ibexa/v2/content/locations/1/2/urlaliases">
>   <UrlAlias media-type="application/vnd.ibexa.api.UrlAlias+xml" href="/api/ibexa/v2/content/urlaliases/0-d41d8cd98f00b204e9800998ecf8427e"/>
>  </UrlAliasRefList>
```
