<?php declare(strict_types=1);

namespace App\Security\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\SPI\Limitation\Type;

class CustomLimitationType implements Type
{
    public function acceptValue(Limitation $limitationValue)
    {
        if (!$limitationValue instanceof CustomLimitationValue) {
            throw new InvalidArgumentType(
                '$limitationValue',
                FieldGroupLimitation::class,
                $limitationValue
            );
        }
    }

    public function validate(Limitation $limitationValue)
    {
        return [];
    }

    public function buildValue(array $limitationValues)
    {
        $value = false;
        if (array_key_exists('value', $limitationValues)) {
            $value = $limitationValues['value'];
        } elseif (count($limitationValues)) {
            $value = (bool)$limitationValues[0];
        }

        return new CustomLimitationValue(['limitationValues' => ['value' => $value]]);
    }

    //TODO: evaluate(APILimitationValue $value, APIUserReference $currentUser, APIValueObject $object, array $targets = null)
}
