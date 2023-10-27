<?php declare(strict_types=1);

namespace App\Rest\ValueObjectVisitor;

use eZ\Publish\API\Repository\URLAliasService;
use EzSystems\EzPlatformRest\Output\Generator;
use EzSystems\EzPlatformRest\Output\Visitor;
use EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor\RestLocation as BaseRestLocation;
use EzSystems\EzPlatformRest\Server\Values\URLAliasRefList;

class RestLocation extends BaseRestLocation
{
    private $urlAliasService;

    public function __construct(URLAliasService $urlAliasService)
    {
        $this->urlAliasService = $urlAliasService;
    }

    public function visit(Visitor $visitor, Generator $generator, $data)
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
                'ezpublish_rest_loadLocation',
                ['locationPath' => trim($data->location->pathString, '/')]
            )
        );
        parent::visit($visitor, $generator, $data);
        $visitor->visitValueObject(new URLAliasRefList(array_merge(
            $this->urlAliasService->listLocationAliases($data->location, false),
            $this->urlAliasService->listLocationAliases($data->location, true)
        ), $this->router->generate(
            'ezpublish_rest_listLocationURLAliases',
            ['locationPath' => trim($data->location->pathString, '/')]
        )));
        $generator->endHashElement('Location');
    }
}
