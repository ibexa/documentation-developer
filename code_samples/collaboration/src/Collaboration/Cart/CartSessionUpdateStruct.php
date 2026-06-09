<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Collaboration\Session\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getType(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
