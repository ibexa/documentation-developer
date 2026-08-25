<?php declare(strict_types=1);

namespace App\Form\Data;

final class ShareCartData
{
    public function __construct(
        private ?string $email = null
    ) {
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
