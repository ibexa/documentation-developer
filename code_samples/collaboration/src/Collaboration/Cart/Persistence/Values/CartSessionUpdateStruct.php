<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use App\Collaboration\Cart\CartSessionType;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getDiscriminator(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
