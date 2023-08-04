<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Payment\PaymentMethod\Voter;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodInterface;
use Ibexa\Contracts\Payment\PaymentMethod\Voter\AbstractVoter;

final class NewPaymentMethodTypeVoter extends AbstractVoter
{
    protected function getVote(PaymentMethodInterface $method, CartInterface $cart): bool
    {
        return true;
    }
}
