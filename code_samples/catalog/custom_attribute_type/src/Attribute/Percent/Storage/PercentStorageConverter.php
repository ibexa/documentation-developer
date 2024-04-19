<?php

declare(strict_types=1);

namespace App\Attribute\Percent\Storage;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageConverterInterface;
use Ibexa\ProductCatalog\Local\Persistence\Legacy\Attribute\Boolean\StorageSchema;
use Webmozart\Assert\Assert;

final class PercentStorageConverter implements StorageConverterInterface
{
    public function fromPersistence(array $data)
    {
        $value = $data[StorageSchema::COLUMN_VALUE];
        Assert::nullOrNumeric($value);

        return $value;
    }

    public function toPersistence($value): array
    {
        Assert::nullOrNumeric($value);

        return [
            StorageSchema::COLUMN_VALUE => $value,
        ];
    }
}
