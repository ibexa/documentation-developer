<?php

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Visitor;

class Greeting extends ValueObjectVisitor
{

    public function visit(Visitor $visitor, Generator $generator, $data)
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
