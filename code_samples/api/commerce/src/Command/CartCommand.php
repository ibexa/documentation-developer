<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Cart\CartResolverInterface;
use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\Value\CartCreateStruct;
use Ibexa\Contracts\Cart\Value\CartMetadataUpdateStruct;
use Ibexa\Contracts\Cart\Value\CartQuery;
use Ibexa\Contracts\Cart\Value\EntryAddStruct;
use Ibexa\Contracts\Cart\Value\EntryUpdateStruct;
use Ibexa\Contracts\Checkout\Reorder\ReorderService;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\OrderServiceInterface;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Core\Repository\Permission\PermissionResolver;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:cart'
)]
final class CartCommand extends Command
{
    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private CartServiceInterface $cartService;

    private CurrencyServiceInterface $currencyService;

    private ProductServiceInterface $productService;

    private OrderServiceInterface $orderService;

    private ReorderService $reorderService;

    private CartResolverInterface $cartResolver;

    public function __construct(
        PermissionResolver $permissionResolver,
        UserService $userService,
        CartServiceInterface $cartService,
        CurrencyServiceInterface $currencyService,
        ProductServiceInterface $productService,
        OrderServiceInterface $orderService,
        ReorderService $reorderService,
        CartResolverInterface $cartResolver
    ) {
        $this->cartService = $cartService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->currencyService = $currencyService;
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->reorderService = $reorderService;
        $this->cartResolver = $cartResolver;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->permissionResolver->setCurrentUserReference(
            $this->userService->loadUserByLogin('admin')
        );

        // Query for carts
        $cartQuery = new CartQuery();
        $cartQuery->setOwnerId(14); // carts created by User ID: 14
        $cartQuery->setLimit(20); // fetch 20 carts

        $cartsList = $this->cartService->findCarts($cartQuery);

        $cartsList->getCarts(); // array of CartInterface objects
        $cartsList->getTotalCount(); // number of returned carts

        foreach ($cartsList as $cart) {
            $output->writeln($cart->getIdentifier() . ': ' . $cart->getName());
        }

        // Get a single cart
        $cart = $this->cartService->getCart('1844450e-61da-4814-8d82-9301a3df0054');

        $output->writeln($cart->getName());

        // Create a new cart
        $currency = $this->currencyService->getCurrencyByCode('EUR');

        $cartCreateStruct = new CartCreateStruct(
            'Default cart',
            $currency // Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface
        );

        $cart = $this->cartService->createCart($cartCreateStruct);

        $output->writeln($cart->getName()); // prints 'Default cart' to the console

        // Update a cart
        $newCurrency = $this->currencyService->getCurrencyByCode('PLN');

        $cartUpdateMetadataStruct = new CartMetadataUpdateStruct();
        $cartUpdateMetadataStruct->setName('New name');
        $cartUpdateMetadataStruct->setCurrency($newCurrency);

        $updatedCart = $this->cartService->updateCartMetadata($cart, $cartUpdateMetadataStruct);

        $output->writeln($updatedCart->getName()); // prints 'New name' to the console

        // Empty a cart
        $this->cartService->emptyCart($cart);

        // Validate a cart
        $violationList = $this->cartService->validateCart($cart); // Symfony\Component\Validator\ConstraintViolationListInterface

        // Add product to a cart
        $product = $this->productService->getProduct('desk1');

        $entryAddStruct = new EntryAddStruct($product);
        $entryAddStruct->setQuantity(10);

        $cart = $this->cartService->addEntry($cart, $entryAddStruct);

        $entry = $cart->getEntries()->first();
        $output->writeln($entry->getProduct()->getName()); // prints product name to the console

        // Remove an entry from a cart
        // find entry you would like to remove from cart
        $entry = $cart->getEntries()->first();

        $cart = $this->cartService->removeEntry($cart, $entry); // updated Cart object

        // Update entry in a cart
        $entryUpdateStruct = new EntryUpdateStruct(5);
        $entryUpdateStruct->setQuantity(10);

        $cart = $this->cartService->updateEntry(
            $cart,
            $entry,
            $entryUpdateStruct
        ); // updated Cart object

        // Delete a cart permanently
        $this->cartService->deleteCart($cart);

        // Get the order with items that should be reordered
        $orderIdentifier = '2e897b31-0d7a-46d3-ba45-4eb65fe02790';
        $order = $this->orderService->getOrderByIdentifier($orderIdentifier);

        // Get the cart to merge
        $existingCart = $this->cartResolver->resolveCart();

        $reorderCart = $this
            ->reorderService
            ->addToCartFromOrder($order, $this->reorderService->createReorderCart($order));

        // Merge the carts into the target cart and delete the merged carts
        $reorderCart = $this->cartService->mergeCarts($reorderCart, true, $existingCart);

        return self::SUCCESS;
    }
}
