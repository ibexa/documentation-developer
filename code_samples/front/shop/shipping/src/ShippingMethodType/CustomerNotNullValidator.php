<?php

declare(strict_types=1);

namespace App\ShippingMethodType;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\Shipping\ShippingMethod\Type\OptionsValidatorError;
use Ibexa\Contracts\Shipping\ShippingMethod\Type\OptionsValidatorInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

final class CustomerNotNullValidator implements OptionsValidatorInterface, TranslationContainerInterface
{
    public const MESSAGE = 'Customer identifier value cannot be null';

    public function validateOptions(OptionsBag $options): array
    {
        $customerIdentifier = $options->get('customer_identifier');

        if ($customerIdentifier === null) {
            return [
                new OptionsValidatorError('[customer_identifier]', self::MESSAGE),
            ];
        }

        return [];
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create(self::MESSAGE, 'validators')->setDesc('Customer identifier value cannot be null'),
        ];
    }
}
