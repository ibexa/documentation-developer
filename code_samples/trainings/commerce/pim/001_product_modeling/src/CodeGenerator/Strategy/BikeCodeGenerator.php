<?php

declare(strict_types=1);

namespace App\CodeGenerator\Strategy;

use Ibexa\Contracts\Core\Exception\InvalidArgumentException;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorContext;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorInterface;

final class BikeCodeGenerator implements CodeGeneratorInterface
{
    public function generateCode(CodeGeneratorContext $context): string
    {
        if (!$context->hasBaseProduct()) {
            throw new InvalidArgumentException('$context', 'missing base product');
        }

        $frameSize = $context->getAttributes()['frame_size'];
        $wheelSize = $context->getAttributes()['wheel_diameter'];
        $frameShape = $context->getAttributes()['frame_shape'][0];
        $gearBundle = $context->getAttributes()['gear_bundle'];

        return $context->getBaseProduct()->getCode() . "--$frameSize-$wheelSize-$frameShape-$gearBundle";
    }
}
