<?php declare(strict_types=1);

namespace App\Search\Serializer\Normalizer\Suggestion;

use App\Search\Model\Suggestion\ProductSuggestion;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductSuggestionNormalizer implements
    NormalizerInterface,
    NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @return array<string, string|null>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        /** @var \App\Search\Model\Suggestion\ProductSuggestion $object */
        return [
            'type' => 'product',
            'name' => $object->getName(),
            'productCode' => $object->getProduct()->getCode(),
            'productTypeIdentifier' => $object->getProduct()->getProductType()->getIdentifier(),
            'productTypeName' => $object->getProduct()->getProductType()->getName(),
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ProductSuggestion;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ProductSuggestion::class => true,
        ];
    }
}
