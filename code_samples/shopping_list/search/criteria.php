<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\ShoppingList\Value\Query;
use Ibexa\Contracts\ShoppingList\Value\ShoppingListQuery;

/** @var PermissionResolver $permissionResolver */
$query = new ShoppingListQuery(
    new Query\Criterion\LogicalAnd(
        new Query\Criterion\OwnerCriterion($permissionResolver->getCurrentUserReference()),
        new Query\Criterion\IsDefaultCriterion(false)
    ),
    [
        new Query\SortClause\Name(),
    ]
);
