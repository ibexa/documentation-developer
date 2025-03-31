<?php declare(strict_types=1);

namespace App\Rest\Serializer;

use App\Rest\Values\Greeting;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @method array getSupportedTypes(?string $format)
 */
class GreetingNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function supportsNormalization(mixed $data, ?string $format = null)
    {
        return $data instanceof Greeting;
    }

    /**
     * @param \App\Rest\Values\Greeting $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $data = [
            'Salutation' => $object->salutation,
            'Recipient' => $object->recipient,
            'Sentence' => "{$object->salutation} {$object->recipient}",
        ];
        if ('json' === $format) {
            $data = ['Greeting' => $data];
        }

        return $this->normalizer->normalize($data, $format, $context);
    }
}
