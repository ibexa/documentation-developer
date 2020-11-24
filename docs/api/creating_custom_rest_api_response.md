# Creating custom REST API response based on Accept header

Customized REST API response can be used in many situations, both for headless and more traditional setups. REST responses can be enriched in a clean way and limit client-to-server round trips.

To do this you can take advantage of [[= product_name =]]'s [HATEOAS-based](https://en.wikipedia.org/wiki/HATEOAS) REST API and extend it with custom Content Types for your own needs. In this section you will add comments count to `eZ\Publish\API\Repository\Values\Content\VersionInfo` responses.

## Implementation of dedicated Visitor

The first step is creating your own implementation of `ValueObjectVisitor`. It contains all the logic responsible for:

- fetching data you want to present
- modifying the actual response

```php
<?php

namespace ExampleBundle\Rest\ValueObjectVisitor;

use eZ\Publish\API\Repository\Repository;
use EzSystems\EzPlatformRest\Output\Generator;
use EzSystems\EzPlatformRest\Output\Visitor;
use EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor\VersionInfo as BaseVersionInfo;
use eZ\Publish\API\Repository\Values\Content\VersionInfo as APIVersionInfo;

class VersionInfo extends BaseVersionInfo
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function visitVersionInfoAttributes(Visitor $visitor, Generator $generator, APIVersionInfo $versionInfo)
    {
        parent::visitVersionInfoAttributes($visitor, $generator, $versionInfo);

        $this->visitCommentValue($generator, $versionInfo);
    }

    protected function visitCommentValue(Generator $generator, APIVersionInfo $versionInfo)
    {
       $generator->startValueElement('commentsCount', $this->loadCommentsCount($versionInfo));
       $generator->endValueElement('commentsCount');
    }

    private function loadCommentsCount(APIVersionInfo $versionInfo)
    {
       // load comments count using the repository (injected), or any comments backend
    }
}
```

## Overriding response type

Next, make sure that your new implementation of serialization applies only to the selected objects. In order to do that, you need to
decorate `EzSystems\EzPlatformRest\Output\ValueObjectVisitorDispatcher` from `ezplatform-kernel`.

```php
<?php

namespace ExampleBundle\Rest;

use EzSystems\EzPlatformRest\Output\Generator;
use EzSystems\EzPlatformRest\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use EzSystems\EzPlatformRest\Output\Exceptions\NoVisitorFoundException;
use EzSystems\EzPlatformRest\Output\Visitor;

class ValueObjectVisitorDispatcher extends BaseValueObjectVisitorDispatcher
{
    private $parentDispatcher;

    public function __construct(BaseValueObjectVisitorDispatcher $parentDispatcher)
    {
        $this->parentDispatcher = $parentDispatcher;
    }

    public function setOutputVisitor(Visitor $outputVisitor)
    {
        parent::setOutputVisitor($outputVisitor);
        $this->parentDispatcher->setOutputVisitor($outputVisitor);
    }

    public function setOutputGenerator(Generator $outputGenerator)
    {
        parent::setOutputGenerator($outputGenerator);
        $this->parentDispatcher->setOutputGenerator($outputGenerator);
    }

    public function visit($data)
    {
        try {
            return parent::visit($data);
        } catch (NoVisitorFoundException $e) {
            return $this->parentDispatcher->visit($data);
        }
    }
}
```

