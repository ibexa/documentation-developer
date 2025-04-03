<?php declare(strict_types=1);

namespace App\Connector\Dam\Transformation;

use Ibexa\Contracts\Connector\Dam\Variation\Transformation;
use Ibexa\Contracts\Connector\Dam\Variation\TransformationFactory as TransformationFactoryInterface;

class WikimediaCommonsTransformationFactory implements TransformationFactoryInterface
{
    /** @param array<string, scalar> $transformationParameters */
    public function build(?string $transformationName = null, array $transformationParameters = []): Transformation
    {
        if (null === $transformationName) {
            return new Transformation(null, array_map('strval', $transformationParameters));
        }

        $transformations = $this->buildAll();

        if (array_key_exists($transformationName, $transformations)) {
            return $transformations[$transformationName];
        }

        throw new \InvalidArgumentException(sprintf('Unknown transformation "%s".', $transformationName));
    }

    public function buildAll(): array
    {
        return [
            'reference' => new Transformation('reference', []),
            'tiny' => new Transformation('tiny', ['width' => '30']),
            'small' => new Transformation('small', ['width' => '100']),
            'medium' => new Transformation('medium', ['width' => '200']),
            'large' => new Transformation('large', ['width' => '300']),
        ];
    }
}
