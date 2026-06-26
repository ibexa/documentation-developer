<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\FieldType\Value;
use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\EncodedFieldValue;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\FieldValueTransformerInterface;

final class ImageAltTextTransformer implements FieldValueTransformerInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'ibexa_image';
    }

    public function encode(Field $field): EncodedFieldValue
    {
        return new EncodedFieldValue($field->getValue()->alternativeText ?? '');
    }

    /**
     * @param array<string, mixed> $metadata
     */
    public function decode(string $value, mixed $previousFieldValue, array $metadata): Value
    {
        $previousFieldValue->alternativeText = $value;

        return $previousFieldValue;
    }
}
