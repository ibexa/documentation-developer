<?php declare(strict_types=1);

namespace App\Discounts\ExpressionProvider;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceContextInterface;

final class CurrentUserRegistrationDateResolver implements DiscountVariablesResolverInterface
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    public function __construct(PermissionResolver $permissionResolver, UserService $userService)
    {
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
    }

    /**
     * @return array{current_user_registration_date: \DateTimeInterface}
     */
    public function getVariables(PriceContextInterface $priceContext): array
    {
        return [
            'current_user_registration_date' => $this->userService->loadUser(
                $this->permissionResolver->getCurrentUserReference()->getUserId()
            )->getContentInfo()->publishedDate,
        ];
    }
}
