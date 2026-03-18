<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use App\Collaboration\Cart\CartSessionType;
use DateTimeImmutable;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionCreateStruct;

final class CartSessionCreateStruct extends AbstractSessionCreateStruct
{
    public function __construct(
        string $token,
        private string $cartIdentifier,
        int $ownerId,
        bool $isActive,
        bool $hasPublicLink,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        parent::__construct($token, $ownerId, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCartIdentifier(): string
    {
        return $this->cartIdentifier;
    }

    public function setCartIdentifier(string $cartIdentifier): void
    {
        $this->cartIdentifier = $cartIdentifier;
    }

    public function getDiscriminator(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
