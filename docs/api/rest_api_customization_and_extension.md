# REST API customization and extension
TODO: Or "Customizing and extending the REST API"

## Component Cascade / Timeline Summary
TODO: Find the right section title

### (short version)
* The REST route leads to a REST controller action witch returns an Ibexa\Rest\Value descendant (for example, an Ibexa\Rest\Server\Values\CachedValue); this return can depend on the request’s Accept HTTP header.
* The AcceptHeaderVisitorDispatcher matchs the regexps of an ibexa.rest.output.visitor (an Ibexa\Contracts\Rest\Output\Visitor).
* The matched Output\Visitor uses its ValueObjectVisitorDispatcher to select the right ValueObjectVisitor according to the FQCN of the Controller result .

### (long version)
* A REST Route leads to a REST Controller action.
TODO: Explain the route building (root-route + sub-route)
* This Controller action returns an Ibexa\Rest\Value descendant; the Controller might use the Request (like the Accept header) to build its result.
TODO: Explain a bit more. What about inputs?
* The Ibexa\Bundle\Rest\EventListener\ResponseListener listening the `kernel.view event` is triggered, and, passes the Request and the Controller Result to the AcceptHeaderVisitorDispatcher.
* The AcceptHeaderVisitorDispatcher matches the regexps of an ibexa.rest.output.visitor (an Ibexa\Contracts\Rest\Output\Visitor).
* The matched Output\Visitor uses its ValueObjectVisitorDispatcher to select the right ValueObjectVisitor according to the FQCN of the Controller result.
* ValueObjectVisitors will recursively transform the Controller result into TODO
* The Output\Visitor returns the Response to send back to the client.

### vnd.ibexa.api.Content VS vnd.ibexa.api.ContentInfo example

https://github.com/ibexa/rest/blob/main/src/lib/Server/Controller/Content.php#L79: The controller associated to /content/objects/{contentId} returns a Ibexa\Rest\Server\Values\RestContent (wrapped in a CachedValue) with currentVersion property that depends on the Accept header: null if vnd.ibexa.api.ContentInfo, not null if vnd.ibexa.api.Content but an Ibexa\Contracts\Core\Repository\Values\Content\Content

https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/services.yml#L280: The tagging associate a regex to an Output\Visitor
* "(^application/vnd\.ibexa\.api\.[A-Za-z]+\+json$)" => Ibexa\Contracts\Rest\Output\Visitor
* "(^application/vnd\.ibexa\.api\.[A-Za-z]+\+xml$)" => Ibexa\Contracts\Rest\Output\Visitor

https://github.com/ibexa/rest/blob/main/src/lib/Server/View/AcceptHeaderVisitorDispatcher.php#L52: The AcceptHeaderVisitorDispatcher will match vnd.ibexa.api.Content or vnd.ibexa.api.ContentInfo with Ibexa\Contracts\Rest\Output\Visitor

https://github.com/ibexa/rest/blob/main/src/contracts/Output/Visitor.php#L138: This Output\Visitor uses its ValueObjectVisitorDispatcher to visit data returned by the controller

* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L682: Ibexa\Rest\Server\Values\CachedValue is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\CachedValue
* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L202: Ibexa\Rest\Server\Values\RestContent is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\RestContent
* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L241: Ibexa\Rest\Server\Values\Version is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\Version

https://github.com/ibexa/rest/blob/main/src/contracts/Output/ValueObjectVisitorDispatcher.php#L73: The ValueObjectVisitorDispatcher use the data to select the right ValueObjectVisitor

https://github.com/ibexa/rest/blob/main/src/lib/Server/Output/ValueObjectVisitor/CachedValue.php#L37: ValueObjectVisitor can recursively call the ValueObjectVisitorDispatcher to visit properties with the right ValueObjectVisitor as, for example, the ValueObjectVisitor/CachedValue does.

https://github.com/ibexa/rest/blob/main/src/lib/Server/Output/ValueObjectVisitor/RestContent.php#L102: The Values\RestContent returned by the controller is visited by the ValueObjectVisitor\RestContent; if not null, its currentVersion property will be wrapped in a Ibexa\Rest\Server\Values\Version to be visited by the associated Ibexa\Rest\Server\Output\ValueObjectVisitor\Version

## Adding a custom media-type / Accept header to an existing route / resource
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/
TODO: Explain vocabulary usage in previous section. Fix this section title.

In this example case, a new media-type will be passed in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its Controller action (`Controller/Location::loadLocation`).

