<?php

declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Migration\ValueObject\Step\Action;

final readonly class AssignSection implements Action
{
    public const string TYPE = 'assign_section';

    public function __construct(private string $sectionIdentifier)
    {
    }

    public function getSectionIdentifier(): string
    {
        return $this->sectionIdentifier;
    }

    public function getSupportedType(): string
    {
        return self::TYPE;
    }
}
