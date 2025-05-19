<?php declare(strict_types=1);

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
