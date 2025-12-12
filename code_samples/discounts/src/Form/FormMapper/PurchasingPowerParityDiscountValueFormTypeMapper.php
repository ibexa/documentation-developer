<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Form\Data\PurchasingPowerParityValue;
use App\Form\Type\DiscountValue\PurchasingPowerParityValueType;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountValueInterface;
use Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface;

final class PurchasingPowerParityDiscountValueFormTypeMapper implements DiscountValueFormTypeMapperInterface
{
    public function hasFormTypeForData(DiscountValueInterface $data): bool
    {
        return $data instanceof PurchasingPowerParityValue;
    }

    public function getFormTypeForData(DiscountValueInterface $data): ?string
    {
        return $data instanceof PurchasingPowerParityValue ? PurchasingPowerParityValueType::class : null;
    }

    public function getFormTypeOptionsForData(DiscountValueInterface $data): array
    {
        return [];
    }
}
