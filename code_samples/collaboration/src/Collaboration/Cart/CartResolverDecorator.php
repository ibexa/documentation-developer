<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\CartResolverInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Values\User\User;
use Symfony\Component\HttpFoundation\RequestStack;

final class CartResolverDecorator implements CartResolverInterface
{
    public function __construct(
        private CartResolverInterface $innerCartResolver,
        private SessionServiceInterface $sessionService,
        private RequestStack $requestStack
    ) {
    }

    public function resolveCart(?User $user = null): CartInterface
    {
        if ($this->hasSharedCart()) {
            return $this->getSharedCart() ?? $this->innerCartResolver->resolveCart($user);
        }

        return $this->innerCartResolver->resolveCart($user);
    }

    private function getSharedCart(): ?CartInterface
    {
        /** @var \App\Collaboration\Cart\CartSession $session */
        try {
            $session = $this->sessionService->getSessionByToken(
                $this->requestStack->getSession()->get(PermissionResolverDecorator::COLLABORATION_SESSION_ID)
            );

            return $session->getCart();
        } catch (NotFoundException|\Ibexa\ProductCatalog\Exception\UnauthorizedException $e) {
            return null;
        }
    }

    private function hasSharedCart(): bool
    {
        return $this->requestStack->getSession()->has(PermissionResolverDecorator::COLLABORATION_SESSION_ID);
    }
}
