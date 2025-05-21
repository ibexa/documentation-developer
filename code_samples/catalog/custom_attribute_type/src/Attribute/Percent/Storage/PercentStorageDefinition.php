<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 *
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Attribute\Percent\Storage;

use Doctrine\DBAL\Types\Types;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageDefinitionInterface;
use Ibexa\ProductCatalog\Local\Persistence\Legacy\Attribute\Float\StorageSchema;

final class PercentStorageDefinition implements StorageDefinitionInterface
{
    public function getColumns(): array
    {
        return [
            StorageSchema::COLUMN_VALUE => Types::FLOAT,
        ];
    }

    public function getTableName(): string
    {
        return StorageSchema::TABLE_NAME;
    }
}
