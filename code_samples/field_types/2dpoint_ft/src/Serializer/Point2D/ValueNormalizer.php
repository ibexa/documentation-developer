<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ValueNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            $object->getX(),
            $object->getY(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Value;
    }
}
