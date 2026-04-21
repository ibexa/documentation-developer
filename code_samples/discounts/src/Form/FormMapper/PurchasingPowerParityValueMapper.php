<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Discounts\Rule\PurchasingPowerParityRule;
use App\Form\Data\PurchasingPowerParityValue;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountValueInterface;
use Ibexa\Contracts\Discounts\Admin\FormMapper\DiscountValueMapperInterface;
use Ibexa\Contracts\Discounts\Value\DiscountInterface;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountUpdateStruct;
use LogicException;

final class PurchasingPowerParityValueMapper implements DiscountValueMapperInterface
{
    public function createFormData(string $type, string $ruleType): DiscountValueInterface
    {
        if ($ruleType !== PurchasingPowerParityRule::TYPE) {
            throw new LogicException('Not implemented');
        }

        return new PurchasingPowerParityValue();
    }

    public function mapDiscountToFormData(DiscountInterface $discount): DiscountValueInterface
    {
        $discountRule = $discount->getRule();
        if (!$discountRule instanceof PurchasingPowerParityRule) {
            throw new LogicException('Not implemented');
        }

        return new PurchasingPowerParityValue();
    }

    public function mapCreateDataToStruct(
        DiscountValueInterface $data,
        DiscountCreateStruct $struct
    ): void {
        $this->addRuleToStruct($data, $struct);
    }

    public function mapUpdateDataToStruct(
        DiscountInterface $discount,
        DiscountValueInterface $data,
        DiscountUpdateStruct $struct
    ): void {
        $this->addRuleToStruct($data, $struct);
    }

    /**
     * @param \Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct|\Ibexa\Contracts\Discounts\Value\Struct\DiscountUpdateStruct $struct
     */
    private function addRuleToStruct(DiscountValueInterface $data, $struct): void
    {
        if (!$data instanceof PurchasingPowerParityValue) {
            throw new LogicException('Not implemented');
        }

        $rule = new PurchasingPowerParityRule();
        $struct->setRule($rule);
    }
}
