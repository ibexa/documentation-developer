<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Gateway;

final class DatabaseSchema
{
    public const string TABLE_NAME = 'ibexa_collaboration_cart';

    public const string COLUMN_ID = 'id';
    public const string COLUMN_CART_IDENTIFIER = 'cart_identifier';

    private function __construct()
    {
        // This class is not intended to be instantiated
    }
}
