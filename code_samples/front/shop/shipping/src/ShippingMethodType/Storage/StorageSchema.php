<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Ibexa\Shipping\Persistence\Legacy\ShippingMethod\AbstractOptionsStorageSchema;

final class StorageSchema extends AbstractOptionsStorageSchema
{
    public const string TABLE_NAME = 'ibexa_shipping_method_region_custom';
    public const string COLUMN_ID = 'id';
    public const string COLUMN_CUSTOMER_ID = 'customer_id';
}
