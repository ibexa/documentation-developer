<?php declare(strict_types=1);

namespace App\Security\Limitation;

use eZ\Publish\API\Repository\Exceptions\NotImplementedException;
use eZ\Publish\API\Repository\Values\ContentType\ContentType;
use eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;
use eZ\Publish\API\Repository\Values\User\Limitation;
use eZ\Publish\API\Repository\Values\User\UserReference;
use eZ\Publish\API\Repository\Values\ValueObject;
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

    /**
     * @param \eZ\Publish\API\Repository\Values\ValueObject[]|null $targets
     *
     * @return bool|null
     */
    public function evaluate(Limitation $value, UserReference $currentUser, ValueObject $object, array $targets = null)
    {
        if (!$value instanceof CustomLimitationValue) {
            throw new InvalidArgumentException('$value', 'Must be of type: CustomLimitationValue');
        }

        if ($value->limitationValues['value']) {
            return Type::ACCESS_GRANTED;
        }

        /** @var ContentType $contentType */
        $contentType = $object;
        if (method_exists($object, 'getContentType')) { // Content, ContentInfo
            $contentType = $object->getContentType();
        } else if (method_exists($object, 'getContentInfo')) { // VersionInfo, Location
            $contentType = $object->getContentInfo()->getContentType();
        }
        if (!$contentType instanceof ContentType) {
            throw new InvalidArgumentException('$object', 'Must be of type: ContentType, Content, ContentInfo, VersionInfo or Location');
        }

        if ('user' !== $contentType->identifier) {
            return Type::ACCESS_GRANTED;
        }

        return Type::ACCESS_DENIED;
    }

    public function getCriterion(Limitation $value, UserReference $currentUser): CriterionInterface
    {
        throw new NotImplementedException(__METHOD__);
    }

    public function valueSchema()
    {
        throw new NotImplementedException(__METHOD__);
    }
}
