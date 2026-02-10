<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Core\Repository\ProxyFactory\ProxyGeneratorInterface;
use ProxyManager\Proxy\LazyLoadingInterface;

final class CartProxyMapper implements CartProxyMapperInterface
{
    public function __construct(
        private Repository $repository,
        private CartServiceInterface $cartService,
        private ProxyGeneratorInterface $proxyGenerator
    ) {
    }

    public function createCartProxy(string $identifier): CartInterface
    {
        $initializer = function (
            &$wrappedObject,
            LazyLoadingInterface $proxy,
            $method,
            array $parameters,
            &$initializer
        ) use ($identifier): bool {
            $initializer = null;
            $wrappedObject = $this->repository->sudo(fn () => $this->cartService->getCart($identifier));

            return true;
        };

        return $this->proxyGenerator->createProxy(CartInterface::class, $initializer);
    }
}
