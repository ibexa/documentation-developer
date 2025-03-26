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
     * @param Greeting $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return $this->normalizer->normalize(['greeting' => [
            'salutation' => $object->salutation,
            'recipient' => $object->recipient,
            'sentence' => "{$object->salutation} {$object->recipient}",
        ]], $format, $context);
        //var_dump($object);die('TODO: Implement normalize() method.');
    }
}
