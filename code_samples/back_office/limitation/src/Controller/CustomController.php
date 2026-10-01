<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\User\Controller\AuthenticatedRememberedCheckTrait;
use Ibexa\Contracts\User\Controller\RestrictedControllerInterface;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomController extends AbstractController implements RestrictedControllerInterface
{
    use AuthenticatedRememberedCheckTrait {
        AuthenticatedRememberedCheckTrait::performAccessCheck as private traitPerformAccessCheck;
    }

    #[\Override]
    public function performAccessCheck(): void
    {
        $this->traitPerformAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('section', 'view'));
    }

    #[Route('/custom-controller', name: 'app.custom_controller')]
    public function customAction(): Response
    {
        return new Response('<html><body>Access granted</body></html>');
    }
}
