<?php declare(strict_types=1);

namespace App\Security\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;

class CustomLimitationValue extends Limitation
{
    public function getIdentifier(): string
    {
        return 'CustomLimitation';
    }
}
