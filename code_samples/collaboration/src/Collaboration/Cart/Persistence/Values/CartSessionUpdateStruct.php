<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use App\Collaboration\Cart\CartSessionType;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getDiscriminator(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
