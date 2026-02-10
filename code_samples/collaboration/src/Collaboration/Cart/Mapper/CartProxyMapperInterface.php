<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use Ibexa\Contracts\Cart\Value\CartInterface;

interface CartProxyMapperInterface
{
    public function createCartProxy(string $identifier): CartInterface;
}
