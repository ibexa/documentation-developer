<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use Ibexa\Contracts\Core\FieldType\Value as ValueInterface;

final class Value implements ValueInterface
{
    public function __construct(
        private ?float $x = null,
        private ?float $y = null
    ) {
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function setX(?float $x): void
    {
        $this->x = $x;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function setY(?float $y): void
    {
        $this->y = $y;
    }

    public function __toString(): string
    {
        return "({$this->x}, {$this->y})";
    }
}
