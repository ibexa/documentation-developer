<?php declare(strict_types=1);

namespace App\Rest\Serializer;

use App\Rest\Values\Greeting;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GreetingInputDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        if ('json' === $format) {
            $data = $data[array_key_first($data)];
        }
        $data = array_change_key_case($data);

        $salutation = $data['salutation'] ?? 'Hello';
        $recipient = $data['recipient'] ?? 'World';

        return new Greeting($salutation, $recipient);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        if ('json' === $format) {
            $data = $data[array_key_first($data)];
        }
        $data = array_change_key_case($data);

        return Greeting::class === $type && is_array($data) &&
            (array_key_exists('salutation', $data) || array_key_exists('recipient', $data));
    }
}
