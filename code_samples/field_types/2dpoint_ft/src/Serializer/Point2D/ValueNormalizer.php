<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ValueNormalizer implements NormalizerInterface
{
    /**
     * @return array<?float, ?float>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            $object->getX(),
            $object->getY(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Value;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Value::class => true,
        ];
    }
}
