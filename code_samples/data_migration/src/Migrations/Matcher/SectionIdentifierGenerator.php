<?php

declare(strict_types=1);

namespace App\Migrations\Matcher;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use Ibexa\Platform\Migration\Generator\CriterionGenerator\GeneratorInterface;

final class SectionIdentifierGenerator implements GeneratorInterface
{
    public static function getMatchProperty(): string
    {
        return 'section_identifier';
    }

    public function generate($value): Criterion
    {
        return new Criterion\SectionIdentifier($value);
    }
}
