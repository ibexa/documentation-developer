<?php declare(strict_types=1);

namespace App\Security\Limitation;

use Ibexa\Contracts\Core\Repository\Values\User\Limitation;

class CustomLimitationValue extends Limitation
{
    public function getIdentifier(): string
    {
        return 'CustomLimitation';
    }
}
