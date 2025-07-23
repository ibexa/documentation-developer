<?php

declare(strict_types=1);

namespace App\Command;

use DateTimeImmutable;
use Ibexa\Contracts\Core\Collection\ArrayMap;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Discounts\DiscountServiceInterface;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountTranslationStruct;
use Ibexa\Contracts\DiscountsCodes\DiscountCodeServiceInterface;
use Ibexa\Contracts\DiscountsCodes\Value\Struct\DiscountCodeCreateStruct;
use Ibexa\Discounts\Value\DiscountCondition\IsInCurrency;
use Ibexa\Discounts\Value\DiscountCondition\IsInRegions;
use Ibexa\Discounts\Value\DiscountCondition\IsProductInArray;
use Ibexa\Discounts\Value\DiscountRule\FixedAmount;
use Ibexa\DiscountsCodes\Value\DiscountCondition\IsValidDiscountCode;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ManageDiscountsCommand extends Command
{
    protected static $defaultName = 'discounts:manage';

    private DiscountServiceInterface $discountService;

    private DiscountCodeServiceInterface $discountCodeService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    public function __construct(
        UserService $userSerice,
        PermissionResolver $permissionResolver,
        DiscountServiceInterface $discountService,
        DiscountCodeServiceInterface $discountCodeService
    ) {
        $this->userService = $userSerice;
        $this->discountService = $discountService;
        $this->discountCodeService = $discountCodeService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        $now = new DateTimeImmutable();

        $discountCodeCreateStruct = new DiscountCodeCreateStruct(
            'summer10',
            10, // Global usage limit
            null, // Unlimited usage
            $this->permissionResolver->getCurrentUserReference()->getUserId(),
            $now
        );
        $discountCode = $this->discountCodeService->createDiscountCode($discountCodeCreateStruct);

        $discountCreateStruct = new DiscountCreateStruct();
        $discountCreateStruct
            ->setIdentifier('discount_identifier')
            ->setType(DiscountType::CART)
            ->setPriority(10)
            ->setEnabled(true)
            ->setUser($this->userService->loadUserByLogin('admin'))
            ->setRule(new FixedAmount(10))
            ->setStartDate($now)
            ->setConditions([
                new IsInRegions(['germany', 'france']),
                new IsProductInArray(['product-1', 'product-2']),
                new IsInCurrency('EUR'),
                new IsValidDiscountCode(
                    $discountCode->getCode(),
                    $discountCode->getGlobalLimit(),
                    $discountCode->getUsedLimit()
                ),            ])
            ->setTranslations([
                new DiscountTranslationStruct('eng-GB', 'Discount name', 'This is a discount description', 'Promotion Label', 'Promotion Description'),
                new DiscountTranslationStruct('ger-DE', 'Discount name (German)', 'Description (German)', 'Promotion Label (German)', 'Promotion Description (German)'),
            ])
            ->setEndDate(null) // Permanent discount
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->setContext(new ArrayMap(['custom_context' => 'custom_value']));

        $this->discountService->createDiscount($discountCreateStruct);

        return Command::SUCCESS;
    }
}
