<?php

declare(strict_types=1);

namespace app\Payment\PaymentMethod\Voter;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodInterface;
use Ibexa\Contracts\Payment\PaymentMethod\Voter\AbstractVoter;

final class NewPaymentMethodTypeVoter extends AbstractVoter
{
    protected function getVote(PaymentMethodInterface $method, CartInterface $cart): bool
    {
        // Add custom logic if method should not always be visible 
        
        return true;
    }
}
