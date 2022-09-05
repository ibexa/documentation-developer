<?php

declare(strict_types=1);

namespace App\CodeGenerator\Strategy;

use Ibexa\Contracts\Core\Exception\InvalidArgumentException;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorContext;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorInterface;

final class CustomIncrementalCodeGenerator implements CodeGeneratorInterface
{
    public function generateCode(CodeGeneratorContext $context): string
    {
        if (!$context->hasBaseProduct()) {
            throw new InvalidArgumentException('$context', 'missing base product');
        }

        if (!$context->hasIndex()) {
            throw new InvalidArgumentException('$context', 'missing index');
        }

        return $context->getBaseProduct()->getCode() . 'v' . $context->getIndex();
    }
}
