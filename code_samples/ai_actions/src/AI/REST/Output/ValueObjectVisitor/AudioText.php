<?php

declare(strict_types=1);

namespace App\AI\REST\Output\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Visitor;

final class AudioText extends ValueObjectVisitor
{
    private const OBJECT_IDENTIFIER = 'AudioText';

    public function visit(Visitor $visitor, Generator $generator, $data): void
    {
        $mediaType = 'ai.' . self::OBJECT_IDENTIFIER;
        $text = $data->getOutput();

        $generator->startObjectElement(self::OBJECT_IDENTIFIER, $mediaType);
        $visitor->setHeader('Content-Type', $generator->getMediaType($mediaType));

        $visitor->visitValueObject($text);

        $generator->endObjectElement(self::OBJECT_IDENTIFIER);
    }
}
