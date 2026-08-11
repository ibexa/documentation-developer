<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\Repository\Values\Content\Field;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\EncodedFieldValue;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Transformer\Field\FieldValueTransformerInterface;
use Ibexa\Core\Base\Exceptions\InvalidArgumentException;
use Ibexa\Core\FieldType\Image\Value as ImageValue;
use Ibexa\Core\FieldType\Value;

final class ImageAltTextTransformer implements FieldValueTransformerInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'ibexa_image';
    }

    public function encode(Field $field): EncodedFieldValue
    {
        $value = $field->getValue();
        if (!$value instanceof ImageValue) {
            throw new InvalidArgumentException(
                '$field',
                sprintf('Expected %s, got %s.', ImageValue::class, get_debug_type($value))
            );
        }

        return new EncodedFieldValue($value->alternativeText ?? '');
    }

    /**
     * @param array<string, mixed> $metadata
     */
    public function decode(string $value, mixed $previousFieldValue, array $metadata): Value
    {
        if (!$previousFieldValue instanceof ImageValue) {
            throw new InvalidArgumentException(
                '$previousFieldValue',
                sprintf('Expected %s, got %s.', ImageValue::class, get_debug_type($previousFieldValue))
            );
        }

        return new ImageValue([
            'id' => $previousFieldValue->id,
            'fileName' => $previousFieldValue->fileName,
            'fileSize' => $previousFieldValue->fileSize,
            'uri' => $previousFieldValue->uri,
            'imageId' => $previousFieldValue->imageId,
            'inputUri' => $previousFieldValue->inputUri,
            'width' => $previousFieldValue->width,
            'height' => $previousFieldValue->height,
            'alternativeText' => $value,
            'additionalData' => $previousFieldValue->additionalData,
            'mime' => $previousFieldValue->mime,
        ]);
    }
}
