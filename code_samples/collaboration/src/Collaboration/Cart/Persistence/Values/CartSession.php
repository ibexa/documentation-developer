<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use DateTimeImmutable;
use Ibexa\Collaboration\Persistence\Values\AbstractSession;

final class CartSession extends AbstractSession
{
    public function __construct(
        int $id,
        private readonly string $cartIdentifier,
        string $token,
        int $userId,
        bool $isActive,
        bool $hasPublicLink,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        parent::__construct($id, $token, $userId, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCartIdentifier(): string
    {
        return $this->cartIdentifier;
    }
}
