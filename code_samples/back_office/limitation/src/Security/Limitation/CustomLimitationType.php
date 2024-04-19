<?php

declare(strict_types=1);

namespace App\Security\Limitation;

use Ibexa\Contracts\Core\Limitation\Type;
use Ibexa\Contracts\Core\Repository\Exceptions\NotImplementedException;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;
use Ibexa\Contracts\Core\Repository\Values\User\UserReference;
use Ibexa\Contracts\Core\Repository\Values\ValueObject;
use Ibexa\Core\Base\Exceptions\InvalidArgumentType;
use Ibexa\Core\FieldType\ValidationError;

class CustomLimitationType implements Type
{
    public function acceptValue(Limitation $limitationValue): void
    {
        if (!$limitationValue instanceof CustomLimitationValue) {
            throw new InvalidArgumentType(
                '$limitationValue',
                FieldGroupLimitation::class,
                $limitationValue
            );
        }
    }

    /** @return \Ibexa\Core\FieldType\ValidationError[] */
    public function validate(Limitation $limitationValue): array
    {
        $validationErrors = [];
        if (!array_key_exists('value', $limitationValue->limitationValues)) {
            $validationErrors[] = new ValidationError("limitationValues['value'] is missing.");
        } elseif (!is_bool($limitationValue->limitationValues['value'])) {
            $validationErrors[] = new ValidationError("limitationValues['value'] is not a boolean.");
        }

        return $validationErrors;
    }

    public function buildValue(array $limitationValues): CustomLimitationValue
    {
        $value = false;
        if (array_key_exists('value', $limitationValues)) {
            $value = $limitationValues['value'];
        } elseif (count($limitationValues)) {
            $value = (bool)$limitationValues[0];
        }

        return new CustomLimitationValue(['limitationValues' => ['value' => $value]]);
    }

    /**
     * @param \Ibexa\Contracts\Core\Repository\Values\ValueObject[]|null $targets
     *
     * @return bool|null
     */
    public function evaluate(Limitation $value, UserReference $currentUser, ValueObject $object, array $targets = null): ?bool
    {
        if (!$value instanceof CustomLimitationValue) {
            throw new InvalidArgumentException('$value', 'Must be of type: CustomLimitationValue');
        }

        if ($value->limitationValues['value']) {
            return Type::ACCESS_GRANTED;
        }

        // If the limitation value is not set to `true`, then $currentUser, $object and/or $targets could be challenged to determine if the access is granted or not; Here or elsewhere. When passing the baton, a limitation can return Type::ACCESS_ABSTAIN
        return Type::ACCESS_DENIED;
    }

    public function getCriterion(Limitation $value, UserReference $currentUser): CriterionInterface
    {
        throw new NotImplementedException(__METHOD__);
    }

    public function valueSchema(): void
    {
        throw new NotImplementedException(__METHOD__);
    }
}
