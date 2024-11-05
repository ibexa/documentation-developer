<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Cost;

use Ibexa\Contracts\Shipping\ShippingMethod\CostFormatterInterface;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

final class CustomCostFormatter implements CostFormatterInterface
{
    public function formatCost(ShippingMethodInterface $shippingMethod, array $parameters = []): ?string
    {
        return $shippingMethod->getOptions()->get('customer_identifier');
    }
}
