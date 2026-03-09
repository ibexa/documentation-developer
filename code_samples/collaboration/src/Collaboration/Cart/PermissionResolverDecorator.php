<?php declare(strict_types=1);

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
    public const string COLLABORATION_SESSION_ID = 'collaboration_session';

    private bool $nested = false;

    public function __construct(
        private readonly PermissionResolverInterface $innerPermissionResolver,
        private readonly SessionServiceInterface $sessionService,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function canUser(PolicyInterface $policy): bool
    {
        $object = $policy->getObject();
        if ($this->nested === false && $this->isCartPolicy($policy) && $object instanceof CartInterface && $this->isSharedCart($object)) {
            return true;
        }

        return $this->innerPermissionResolver->canUser($policy);
    }

    public function assertPolicy(PolicyInterface $policy): void
    {
        $object = $policy->getObject();
        if ($this->nested === false && $this->isCartPolicy($policy) && $object instanceof CartInterface && $this->isSharedCart($object)) {
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
                } catch (NotFoundException) {
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
