<?php

declare(strict_types=1);

namespace App\CatalogFilter\DataTransformer;

use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class ProductNameCriterionTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof ProductName) {
            throw new TransformationFailedException('Expected a ' . ProductName::class . ' object.');
        }

        return $value->getName();
    }

    public function reverseTransform($value): ?ProductName
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException('Invalid data, expected a string value');
        }

        return new ProductName($value);
    }
}