To be able to use the overridden type you also need to implement new Compiler Pass. For more details, see [Symfony doc.](https://symfony.com/doc/5.0/service_container/compiler_passes.html)

```php
<?php

namespace ExampleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValueObjectVisitorPass implements CompilerPassInterface
{
    const TAG_NAME = 'app.value_object_visitor';
    const DISPATCHER_DEFINITION_ID = 'app.rest.output.value_object_visitor.dispatcher';

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::DISPATCHER_DEFINITION_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::DISPATCHER_DEFINITION_ID);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $attributes) {
            foreach ($attributes as $attribute) {
                if (!isset($attribute['type'])) {
                    throw new \LogicException(self::TAG_NAME . ' service tag needs a "type" attribute to identify the field type. None given.');
                }
                $definition->addMethodCall(
                    'addVisitor',
                    [$attribute['type'], new Reference($id)]
                );
            }
        }
    }
}
```

Also, do not forget to register it in your bundle.

```php
<?php

namespace ExampleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use AppBundle\DependencyInjection\Compiler\ValueObjectVisitorPass;

class ExampleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValueObjectVisitorPass());
    }
}

```

## Configuration

The last thing you need to do is to set a configuration which should be located in the `services.yaml` file of your bundle.
The important part are the keys:

- `app.rest.output.visitor.json.regexps` which helps identifying proper header
- `priority` which should be set high enough, to not be overridden by another implementation

All the other keys need to correspond with the current namespace of your bundle. In this example it is just `ExampleBundle`.

```yaml
parameters:
    app.rest.output.visitor.json.regexps:
        - '(^application/my\.api\.[A-Za-z]+\+json$)'
    app.rest.generator.json.vendor: 'my.api'

services:
    app.rest.output.generator.json:
        class: EzSystems\EzPlatformRest\Output\Generator\Json
        arguments:
            - '@ezpublish_rest.output.generator.json.field_type_hash_generator'
            - '%app.rest.generator.json.vendor%'
        calls:
            - [ setFormatOutput, [ '%kernel.debug%' ] ]

    app.rest.output.visitor.json:
        class: '%ezpublish_rest.output.visitor.class%'
        arguments:
            - '@app.rest.output.generator.json'
            - '@app.rest.output.value_object_visitor.dispatcher'
        tags:
            - { name: ezpublish_rest.output.visitor, regexps: app.rest.output.visitor.json.regexps, priority: 200 }

    app.rest.output.value_object_visitor.dispatcher:
        class: ExampleBundle\Rest\ValueObjectVisitorDispatcher
        arguments:
            - '@ezpublish_rest.output.value_object_visitor.dispatcher'

    app.rest.output.value_object_visitor.version_info:
        class: ExampleBundle\Rest\ValueObjectVisitor\VersionInfo
        parent: ezpublish_rest.output.value_object_visitor.base
        arguments:
            - '@ezpublish.api.repository'
        tags:
            - { name: app.value_object_visitor, type: eZ\Publish\API\Repository\Values\Content\VersionInfo }
```

## Fetching the modified response

After following all the steps you should see an example of the modified API response below. As you see `media-type` is correctly interpreted and `commentsCount` is also appended (it's `null` as you did not provide any logic to fetch it).
Please note that you should set a proper `Accept` header value. For this example: `application/my.api.VersionList+json`.

```json
{
    "VersionList": {
        "_media-type": "application\/my.api.VersionList+json",
        "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions",
        "VersionItem": [
            {
                "Version": {
                    "_media-type": "application\/my.api.Version+json",
                    "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions\/9"
                },
                "VersionInfo": {
                    "id": 506,
                    "versionNo": 9,
                    "status": "PUBLISHED",
                    "modificationDate": "2015-11-30T14:10:46+01:00",
                    "Creator": {
                        "_media-type": "application\/my.api.User+json",
                        "_href": "\/api\/ezp\/v2\/user\/users\/14"
                    },
                    "creationDate": "2015-11-30T14:10:45+01:00",
                    "initialLanguageCode": "eng-GB",
                    "languageCodes": "eng-GB",
                    "VersionTranslationInfo": {
                        "_media-type": "application\/my.api.VersionTranslationInfo+json",
                        "Language": [
                            {
                                "languageCode": "eng-GB"
                            }
                        ]
                    },
                    "names": {
                        "value": [
                            {
                                "_languageCode": "eng-GB",
                                "#text": "Ibexa Platform"
                            }
                        ]
                    },
                    "Content": {
                        "_media-type": "application\/my.api.ContentInfo+json",
                        "_href": "\/api\/ezp\/v2\/content\/objects\/1"
                    },
                    "commentsCount": null
                }
            }
        ]
    }
}
```

!!! tip

    You can test your response by using JavaScript/AJAX example code, see [testing the API](rest_api_guide.md#testing-the-api).
