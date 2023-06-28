<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Ibexa\Contracts\Shipping\Local\ShippingMethod\StorageConverterInterface;

final class StorageConverter implements StorageConverterInterface
{
    public function fromPersistence(array $data)
    {
        $value['customer_identifier'] = $data['customer_id'];

        return $value;
    }

    public function toPersistence($value): array
    {
        return [
            StorageSchema::COLUMN_CUSTOMER_ID => $value['customer_identifier'],
        ];
    }
}
