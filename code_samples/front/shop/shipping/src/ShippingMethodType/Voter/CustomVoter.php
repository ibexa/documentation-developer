<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Voter;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Shipping\ShippingMethod\Voter\AbstractVoter;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

final class CustomVoter extends AbstractVoter
{
    protected function getVote(ShippingMethodInterface $method, CartInterface $cart): bool
    {
        return $method->getOptions()->get('customer_identifier') === 'Acme';
    }
}
