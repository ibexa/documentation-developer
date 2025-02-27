<?php

namespace WikimediaCommonsConnector\Transformation;

use Ibexa\Platform\Contracts\Connector\Dam\Variation\Transformation;
use Ibexa\Platform\Contracts\Connector\Dam\Variation\TransformationFactory as TransformationFactoryInterface;

class TransformationFactory implements TransformationFactoryInterface
{
    public function build(?string $transformationName = null, array $transformationParameters = []): Transformation
    {
        return $this->buildAll()[$transformationName];
    }

    public function buildAll(): iterable
    {
        return [
            'reference' => new Transformation('reference'),
            'tiny' => new Transformation('tiny', ['width' => 30]),
            'small' => new Transformation('small', ['width' => 100]),
            'medium' => new Transformation('medium', ['width' => 200]),
            'large' => new Transformation('large', ['width' => 300]),
        ];
    }
}