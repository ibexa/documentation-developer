<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface;
use Ibexa\Contracts\Cart\Value\CartCreateStruct;
use Ibexa\Contracts\Cart\Value\CartQuery;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\EntryAddStruct as ShoppingListEntryAddStruct;
use Ibexa\Contracts\ShoppingList\Value\Query\Criterion\NameCriterion;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListCreateStruct;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartShoppingListTransferController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver,
        private readonly CurrencyServiceInterface $currencyService,
        private readonly CartServiceInterface $cartService,
        private readonly ShoppingListServiceInterface $shoppingListService,
        private readonly CartShoppingListTransferServiceInterface $cartShoppingListTransferService,
        private readonly LocalProductServiceInterface $productService
    ) {
    }

    #[Route(
        path: '/app-shopping-list-cart',
        name: 'app.shopping-list.cart',
        methods: ['GET']
    )]
    public function __invoke(Request $request): Response
    {
        $currency = 'EUR';
        $productCode = 'TODO';

        $user = $this->userService->loadUser($this->permissionResolver->getCurrentUserReference()->getUserId());
        $name = 'cart-shopping-list-transfer-test';

        $cartQuery = new CartQuery();
        $cartQuery->setOwnerId($user->getId());
        $cartsList = $this->cartService->findCarts($cartQuery);
        $cart = null;
        foreach ($cartsList->getCarts() as $cartItem) {
            if ($cartItem->getName() === $name) {
                $cart = $cartItem;
                break;
            }
        }
        if (null === $cart) {
            $cart = $this->cartService->createCart(new CartCreateStruct($name, $this->currencyService->getCurrencyByCode($currency), $user));
        }

        $lists = $this->shoppingListService->findShoppingLists(new ShoppingListQuery(new NameCriterion($name)));
        if ($lists->getTotalCount() > 0) {
            $list = $lists->getShoppingLists()[0];
        } else {
            $list = $this->shoppingListService->createShoppingList(new ShoppingListCreateStruct($name));
        }

        $this->cartService->emptyCart($cart);
        $list = $this->shoppingListService->clearShoppingList($list);

        $list = $this->shoppingListService->addEntries($list, [new ShoppingListEntryAddStruct($productCode)]);

        $entry = $list->getEntries()->getEntryWithProductCode($productCode)->getIdentifier(); // Get entry's automatically generated identifier
        $cart = $this->cartShoppingListTransferService->addSelectedEntriesToCart($list, [$entry], $cart);
        $cart = $this->cartShoppingListTransferService->addSelectedEntriesToCart($list, [$entry], $cart);

        dump(
            $list->getEntries()->hasEntryWithProductCode($productCode), // true as the entry is copied and not moved
            $cart->getEntries()->getEntryForProduct($this->productService->getProduct($productCode))->getQuantity() // 2 as the entry was added twice
        );

        $list = $this->shoppingListService->clearShoppingList($list); // Empty the list to avoid duplicate and test the move from cart

        $list = $this->cartShoppingListTransferService->moveCartToShoppingList($cart, $list);
        $cart = $this->cartService->getCart($cart->getIdentifier()); // Refresh local object from persistence

        dump(
            $list->getEntries()->hasEntryWithProductCode($productCode), // true as, after the clear, the entry is moved from cart
            $cart->getEntries()->hasEntryForProduct($this->productService->getProduct($productCode)) // false as the entry was moved
        );

        return new Response('<html><head></head><body></body></html>');
    }
}
