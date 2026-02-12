<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface;
use Ibexa\Contracts\Cart\Value\CartCreateStruct;
use Ibexa\Contracts\Cart\Value\CartQuery;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\EntryAddStruct as ShoppingListEntryAddStruct;
use Ibexa\Contracts\ShoppingList\Value\Query\Criterion\NameCriterion;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListCreateStruct;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;
use Ibexa\ProductCatalog\Local\Repository\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartShoppingListTransferController extends AbstractController
{
    public function __construct(
        private PermissionResolver $permissionResolver,
        private CurrencyServiceInterface $currencyService,
        private CartServiceInterface $cartService,
        private ShoppingListServiceInterface $shoppingListService,
        private CartShoppingListTransferServiceInterface $cartShoppingListTransferService,
        private ProductService $productService
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

        $user = $this->permissionResolver->getCurrentUserReference();
        $name = 'cart-shopping-list-transfer-test';

        $cartQuery = new CartQuery();
        $cartQuery->setOwnerId($user->getUserId());
        $cartsList = $this->cartService->findCarts($cartQuery);
        $cart = null;
        foreach ($cartsList->getCarts() as $cart) {
            if ($cart->getName() === $name) {
                break;
            }
            $cart = null;
        }
        if (null === $cart) {
            $cart = $this->cartService->createCart(new CartCreateStruct($name, $this->currencyService->getCurrencyByCode($currency), $user));
        }

        $lists = $this->shoppingListService->findShoppingLists(new ShoppingListQuery(new NameCriterion($name)));
        if ($lists->getTotalCount()) {
            $list = $lists->getShoppingLists()[0];
        } else {
            $list = $this->shoppingListService->createShoppingList(new ShoppingListCreateStruct($name));
        }

        $this->cartService->emptyCart($cart);
        $list = $this->shoppingListService->clearShoppingList($list);

        $list = $this->shoppingListService->addEntries($list, [new ShoppingListEntryAddStruct($productCode)]);

        $cart = $this->cartShoppingListTransferService->addSelectedEntriesToCart($list, [$list->getEntries()->getEntryWithProductCode($productCode)->getIdentifier()], $cart);

        dump(
            $list->getEntries()->hasEntryWithProductCode($productCode), // true as the entry is copied and not moved
            $cart->getEntries()->hasEntryForProduct($this->productService->getProduct($productCode)) // true
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
