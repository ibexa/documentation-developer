<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use DateTimeInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\Participant\ParticipantCollectionInterface;
use Ibexa\Contracts\Collaboration\Session\AbstractSession;
use Ibexa\Contracts\Core\Repository\Values\User\User;

final class CartSession extends AbstractSession
{
    private CartInterface $cart;

    public function __construct(
        int $id,
        CartInterface $cart,
        string $token,
        User $owner,
        ParticipantCollectionInterface $participants,
        bool $isActive,
        bool $hasPublicLink,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt
    ) {
        $this->cart = $cart;
        parent::__construct($id, $token, $owner, $participants, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }
}
