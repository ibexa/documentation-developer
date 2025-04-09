<?php declare(strict_types=1);

namespace App\AutomatedTranslation;

use Ibexa\Contracts\AutomatedTranslation\Encoder\Field\FieldEncoderInterface;
use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Core\FieldType\Image\Value;

final class ImageFieldEncoder implements FieldEncoderInterface
{
    public function canEncode(Field $field): bool
    {
        return $field->fieldTypeIdentifier === 'ezimage';
    }

    public function canDecode(string $type): bool
    {
        return $type === 'ezimage';
    }

    public function encode(Field $field): string
    {
        /** @var \Ibexa\Core\FieldType\Image\Value $value */
        $value = $field->getValue();

        return $value->alternativeText ?? '';
    }

    /**
     * @param string $value
     * @param \Ibexa\Core\FieldType\Image\Value $previousFieldValue
     */
    public function decode(string $value, $previousFieldValue): Value
    {
        $previousFieldValue->alternativeText = $value;

        return $previousFieldValue;
    }
}
