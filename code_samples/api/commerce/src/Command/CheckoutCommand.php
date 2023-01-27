<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Checkout\CheckoutServiceInterface;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\Repository\Permission\PermissionResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckoutCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private CartServiceInterface $cartService;

    private CheckoutServiceInterface $checkoutService;

    public function __construct(PermissionResolver $permissionResolver, UserService $userService, CartServiceInterface $cartService, CheckoutServiceInterface $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;

        parent::__construct('doc:checkout');
    }

    public function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        // Get checkout for a specific cart
        $cart = $this->cartService->getCart('d7424b64-7dc1-474c-82c8-1700f860d55e');

        $checkoutForCart = $this->checkoutService->getCheckoutForCart($cart);
        $checkoutId = $checkoutForCart->getIdentifier();

        // Get checkout by checkout ID
        $checkout = $this->checkoutService->getCheckout($checkoutId);

        // Create a new checkout
        $newCart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $checkoutCreateStruct = $this->checkoutService->newCheckoutCreateStruct($newCart);
        $newCheckout = $this->checkoutService->createCheckout($checkoutCreateStruct);

        $output->writeln($newCheckout->getIdentifier());

        // Update a checkout
        $checkoutToUpdate = $this->checkoutService->getCheckout('044df9af-a46c-4012-a3fc-bb7184f943a3');

        $checkoutUpdateStruct = $this->checkoutService->newCheckoutUpdateStruct('select_shipping');
        $this->checkoutService->updateCheckout($newCheckout, $checkoutUpdateStruct);

        // Delete a checkout
        $this->checkoutService->deleteCheckout($newCheckout);

        return self::SUCCESS;
    }
}
