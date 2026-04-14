<?php declare(strict_types=1);

namespace App\Attribute\Percent\Storage;

use Doctrine\DBAL\Types\Types;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageDefinitionInterface;

final class PercentStorageDefinition implements StorageDefinitionInterface
{
    public function getColumns(): array
    {
        return [
            'value' => Types::FLOAT,
        ];
    }

    public function getTableName(): string
    {
        return 'app_product_specification_attribute_percent';
    }
}
