# Extend Discounts

Extend Discounts by adding your own rules and conditions

Editions: Commerce

By extending [Discounts](../discounts_guide/index.md), you can increase flexibility and control over how promotions are applied to suit your unique business rules. Together with the existing [events](../../api/event_reference/event_reference/index.md) and the [Discounts PHP API](../discounts_api/index.md), extending discounts gives you the ability to cover additional use cases related to selling products.

> **Tip: Tip**
>
> If you prefer learning from videos, two presentations from Ibexa Summit 2025 cover the Discounts feature:
>
> - [*Introduction to the Discounts system in Ibexa DXP*](https://www.youtube.com/watch?v=kTgtxY38srw) by Konrad Oboza
> - [*Extending new Discounts to suit your needs*](https://www.youtube.com/watch?v=pDJxEKJLwPs) by Paweł Niedzielski

## Create custom conditions and rules

With custom [conditions](../discounts_api/index.md#conditions) and [rules](../discounts_api/index.md#rules) you can create more advanced discounts that apply only in specific scenarios.

For both of them, you need to specify their logic with [Symfony's expression language](https://symfony.com/doc/current/components/expression_language.html).

### Available expressions

You can use the following built-in expressions (variables and functions) in your own custom conditions and rules. You can also [create your own](#custom-expressions).

| Type     | Name                            | Value                                                                                                                                                                                                                                           | Available for     |
| -------- | ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------- |
| Function | `get_current_region()`          | [Region object](../../../../../ibexa/product-catalog/src/contracts/Values/RegionInterface.php) of the current siteaccess.                                                                        | Conditions, rules |
| Function | `is_in_category()`              | `true/false`, depending if a product belongs to given [product categories](../../product_catalog/product_catalog_guide/index.md#product-categories).                                                                              | Conditions, rules |
| Function | `is_user_in_customer_group()`   | `true/false`, depending if an user belongs to given [customer groups](../../users/customer_groups/index.md).                                                                                                              | Conditions, rules |
| Function | `calculate_purchase_amount()`   | Purchase amount, calculated for all products in the cart before the discounts are applied.                                                                                                                                                      | Conditions, rules |
| Function | `is_product_in_product_codes()` | Parameters: - [Product object](../../../../../ibexa/product-catalog/src/contracts/Values/ProductInterface.php) - array of product codes Returns `true` if the product is part of the given list. | Conditions, rules |
| Function | `is_valid_discount_code()`      | Parameter: discount code (string). Returns `true` if the discount code is valid for current user.                                                                                                                                               | Conditions, rules |
| Variable | `cart`                          | [Cart object](../../../../../ibexa/cart/src/contracts/Value/CartInterface.php) associated with current context.                                                                                 | Conditions, rules |
| Variable | `currency`                      | [Currency object](../../../../../ibexa/product-catalog/src/contracts/Values/CurrencyInterface.php) of the current siteaccess.                                                                    | Conditions, rules |
| Variable | `customer_group`                | [Customer group object](../../../../../ibexa/product-catalog/src/contracts/Values/CustomerGroupInterface.php) associated with given price context or the current user.                           | Conditions, rules |
| Variable | `product`                       | [Product object](../../../../../ibexa/product-catalog/src/contracts/Values/ProductInterface.php)                                                                                                 | Conditions, rules |
| Variable | `amount`                        | Original price of the product                                                                                                                                                                                                                   | Rules             |

### Custom expressions

You can create your own variables and functions to make creating the conditions easier. The examples below show how to add an additional variable and a function to the available ones:

- New variable: `current_user_registration_date`

It's a [`DateTime`](https://www.php.net/manual/en/class.datetime.php) object with the registration date of the currently logged-in user.

To add it, create a class implementing the [`Ibexa\Contracts\Discounts\DiscountVariablesResolverInterface`](../../../../../ibexa/discounts/src/contracts/DiscountVariablesResolverInterface.php):

```php
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
```

And mark it as a service using the `ibexa.discounts.expression_language.variable_resolver` service tag:

```yaml
    App\Discounts\ExpressionProvider\CurrentUserRegistrationDateResolver:
        tags:
            - ibexa.discounts.expression_language.variable_resolver
```

- New function: `is_anniversary()`

It's a function returning a boolean value indicating if today is the anniversary of the date passed as an argument. The function accepts an optional argument, `tolerance`, allowing you to extend the range of dates that are accepted as anniversaries. This implementation is simplified and does not cover the approach for accounts created on February 29 during leap years.

```php
<?php declare(strict_types=1);

namespace App\Discounts\ExpressionProvider;

use DateTimeImmutable;
use DateTimeInterface;

final class IsAnniversaryResolver
{
    private const string YEAR_MONTH_DAY_FORMAT = 'Y-m-d';

    private const string MONTH_DAY_FORMAT = 'm-d';

    private const int REFERENCE_YEAR = 2000;

    public function __invoke(DateTimeInterface $date, int $tolerance = 0): bool
    {
        $d1 = $this->unifyYear(new DateTimeImmutable());
        $d2 = $this->unifyYear($date);

        $diff = $d1->diff($d2, true)->days;

        // Check if the difference between dates is within the tolerance
        return $diff <= $tolerance;
    }

    private function unifyYear(DateTimeInterface $date): DateTimeImmutable
    {
        // Create a new date using the reference year but with the same month and day
        $newDate = DateTimeImmutable::createFromFormat(
            self::YEAR_MONTH_DAY_FORMAT,
            self::REFERENCE_YEAR . '-' . $date->format(self::MONTH_DAY_FORMAT)
        );

        if ($newDate === false) {
            throw new \RuntimeException('Failed to unify year for date.');
        }

        return $newDate;
    }
}
```

Mark it as a service using the `ibexa.discounts.expression_language.function` service tag and specify the function name in the service definition.

```yaml
    App\Discounts\ExpressionProvider\IsAnniversaryResolver:
        tags:
            - name: ibexa.discounts.expression_language.function
              function: is_anniversary
```

Two new expressions are now available for use in custom conditions and rules.

When deciding whether to register a new custom variable or function, consider the following:

- variables are always evaluated by the expression engine and the result is available for all the rules and conditions specified in the discount
- functions are invoked only when the rule or condition using them is evaluated. If there are multiple conditions using them, they will be invoked multiple times

For performance reasons, it's recommended to:

- use variables only for lightweight calculations
- use functions for resource-intensive calculations (for example, checking customer's order history)
- implement caching (for example, in-memory) for function results to avoid redundant calculations when multiple discounts expressions might use the function
- specify the most resource-intensive conditions as the last to evaluate. As all conditions must be met for the discount to apply, it's possible to skip evaluating them if the previous ones won't be met

In a production implementation, you should consider refactoring the `current_user_registration_date` variable into a `get_current_user_registration_date` function to avoid always loading the current user object and improve performance.

### Implement custom condition

The following example creates a new discount condition. It allows you to offer a special discount for customers on the date when their account was created, making use of the expressions added above.

Create the condition by creating a class implementing the [`Ibexa\Contracts\Discounts\Value\DiscountConditionInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountConditionInterface.php):

```php
<?php declare(strict_types=1);

namespace App\Discounts\Condition;

use Ibexa\Contracts\Discounts\Value\DiscountConditionInterface;
use Ibexa\Discounts\Value\AbstractDiscountExpressionAware;

final class IsAccountAnniversary extends AbstractDiscountExpressionAware implements DiscountConditionInterface
{
    public const string IDENTIFIER = 'is_account_anniversary';

    public function __construct(?int $tolerance = null)
    {
        parent::__construct([
            'tolerance' => $tolerance ?? 0,
        ]);
    }

    public function getTolerance(): int
    {
        return $this->getExpressionValue('tolerance');
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function getExpression(): string
    {
        return 'is_anniversary(current_user_registration_date, tolerance)';
    }
}
```

This condition can be used in both catalog and cart discounts. To implement a cart-only discount, additionally implement the marker [`Ibexa\Contracts\Discounts\Value\CartDiscountConditionInterface`](../../../../../ibexa/discounts/src/contracts/Value/CartDiscountConditionInterface.php) interface.

The `tolerance` option is made available for usage in the expression by passing it in the constructor. The `getExpression()` method contains the logic of the condition, expressed using the variables and functions available in the expression engine. The expression must evaluate to `true` or `false`, indicating whether the condition is met.

The example uses three expressions:

- the custom `is_anniversary()` function, returning a value indicating whether today is user's registration anniversary
- the custom `current_user_registration_date` variable, holding the value of current user's registration date
- the custom `tolerance` variable, holding the acceptable tolerance (in days) for the calculation

For each custom condition class, you must create a dedicated condition factory, a class implementing the `\Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface` interface.

This allows you to create conditions when working in the context of the Symfony service container.

```php
<?php declare(strict_types=1);

namespace App\Discounts\Condition;

use Ibexa\Contracts\Discounts\Value\DiscountConditionInterface;
use Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface;

final class IsAccountAnniversaryConditionFactory implements DiscountConditionFactoryInterface
{
    public function createDiscountCondition(?array $expressionValues): DiscountConditionInterface
    {
        return new IsAccountAnniversary(
            $expressionValues['tolerance'] ?? null
        );
    }
}
```

Mark it as a service using the `ibexa.discounts.condition.factory` service tag and specify the condition's identifier.

```yaml
    App\Discounts\Condition\IsAccountAnniversaryConditionFactory:
        tags:
            -   name: ibexa.discounts.condition.factory
                discriminator: !php/const App\Discounts\Condition\IsAccountAnniversary::IDENTIFIER
```

You can now use the condition, for example by using the PHP API or data migrations:

```yaml
-   type: discount
    mode: create
# ...
    conditions:
        -   
            identifier: is_in_currency
            expressionValues: 
                currency_code: EUR
        -
            identifier: is_product_in_array
            expressionValues:
                product_codes: 
                    - product_code_book_0
                    - product_code_book_1

        -
            identifier: is_account_anniversary
            expressionValues:
                tolerance: 5
```

To learn how to integrate it into the back office, see [Extend Discounts wizard](../extend_discounts_wizard/index.md).

### Implement custom rules

The following example implements a [purchasing power parity](https://en.wikipedia.org/wiki/Purchasing_power_parity) discount, adjusting product's price in the cart based on buyer's region. You could use it, for example, in regions sharing the same currency and apply the rule only to them by using the [`IsInRegions` condition](../discounts_api/index.md#conditions).

To implement a custom rule, create a class implementing the [`Ibexa\Contracts\Discounts\Value\DiscountRuleInterface`](../../../../../ibexa/discounts/src/contracts/Value/DiscountRuleInterface.php).

```php
<?php declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Ibexa\Discounts\Value\AbstractDiscountExpressionAware;

final class PurchasingPowerParityRule extends AbstractDiscountExpressionAware implements DiscountRuleInterface
{
    public const string TYPE = 'purchasing_power_parity';

    private const array DEFAULT_PARITY_MAP = [
        'default' => 100,
        'germany' => 81.6,
        'france' => 80,
        'spain' => 69,
    ];

    /** @param ?array<string, float> $powerParityMap */
    public function __construct(?array $powerParityMap = null)
    {
        parent::__construct(
            [
                'power_parity_map' => $powerParityMap ?? self::DEFAULT_PARITY_MAP,
            ]
        );
    }

    /** @return array<string, float> */
    public function getMap(): array
    {
        return $this->getExpressionValue('power_parity_map');
    }

    public function getExpression(): string
    {
        return 'amount * (power_parity_map[get_current_region().getIdentifier()] / power_parity_map["default"])';
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
```

The `getExpression()` method contains the logic of the rule, expressed using the variables and functions available in the expression engine. The expression must return the new price of the product.

It uses three expressions:

- the built-in `amount` variable, holding the purchase amount
- the built-in `get_current_region()` function, returning the current region
- a custom `power_parity_map` variable, holding the purchasing power parity map. It's defined in the constructor

As with conditions, create a dedicated rule factory:

```php
<?php declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Ibexa\Discounts\Repository\DiscountRule\DiscountRuleFactoryInterface;

final class PurchasingPowerParityRuleFactory implements DiscountRuleFactoryInterface
{
    public function createDiscountRule(?array $expressionValues): DiscountRuleInterface
    {
        return new PurchasingPowerParityRule($expressionValues['power_parity_map'] ?? null);
    }
}
```

Then, mark it as a service using the `ibexa.discounts.rule.factory` service tag and specify the rule's type.

```yaml
    App\Discounts\Rule\PurchasingPowerParityRuleFactory:
        tags:
            - name: ibexa.discounts.rule.factory
              discriminator: !php/const App\Discounts\Rule\PurchasingPowerParityRule::TYPE
```

You can now use the rule with the PHP API, but to use it within the back office and storefront you need to:

- [integrate it into the Discounts wizard](../extend_discounts_wizard/index.md)
- implement a new value formatter

### Custom discount value formatting

You can adjust how each discount type is displayed when using the [`ibexa_discounts_render_discount_badge` Twig function](../../templating/twig_function_reference/discounts_twig_functions/index.md#ibexa_discounts_render_discount_badge) by implementing a custom formatter.

You must implement a custom formatter for each custom rule.

To do it, create a class implementing the [`Ibexa\Contracts\Discounts\DiscountValueFormatterInterface`](../../../../../ibexa/discounts/src/contracts/DiscountValueFormatterInterface.php) and use the `ibexa.discounts.value.formatter` service tag:

```php
<?php

declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\DiscountValueFormatterInterface;
use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Money\Money;

final class PurchaseParityValueFormatter implements DiscountValueFormatterInterface
{
    public function format(DiscountRuleInterface $discountRule, ?Money $money = null): string
    {
        return 'Regional discount';
    }
}
```

```yaml
    App\Discounts\Rule\PurchaseParityValueFormatter:
        tags:
            - name: ibexa.discounts.value.formatter
              rule_type: !php/const App\Discounts\Rule\PurchasingPowerParityRule::TYPE
```

## Change discount priority

You can change the [the default discount priority](../discounts_guide/index.md#discounts-priority) by creating a class implementing the [`Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface`](../../../../../ibexa/discounts/src/contracts/DiscountPrioritizationStrategyInterface.php) and aliasing to it the default implementation.

The example below decorates the default implementation to prioritize recently updated discounts above all the others. It uses one of the existing [discount search criteria](../../search/discounts_search_reference/discounts_criteria/index.md).

```php
<?php declare(strict_types=1);

namespace App\Discounts;

use Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface;
use Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt;

final readonly class RecentDiscountPrioritizationStrategy implements DiscountPrioritizationStrategyInterface
{
    public function __construct(private DiscountPrioritizationStrategyInterface $inner)
    {
    }

    public function getOrder(): array
    {
        return array_merge(
            [new UpdatedAt()],
            $this->inner->getOrder()
        );
    }
}
```

```yaml
    App\Discounts\RecentDiscountPrioritizationStrategy:
        decorates: Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface
        arguments:
            $inner: '@.inner'
```
