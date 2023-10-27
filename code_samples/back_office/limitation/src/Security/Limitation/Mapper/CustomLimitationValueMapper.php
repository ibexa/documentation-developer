<?php

namespace App\Security\Limitation\Mapper;

use eZ\Publish\API\Repository\Values\User\Limitation;
use EzSystems\EzPlatformAdminUi\Limitation\LimitationValueMapperInterface;

class CustomLimitationValueMapper implements LimitationValueMapperInterface
{
    public function mapLimitationValue(Limitation $limitation)
    {
        return $limitation->limitationValues['value'];
    }
}
