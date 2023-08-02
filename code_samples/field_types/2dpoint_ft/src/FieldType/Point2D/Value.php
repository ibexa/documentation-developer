<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use eZ\Publish\SPI\FieldType\Value as ValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Value implements ValueInterface
{
    /**
     * @var float|null
     *
     * @Assert\NotBlank()
     */
    private $x;

    /**
     * @var float|null
     *
     * @Assert\NotBlank()
     */
    private $y;

    public function __construct(array $coords = [])
    {
        if (!empty($coords)) {
            $this->x = $coords[0];
            $this->y = $coords[1];
        }
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

    public function __toString()
    {
        return "({$this->x}, {$this->y})";
    }
}
