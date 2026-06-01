<?php declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Ibexa\Discounts\Value\AbstractDiscountExpressionAware;

final class PurchasingPowerParityRule extends AbstractDiscountExpressionAware implements DiscountRuleInterface
{
    public const string TYPE = 'purchasing_power_parity';

    private const array DEFAULT_PARITY_MAP = [
        'default' => 100,
        'germany' => 81.6,
        'france' => 80,
        'spain' => 69,
    ];

    /** @param ?array<string, float> $powerParityMap */
    public function __construct(?array $powerParityMap = null)
    {
        parent::__construct(
            [
                'power_parity_map' => $powerParityMap ?? self::DEFAULT_PARITY_MAP,
            ]
        );
    }

    /** @return array<string, float> */
    public function getMap(): array
    {
        return $this->getExpressionValue('power_parity_map');
    }

    public function getExpression(): string
    {
        return 'amount * (power_parity_map[get_current_region().getIdentifier()] / power_parity_map["default"])';
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
