<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Controller;

use App\Collaboration\Cart\CartSession;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/shared-cart/join/{token}', name: 'app.shared_cart.join')]
final class ShareCartJoinController extends AbstractController
{
    public const CURRENT_COLLABORATION_SESSION = 'collaboration_session';

    public function __construct(
        private SessionServiceInterface $sessionService,
    ) {
    }

    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $session = $this->sessionService->getSessionByToken($token);
        if ($session instanceof CartSession) {
            $request->getSession()->set(self::CURRENT_COLLABORATION_SESSION, $session->getToken());

            return $this->redirectToRoute('ibexa.cart.view', [
                'identifier' => $session->getCart()->getIdentifier(),
            ]);
        }

        throw $this->createAccessDeniedException();
    }
}
