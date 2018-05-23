#Creating custom REST API response based on Accept header

There are several situations when customizing REST API response could be useful. One of the examples is extending it by adding comments count to 
`eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor\VersionInfo` response.

##Implementation of dedicated Visitor
The first step is creating your own implementation of `ValueObjectVisitor`. It contains all the logic which is responsible for fetching data
you want to present and for modifying the actual response.

```php
<?php

namespace Acme\ExampleBundle\Rest\ValueObjectVisitor;

use eZ\Publish\API\Repository\Repository;
use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\Visitor;
use eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor\VersionInfo as BaseVersionInfo;
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

        $this->visitTestValue($generator);
    }

    protected function visitTestValue(Generator $generator)
    {
        $commentsCount = 10; //for this example value is mocked, but you can use any custom logic to fetch it
        
        $generator->startValueElement('commentsCount', $commentsCount);
        $generator->endValueElement('commentsCount');
    }
}
```

##Overriding response type
Next, you'll need to make sure that your new implementation of serialization applies only to selected objects. In order to do that you need to 
decorate `eZ\Publish\Core\REST\Common\Output\ValueObjectVisitorDispatcher` from `ezpublish-kernel`.

```php
<?php

namespace Acme\ExampleBundle\Rest;

use eZ\Publish\Core\REST\Common\Output\Generator;
use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use eZ\Publish\Core\REST\Common\Output\Exceptions\NoVisitorFoundException;
use eZ\Publish\Core\REST\Common\Output\Visitor;

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

The response needs to have a proper type. The way to assure it is to override the format generator (e.g. xml/json).

```php
<?php

namespace Acme\ExampleBundle\Rest\Generator;

use eZ\Publish\Core\REST\Common\Output\Generator\Json as BaseJson;

class Json extends BaseJson
{
    protected function generateMediaType($name, $type)
    {
        return "application/vnd.ez.example.{$name}+{$type}";
    }
}
```

To be able to use overridden type you also need to implement new Compiler Pass. For more details see [Symfony doc](https://symfony.com/doc/current/service_container/compiler_passes.html). 

```php
<?php

namespace Acme\ExampleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValueObjectVisitorPass implements CompilerPassInterface
{
    const TAG_NAME = 'acme.example.value_object_visitor';
    const DISPATCHER_DEFINITION_ID = 'acme.example.rest.output.value_object_visitor.dispatcher';

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

Also, don't forget to register it in your bundle!

```php
<?php

namespace Acme\ExampleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Acme\ExampleBundle\DependencyInjection\Compiler\ValueObjectVisitorPass;

class AcmeExampleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValueObjectVisitorPass());
    }
}

```
##Configuration
The last thing you need to do is to set a configuration which should be located in `services.yml` file of your bundle. The important parts are 
the keys: `acme.example.rest.output.visitor.json.regexps` which helps identifying proper header and `priority` which should be set high enough, to not be overridden by another implementation.
All the other keys need to correspond with the current namespace of your bundle. In this example it is `Acme\ExampleBundle`.

```yaml
parameters:
    acme.example.rest.output.visitor.json.regexps:
        - '(^application/vnd\.ez\.example\.[A-Za-z]+\+json$)'

services:
    acme.example.rest.output.generator.json:
        class: Acme\ExampleBundle\Rest\Generator\Json
        arguments:
            - "@ezpublish_rest.output.generator.json.field_type_hash_generator"
        calls:
            - [ setFormatOutput, [ "%kernel.debug%" ] ]

    acme.example.rest.output.visitor.json:
        class: "%ezpublish_rest.output.visitor.class%"
        arguments:
            - "@acme.example.rest.output.generator.json"
            - "@acme.example.rest.output.value_object_visitor.dispatcher"
        tags:
            - { name: ezpublish_rest.output.visitor, regexps: acme.example.rest.output.visitor.json.regexps, priority: 200 }

    acme.example.rest.output.value_object_visitor.dispatcher:
        class: Acme\ExampleBundle\Rest\ValueObjectVisitorDispatcher
        arguments:
            - '@ezpublish_rest.output.value_object_visitor.dispatcher'

    acme.example.rest.output.value_object_visitor.version_info:
        class: Acme\ExampleBundle\Rest\ValueObjectVisitor\VersionInfo
        parent: ezpublish_rest.output.value_object_visitor.base
        arguments:
            - "@ezpublish.api.repository"
        tags:
            - { name: acme.example.value_object_visitor, type: eZ\Publish\API\Repository\Values\Content\VersionInfo }
```

##Fetching the modified response
After following all the steps you should see an example of the modified API response below. As you see `media-type` is correctly interpreted and additional data is also appended.
Please note that you should set a proper `Accept` header value. For this example: `application/vnd.ez.example.VersionList+json`.

```json
{
    "VersionList": {
        "_media-type": "application\/vnd.ez.example.VersionList+json",
        "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions",
        "VersionItem": [
            {
                "Version": {
                    "_media-type": "application\/vnd.ez.example.Version+json",
                    "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions\/9"
                },
                "VersionInfo": {
                    "id": 506,
                    "versionNo": 9,
                    "status": "PUBLISHED",
                    "modificationDate": "2015-11-30T14:10:46+01:00",
                    "Creator": {
                        "_media-type": "application\/vnd.ez.example.User+json",
                        "_href": "\/api\/ezp\/v2\/user\/users\/14"
                    },
                    "creationDate": "2015-11-30T14:10:45+01:00",
                    "initialLanguageCode": "eng-GB",
                    "languageCodes": "eng-GB",
                    "VersionTranslationInfo": {
                        "_media-type": "application\/vnd.ez.example.VersionTranslationInfo+json",
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
                                "#text": "eZ Platform"
                            }
                        ]
                    },
                    "Content": {
                        "_media-type": "application\/vnd.ez.example.ContentInfo+json",
                        "_href": "\/api\/ezp\/v2\/content\/objects\/1"
                    },
                    "commentsCount": 10
                }
            }
        ]
    }
}
```

!!! tip

    You can simply test your response by using JavaScript/AJAX example code, see [Testing the API](../api/rest_api_guide/#testing-the-api).