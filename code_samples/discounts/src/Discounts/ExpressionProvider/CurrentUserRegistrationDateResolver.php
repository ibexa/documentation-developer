<?php declare(strict_types=1);

namespace App\Discounts\ExpressionProvider;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceContextInterface;

final readonly class CurrentUserRegistrationDateResolver implements DiscountVariablesResolverInterface
{
    public function __construct(private PermissionResolver $permissionResolver, private UserService $userService)
    {
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
