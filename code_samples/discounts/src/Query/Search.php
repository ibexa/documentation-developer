<?php

declare(strict_types=1);

use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\Discounts\Value\Query\Criterion;
use Ibexa\Contracts\Discounts\Value\Query\DiscountQuery;
use Ibexa\Contracts\Discounts\Value\Query\SortClause;

$now = new DateTimeImmutable();

$query = new DiscountQuery(
    new Criterion\LogicalAnd(
        new Criterion\IsEnabledCriterion(),
        new Criterion\StartDateCriterion($now, FieldValueCriterion::COMPARISON_LTE),
        new Criterion\LogicalOr(
            new Criterion\EndDateCriterion($now, FieldValueCriterion::COMPARISON_GTE),
            new Criterion\EndDateCriterion(null, FieldValueCriterion::COMPARISON_EQ)
        ),
    ),
    [
        new SortClause\Type(),
        new SortClause\Priority(),
        new SortClause\CreatedAt(),
    ]
);

/** @var \Ibexa\Contracts\Discounts\DiscountServiceInterface $discountService */
$results = $discountService->findDiscounts($query);
