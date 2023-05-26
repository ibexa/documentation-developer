<?php

declare(strict_types=1);

namespace App\Payment;

use Ibexa\Contracts\Payment\PaymentMethod\Type\TypeInterface;

final class PayPal implements TypeInterface
{
    public function getIdentifier(): string
    {
        return 'paypal'; 
    }

    public function getName(): string
    {
        return 'PayPal';
    }
}
