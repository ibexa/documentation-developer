<?php
/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\DependencyInjection;

use Ibexa\ProductCatalog\Local\Persistence\Legacy\Attribute\Float\StorageDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddFloatStorageDefinitionTag implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition(StorageDefinition::class)
            ->addTag('ibexa.product_catalog.attribute.storage_definition', ['type' => 'percent']);
    }
}
