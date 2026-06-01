<?php declare(strict_types=1);

namespace App\Form\Data;

final class ShareCartData
{
    private ?string $email;

    public function __construct(
        ?string $email = null
    ) {
        $this->email = $email;
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
