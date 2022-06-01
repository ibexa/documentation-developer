<?php
// src/Rest/ValueObjectVisitor/RestLocation.php

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Core\Repository\URLAliasService;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;
use Ibexa\Rest\Server\Output\ValueObjectVisitor\RestLocation as BaseRestLocation;
use Ibexa\Rest\Server\Values\URLAliasRefList;

class RestLocation extends BaseRestLocation
{
    private URLAliasService $urlAliasService;

    public function __construct(URLAliasService $urlAliasService)
    {
        $this->urlAliasService = $urlAliasService;
    }


    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('Location');
        //TODO: The wrong default media-type added by the Generator is still there in XML
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
        $generator->endObjectElement('Location');
    }
}
