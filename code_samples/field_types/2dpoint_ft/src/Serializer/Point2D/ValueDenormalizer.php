<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ValueDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $class, string $format = null, array $context = [])
    {
        if (isset($data['x']) && isset($data['y'])) {
            // Support for old format
            $data = [$data['x'], $data['y']];
        }

        return new $class($data);
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Value::class;
    }
}
