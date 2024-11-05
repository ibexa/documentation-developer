<?php declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Doctrine\DBAL\Types\Types;
use Ibexa\Contracts\Shipping\Local\ShippingMethod\StorageDefinitionInterface;
use Ibexa\Shipping\Persistence\Legacy\ShippingMethod\AbstractOptionsStorageSchema;

final class StorageDefinition implements StorageDefinitionInterface
{
    public function getColumns(): array
    {
        return [
            AbstractOptionsStorageSchema::COLUMN_SHIPPING_METHOD_REGION_ID => Types::INTEGER,
            StorageSchema::COLUMN_CUSTOMER_ID => Types::STRING,
        ];
    }

    public function getTableName(): string
    {
        return StorageSchema::TABLE_NAME;
    }
}
