<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\User\Controller\AuthenticatedRememberedCheckTrait;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;

class CustomController extends Controller
{
    use AuthenticatedRememberedCheckTrait {
        AuthenticatedRememberedCheckTrait::performAccessCheck as public traitPerformAccessCheck;
    }

    public function performAccessCheck(): void
    {
        $this->traitPerformAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('custom_module', 'custom_function_2'));
    }
}