By default, this resource handle a `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header.
The following example will add the handling of a new media-type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different Response using the same controller.

TODO: Choose the chronology: Output\Visitor → ValueObjectVisitorDispatcher → ValueObjectVisitor
* To handle Request with an `Accept` header stating with `application/app.api`, a new `Output\Visitor` service is needed.
* This `Output\Visitor` will need a new `ValueObjectVisitorDispatcher` to handle the result of the default Controller action and treat it differently.
* The new `ValueObjectVisitorDispatcher` will use a new `ValueObjectVisitor` to visit the default Controller result.
TODO: This chronology is closer to the system

TODO: Choose the chronology: ValueObjectVisitor → ValueObjectVisitorDispatcher → Output\Visitor
* To create the new Response corresponding to this new media-type, a new `ValueObjectVisitor` is needed.
* To have this new `ValueObjectVisitor` used to visit the default Controller result, a new `ValueObjectVisitorDispatcher` is needed.
* To have this new `ValueObjectVisitorDispatcher` associated to the new media-type in an `Accept` header, a new `Output\Visitor` service is needed.
TODO: This chronology is closer to the development

### New `RestLocation` `ValueObjectVisitor`

The default Controller action returns a `Values\RestLocation` wrapped in a `Values\CachedValue`.
The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new Response.
TODO: For the example, this new `ValueObjectVisitor` extends the default visitor to have less code to write / this new `ValueObjectVisitor` needs to extend the default visitor to be accepted by…

```php
<?php
// src/Rest/ValueObjectVisitor/RestLocation.php

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Core\Repository\URLAliasService as URLAliasServiceInterface;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;
use Ibexa\Rest\Server\Output\ValueObjectVisitor\RestLocation as BaseRestLocation;
use Ibexa\Rest\Server\Values\URLAliasRefList;

class RestLocation extends BaseRestLocation
{
    private URLAliasServiceInterface $urlAliasService;

    public function __construct(URLAliasServiceInterface $urlAliasService/* Repository $repository */)
    {
        $this->urlAliasService = $urlAliasService;
    }


    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('Location');
        //TODO: Can a "generator" add the media-type?
        $generator->startAttribute(
            'media-type',
            'application/app.api.Location+' . strtolower((new \ReflectionClass($generator))->getShortName())
        );
        $generator->endAttribute('media-type');
        parent::visit($visitor, $generator, $data);
        $visitor->visitValueObject(new URLAliasRefList(array_merge(
            $this->urlAliasService->listLocationAliases($data->location, false),
            $this->urlAliasService->listLocationAliases($data->location, true)
        ), $this->router->generate(
            'ibexa.rest.list_location_url_aliases',
            ['locationPath' => trim($data->location->pathString, '/')]
        )));
        $generator->endObjectElement('Location');
    }
}

```

This new `ValueObjectVisitor` receiveq a new tag `app.rest.output.value_object.visitor` to be associated to the new `ValueObjectVisitorDispatcher` in the next step.
This tag has a `type` property to associate the new `ValueObjectVisitor` with the type of value is made for.
TODO: Expose the default `ibexa.rest.output.value_object.visitor` tagging earlier.
```yaml
# config/services.yaml
services:
    #…
    App\Rest\ValueObjectVisitor\RestLocation:
        class: App\Rest\ValueObjectVisitor\RestLocation
        parent: Ibexa\Contracts\Rest\Output\ValueObjectVisitor
        arguments:
            $urlAliasService:  '@ibexa.api.service.url_alias'
        tags:
            - { name: app.rest.output.value_object.visitor, type: Ibexa\Rest\Server\Values\RestLocation }
```

### New `ValueObjectVisitorDispatcher`

The new `ValueObjectVisitorDispatcher` receives the `ValueObjectVisitor`s tagged `app.rest.output.value_object.visitor`.
As not all value FQCNs are handled, the new `ValueObjectVisitorDispatcher` also receives the default one as a fallback.

```yaml
# config/services.yaml
services:
    #…
    App\Rest\Output\ValueObjectVisitorDispatcher:
        class: App\Rest\Output\ValueObjectVisitorDispatcher
        arguments:
            - !tagged_iterator { tag: 'app.rest.output.value_object.visitor', index_by: 'type' }
            - '@Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher'
```

```php
<?php
// src/Rest/Output/ValueObjectVisitorDispatcher.php

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use Ibexa\Contracts\Rest\Output\Visitor;

class ValueObjectVisitorDispatcher extends BaseValueObjectVisitorDispatcher
{
    private array $visitors;

    private BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher;

    private Visitor $outputVisitor;

    private Generator $outputGenerator;

    public function __construct(iterable $visitors, BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher)
    {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
        $this->valueObjectVisitorDispatcher = $valueObjectVisitorDispatcher;
    }

    public function setOutputVisitor(Visitor $outputVisitor)
    {
        $this->outputVisitor = $outputVisitor;
        $this->valueObjectVisitorDispatcher->setOutputVisitor($outputVisitor);
    }

    public function setOutputGenerator(Generator $outputGenerator)
    {
        $this->outputGenerator = $outputGenerator;
        $this->valueObjectVisitorDispatcher->setOutputGenerator($outputGenerator);
    }

    public function visit($data)
    {
        $className = get_class($data);
        if (isset($this->visitors[$className])) {
            return $this->visitors[$className]->visit($this->outputVisitor, $this->outputGenerator, $data);
        }
        return $this->valueObjectVisitorDispatcher->visit($data);
    }
}
```

### New `Output\Visitor` service

The following new pair of `Ouput\Visitor` associate `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorDispatcher` for both XML and JSON.

```yaml
# config/services.yaml
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

## Creating a new REST resource route
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/

TODO
