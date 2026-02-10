<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Collaboration\Session\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getType(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
