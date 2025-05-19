<?php

declare(strict_types=1);

namespace App\CodeGenerator\Strategy;

use Ibexa\Contracts\Core\Exception\InvalidArgumentException;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorContext;
use Ibexa\Contracts\ProductCatalog\Local\CodeGenerator\CodeGeneratorInterface;
use Ibexa\ProductCatalog\Local\Repository\CodeGenerator\CodeGeneratorRegistryInterface;

final class ProductTypeCodeGeneratorDispatcher implements CodeGeneratorInterface
{
    private CodeGeneratorRegistryInterface $codeGeneratorRegistry;

    private string $defaultCodeGeneratorIdentifier;

    private array $productTypeCodeGeneratorMap;

    public function __construct(CodeGeneratorRegistryInterface $codeGeneratorRegistry, string $defaultCodeGeneratorIdentifier = 'incremental', array $productTypeCodeGeneratorMap = [])
    {
        $this->codeGeneratorRegistry = $codeGeneratorRegistry;
        $this->defaultCodeGeneratorIdentifier = $defaultCodeGeneratorIdentifier;
        $this->productTypeCodeGeneratorMap = $productTypeCodeGeneratorMap;
    }

    public function generateCode(CodeGeneratorContext $context): string
    {
        if (!$context->hasBaseProduct()) {
            throw new InvalidArgumentException('$context', 'missing base product');
        }

        $productTypeIdentifier = $context->getBaseProduct()->getProductType()->getIdentifier();
        $codeGeneratorIdentifier = array_key_exists($productTypeIdentifier, $this->productTypeCodeGeneratorMap) ? $this->productTypeCodeGeneratorMap[$productTypeIdentifier] : $this->defaultCodeGeneratorIdentifier;

        if ($this->codeGeneratorRegistry->hasCodeGenerator($codeGeneratorIdentifier)) {
            return $this->codeGeneratorRegistry->getCodeGenerator($codeGeneratorIdentifier)->generateCode($context);
        } else {
            throw new InvalidArgumentException('$productTypeCodeGeneratorMap', "no code generator '$codeGeneratorIdentifier' registered");
        }
    }
}
