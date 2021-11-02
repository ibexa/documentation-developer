<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;

final class Type extends GenericType
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }
}
