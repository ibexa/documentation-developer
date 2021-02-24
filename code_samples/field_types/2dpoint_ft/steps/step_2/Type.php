<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;

final class Type extends GenericType
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }
}
