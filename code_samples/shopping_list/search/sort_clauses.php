<?php declare(strict_types=1);

use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\IsDefault;
use Ibexa\Contracts\ShoppingList\Value\Query\SortClause\Name;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

/** @var \Ibexa\Contracts\ShoppingList\ShoppingListServiceInterface $shoppingListService */
$lists = $shoppingListService->findShoppingLists(
    new ShoppingListQuery(
        null,
        [
            new IsDefault(IsDefault::SORT_DESC),
            new Name(),
        ]
    )
);
