<?php declare(strict_types=1);

namespace App\Security\Limitation\Mapper;

use Ibexa\AdminUi\Limitation\LimitationValueMapperInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;

class CustomLimitationValueMapper implements LimitationValueMapperInterface
{
    public function mapLimitationValue(Limitation $limitation)
    {
        return $limitation->limitationValues['value'];
    }
}
