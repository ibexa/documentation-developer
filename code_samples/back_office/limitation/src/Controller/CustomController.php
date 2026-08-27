<?php declare(strict_types=1);

namespace App\Controller;

use App\Security\Limitation\CustomLimitationValue;
use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\User\Controller\AuthenticatedRememberedCheckTrait;
use Ibexa\Contracts\User\Controller\RestrictedControllerInterface;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends Controller implements RestrictedControllerInterface
{
    use AuthenticatedRememberedCheckTrait {
        AuthenticatedRememberedCheckTrait::performAccessCheck as public traitPerformAccessCheck;
    }

    public function __construct(
        // ...,
        private readonly PermissionResolver $permissionResolver,
        private readonly PermissionCheckerInterface $permissionChecker
    ) {
    }

    // Controller actions...
    public function customAction(Request $request): Response
    {
        // ...
        if ($this->getCustomLimitationValue()) {
            // Action only for user having the custom limitation checked
        }

        return new Response('<html><body>...</body></html>');
    }

    private function getCustomLimitationValue(): bool
    {
        $hasAccess = $this->permissionResolver->hasAccess('custom_module', 'custom_function_2');

        if (is_bool($hasAccess)) {
            return $hasAccess;
        }

        $customLimitationValues = $this->permissionChecker->getRestrictions(
            $hasAccess,
            CustomLimitationValue::class
        );

        return $customLimitationValues['value'] ?? false;
    }

    #[\Override]
    public function performAccessCheck(): void
    {
        $this->traitPerformAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('custom_module', 'custom_function_2'));
    }
}
