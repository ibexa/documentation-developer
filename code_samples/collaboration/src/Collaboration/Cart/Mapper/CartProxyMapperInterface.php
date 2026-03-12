<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use Ibexa\Contracts\Cart\Value\CartInterface;

interface CartProxyMapperInterface
{
    public function createCartProxy(string $identifier): CartInterface;
}
