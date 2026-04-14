<?php declare(strict_types=1);

namespace App\Controller;

use App\Collaboration\Cart\CartSession;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shared-cart/join/{token}', name: 'app.shared_cart.join')]
final class ShareCartJoinController extends AbstractController
{
    public const string CURRENT_COLLABORATION_SESSION = 'collaboration_session';

    public function __construct(
        private readonly SessionServiceInterface $sessionService,
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
