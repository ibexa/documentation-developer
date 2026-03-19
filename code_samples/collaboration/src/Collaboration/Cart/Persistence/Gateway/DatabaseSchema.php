<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Gateway;

final class DatabaseSchema
{
    public const TABLE_NAME = 'ibexa_collaboration_cart';

    public const COLUMN_ID = 'id';
    public const COLUMN_CART_IDENTIFIER = 'cart_identifier';

    private function __construct()
    {
        // This class is not intended to be instantiated
    }
}
