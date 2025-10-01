<?php declare(strict_types=1);

namespace App\Controller;

use App\Security\Limitation\CustomLimitationValue;
use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends Controller
{
    // ...
    /** @var \Ibexa\Contracts\Core\Repository\PermissionResolver */
    private $permissionResolver;

    /** @var \Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface */
    private $permissionChecker;

    public function __construct(
        // ...,
        PermissionResolver $permissionResolver,
        PermissionCheckerInterface $permissionChecker
    ) {
        // ...
        $this->permissionResolver = $permissionResolver;
        $this->permissionChecker = $permissionChecker;
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

    public function performAccessCheck(): void
    {
        parent::performAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('custom_module', 'custom_function_2'));
    }
}
