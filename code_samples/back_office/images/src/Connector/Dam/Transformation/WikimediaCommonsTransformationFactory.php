<?php declare(strict_types=1);

namespace App\Connector\Dam\Transformation;

use Ibexa\Contracts\Connector\Dam\Variation\Transformation;
use Ibexa\Contracts\Connector\Dam\Variation\TransformationFactory as TransformationFactoryInterface;

class WikimediaCommonsTransformationFactory implements TransformationFactoryInterface
{
    public function build(?string $transformationName = null, array $transformationParameters = []): ?Transformation
    {
        $transformations = $this->buildAll();
        return $transformations[$transformationName] ?? null;
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
