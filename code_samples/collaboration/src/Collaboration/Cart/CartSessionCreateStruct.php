<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\Session\AbstractSessionCreateStruct;

final class CartSessionCreateStruct extends AbstractSessionCreateStruct
{
    private CartInterface $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
        parent::__construct();
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function setCart(CartInterface $cart): void
    {
        $this->cart = $cart;
    }

    public function getType(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
