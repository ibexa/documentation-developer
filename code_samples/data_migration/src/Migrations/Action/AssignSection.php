<?php

declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Platform\Migration\ValueObject\Step\Action;

final class AssignSection implements Action
{
    public const TYPE = 'assign_section';

    /** @var string */
    private $sectionIdentifier;

    public function __construct(string $sectionIdentifier)
    {
        $this->sectionIdentifier = $sectionIdentifier;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->sectionIdentifier;
    }

    public function getSupportedType(): string
    {
        return self::TYPE;
    }
}
