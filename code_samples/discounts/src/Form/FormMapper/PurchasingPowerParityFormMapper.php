<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Discounts\Rule\PurchasingPowerParityRule;
use Ibexa\Bundle\Discounts\Form\FormMapper\AbstractFormMapper;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

final class PurchasingPowerParityFormMapper extends AbstractFormMapper implements TranslationContainerInterface
{
    public function getDiscountRuleTypes(?string $type): array
    {
        return [PurchasingPowerParityRule::TYPE];
    }

    public function supports(string $type, string $ruleType): bool
    {
        return $ruleType === PurchasingPowerParityRule::TYPE;
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create(
                sprintf('%s.%s', self::TRANSLATION_PREFIX, PurchasingPowerParityRule::TYPE),
                'ibexa_discounts',
            )->setDesc('Regional'),
        ];
    }
}
