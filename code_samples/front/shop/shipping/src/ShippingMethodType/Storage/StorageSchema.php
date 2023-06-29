<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Ibexa\Shipping\Persistence\Legacy\ShippingMethod\AbstractOptionsStorageSchema;

final class StorageSchema extends AbstractOptionsStorageSchema
{
    public const TABLE_NAME = 'ibexa_shipping_method_region_custom';

    public const COLUMN_ID = 'id';
    public const COLUMN_CUSTOMER_ID = 'customer_id';
}
