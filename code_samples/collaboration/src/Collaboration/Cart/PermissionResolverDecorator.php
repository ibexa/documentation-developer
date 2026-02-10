<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\Permission\Policy\Cart\Edit as CartEdit;
use Ibexa\Contracts\Cart\Permission\Policy\Cart\View as CartView;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException;
use Ibexa\Contracts\ProductCatalog\Permission\Policy\PolicyInterface;
use Ibexa\Contracts\ProductCatalog\PermissionResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class PermissionResolverDecorator implements PermissionResolverInterface
{
    public const COLLABORATION_SESSION_ID = 'collaboration_session';

    private bool $nested = false;

    public function __construct(
        private PermissionResolverInterface $innerPermissionResolver,
        private SessionServiceInterface $sessionService,
        private RequestStack $requestStack,
    ) {
    }

    public function canUser(PolicyInterface $policy): bool
    {
        if ($this->nested === false && $this->isCartPolicy($policy) && $this->isSharedCart($policy->getObject())) {
            return true;
        }

        return $this->innerPermissionResolver->canUser($policy);
    }

    public function assertPolicy(PolicyInterface $policy): void
    {
        if ($this->nested === false && $this->isCartPolicy($policy) && $this->isSharedCart($policy->getObject())) {
            return;
        }

        $this->innerPermissionResolver->assertPolicy($policy);
    }

    private function isCartPolicy(PolicyInterface $policy): bool
    {
        return $policy instanceof CartView || $policy instanceof CartEdit;
    }

    private function isSharedCart(?CartInterface $cart): bool
    {
        if ($cart === null) {
            return false;
        }

        try {
            $this->nested = true;

            /** @var \App\Collaboration\Cart\CartSession $session */
            $session = $this->getCurrentCartCollaborationSession();
            if ($session !== null) {
                try {
                    return $cart->getId() === $session->getCart()->getId();
                } catch (NotFoundException $e) {
                }
            }
        } finally {
            $this->nested = false;
        }

        return false;
    }

    private function getCurrentCartCollaborationSession(): ?CartSession
    {
        $token = $this->requestStack->getSession()->get(self::COLLABORATION_SESSION_ID);
        if ($token === null) {
            return null;
        }

        try {
            $session = $this->sessionService->getSessionByToken($token);
            if ($session instanceof CartSession) {
                return $session;
            }
        } catch (NotFoundException|UnauthorizedException) {
        }

        return null;
    }
}
