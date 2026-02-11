<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\CartShoppingListTransferServiceInterface;
use Ibexa\Contracts\Cart\Value\CartCreateStruct;
use Ibexa\Contracts\Cart\Value\CartQuery;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface;
use Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface;
use Ibexa\Contracts\ShoppingList\Value\EntryAddStruct as ShoppingListEntryAddStruct;
use Ibexa\Contracts\ShoppingList\Value\Query\Criterion\NameCriterion;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListCreateStruct;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;
use Ibexa\ProductCatalog\Local\Repository\ProductService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:shopping-list:cart', description: 'Test transferring shopping list entries to cart')]
class CartShoppingListTransferCommand extends Command
{
    public function __construct(private UserService $userService, private PermissionResolver $permissionResolver, private CurrencyServiceInterface $currencyService, private CartServiceInterface $cartService, private ShoppingListServiceInterface $shoppingListService, private CartShoppingListTransferServiceInterface $cartShoppingListTransferService, private ProductService $productService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $login = 'admin';
        $currency = 'EUR';
        $productCode = 'TODO';

        $user = $this->userService->loadUserByLogin($login);
        $this->permissionResolver->setCurrentUserReference($user);

        $name = 'cart-shopping-list-transfer-test';

        $cartsList = $this->cartService->findCarts((new CartQuery())->setOwnerId($user->getId()));
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

        dump($list->getEntries()->hasEntryWithProductCode($productCode),
            $cart->getEntries()->hasEntryForProduct($this->productService->getProduct($productCode)));

        return $list->getEntries()->hasEntryWithProductCode($productCode) &&
        $cart->getEntries()->hasEntryForProduct($this->productService->getProduct($productCode)) ?
            Command::SUCCESS : Command::FAILURE;
    }
}
