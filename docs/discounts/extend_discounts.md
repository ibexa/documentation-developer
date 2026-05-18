---
description: Extend Discounts by adding your own rules and conditions
editions:
    - lts-update
    - commerce
month_change: false
---

# Extend Discounts

By extending [Discounts](discounts_guide.md), you can increase flexibility and control over how promotions are applied to suit your unique business rules.
Together with the existing [events](event_reference.md) and the [Discounts PHP API](discounts_api.md), extending discounts gives you the ability to cover additional use cases related to selling products.

!!! tip

    If you prefer learning from videos, two presentations from Ibexa Summit 2025 cover the Discounts feature:

    - [_Introduction to the Discounts system in Ibexa DXP_](https://www.youtube.com/watch?v=kTgtxY38srw) by Konrad Oboza
    - [_Extending new Discounts to suit your needs_](https://www.youtube.com/watch?v=pDJxEKJLwPs) by Paweł Niedzielski

## Create custom conditions and rules

With custom [conditions](discounts_api.md#conditions) and [rules](discounts_api.md#rules) you can create more advanced discounts that apply only in specific scenarios.

For both of them, you need to specify their logic with [Symfony's expression language](https://symfony.com/doc/current/components/expression_language.html).

### Available expressions

You can use the following built-in expressions (variables and functions) in your own custom conditions and rules.
You can also [create your own](#custom-expressions).

| Type | Name | Value | Available for |
| --- | --- | --- | --- |
| Function | `get_current_region()` | [Region object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-RegionInterface.html) of the current siteaccess.| Conditions, rules |
| Function | `is_in_category()` | `true/false`, depending if a product belongs to given [product categories](pim_guide.md#product-categories).| Conditions, rules |
| Function | `is_user_in_customer_group()` | `true/false`, depending if an user belongs to given [customer groups](customer_groups.md). | Conditions, rules |
| Function | `calculate_purchase_amount()` | Purchase amount, calculated for all products in the cart before the discounts are applied.| Conditions, rules |
| Function | <nobr>`is_product_in_product_codes()`</nobr> | Parameters: <br> - [Product object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html)<br>- array of product codes<br> Returns `true` if the product is part of the given list.| Conditions, rules |
| Function | <nobr>`is_valid_discount_code()`</nobr> | Parameter: discount code (string). <br> Returns `true` if the discount code is valid for current user.| Conditions, rules |
| Variable | `cart` | [Cart object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-CartInterface.html) associated with current context.| Conditions, rules |
| Variable | `currency` | [Currency object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CurrencyInterface.html) of the current siteaccess. | Conditions, rules |
| Variable | `customer_group` | [Customer group object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CustomerGroupInterface.html) associated with given price context or the current user.| Conditions, rules |
| Variable | `product` | [Product object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html)| Conditions, rules |
| Variable | `amount` | Original price of the product | Rules |

### Custom expressions

You can create your own variables and functions to make creating the conditions easier.
The examples below show how to add an additional variable and a function to the available ones:

- New variable: `current_user_registration_date`

It's a [`DateTime`](https://www.php.net/manual/en/class.datetime.php) object with the registration date of the currently logged-in user.

To add it, create a class implementing the [`DiscountVariablesResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountVariablesResolverInterface.html):

``` php
[[= include_file('code_samples/discounts/src/Discounts/ExpressionProvider/CurrentUserRegistrationDateResolver.php') =]]
```

And mark it as a service using the `ibexa.discounts.expression_language.variable_resolver` service tag:

``` yaml
    App\Discounts\ExpressionProvider\CurrentUserRegistrationDateResolver:
        tags:
            - ibexa.discounts.expression_language.variable_resolver
```

- New function: `is_anniversary()`

It's a function returning a boolean value indicating if today is the anniversary of the date passed as an argument.
The function accepts an optional argument, `tolerance`, allowing you to extend the range of dates that are accepted as anniversaries.
This implementation is simplified and does not cover the approach for accounts created on February 29 during leap years.

``` php
[[= include_file('code_samples/discounts/src/Discounts/ExpressionProvider/IsAnniversaryResolver.php') =]]
```

Mark it as a service using the `ibexa.discounts.expression_language.function` service tag and specify the function name in the service definition.

``` yaml
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

The following example creates a new discount condition.
It allows you to offer a special discount for customers on the date when their account was created, making use of the expressions added above.

Create the condition by creating a class implementing the [`DiscountConditionInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountConditionInterface.html):

``` php hl_lines="29-32"
[[= include_file('code_samples/discounts/src/Discounts/Condition/IsAccountAnniversary.php') =]]
```

This condition can be used in both catalog and cart discounts.
To implement a cart-only discount, additionally implement the marker [`CartDiscountConditionInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-CartDiscountConditionInterface.html) interface.

The `tolerance` option is made available for usage in the expression by passing it in the constructor.
The `getExpression()` method contains the logic of the condition, expressed using the variables and functions available in the expression engine.
The expression must evaluate to `true` or `false`, indicating whether the condition is met.

The example uses three expressions:

- the custom `is_anniversary()` function, returning a value indicating whether today is user's registration anniversary
- the custom `current_user_registration_date` variable, holding the value of current user's registration date
- the custom `tolerance` variable, holding the acceptable tolerance (in days) for the calculation

For each custom condition class, you must create a dedicated condition factory, a class implementing the `\Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface` interface.

This allows you to create conditions when working in the context of the Symfony service container.

``` php
[[= include_file('code_samples/discounts/src/Discounts/Condition/IsAccountAnniversaryConditionFactory.php') =]]
```

Mark it as a service using the `ibexa.discounts.condition.factory` service tag and specify the condition's identifier.

``` yaml
    App\Discounts\Condition\IsAccountAnniversaryConditionFactory:
        tags:
            -   name: ibexa.discounts.condition.factory
                discriminator: !php/const App\Discounts\Condition\IsAccountAnniversary::IDENTIFIER
```

You can now use the condition, for example by using the PHP API or data migrations:

``` yaml hl_lines="16-19"
[[= include_file('code_samples/data_migration/examples/discounts/discount_create.yaml', 0, 2) =]]# ...
[[= include_file('code_samples/data_migration/examples/discounts/discount_create.yaml', 22, 33) =]]
        -
            identifier: is_account_anniversary
            expressionValues:
                tolerance: 5
```

To learn how to integrate it into the back office, see [Extend Discounts wizard](extend_discounts_wizard.md).

### Implement custom rules

The following example implements a [purchasing power parity](https://en.wikipedia.org/wiki/Purchasing_power_parity) discount, adjusting product's price in the cart based on buyer's region.
You could use it, for example, in regions sharing the same currency and apply the rule only to them by using the [`IsInRegions` condition](discounts_api.md#conditions).

To implement a custom rule, create a class implementing the [`DiscountRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountRuleInterface.html).

``` php hl_lines="35-38"
[[= include_file('code_samples/discounts/src/Discounts/Rule/PurchasingPowerParityRule.php') =]]
```

The `getExpression()` method contains the logic of the rule, expressed using the variables and functions available in the expression engine.
The expression must return the new price of the product.

It uses three expressions:

- the built-in `amount` variable, holding the purchase amount
- the built-in `get_current_region()` function, returning the current region
- a custom `power_parity_map` variable, holding the purchasing power parity map. It's defined in the constructor

As with conditions, create a dedicated rule factory:

``` php
[[= include_file('code_samples/discounts/src/Discounts/Rule/PurchasingPowerParityRuleFactory.php') =]]
```

Then, mark it as a service using the `ibexa.discounts.rule.factory` service tag and specify the rule's type.

``` yaml
    App\Discounts\Rule\PurchasingPowerParityRuleFactory:
        tags:
            - name: ibexa.discounts.rule.factory
              discriminator: !php/const App\Discounts\Rule\PurchasingPowerParityRule::TYPE
```

You can now use the rule with the PHP API, but to use it within the back office and storefront you need to:

- [integrate it into the Discounts wizard](extend_discounts_wizard.md)
- implement a new value formatter

### Custom discount value formatting

You can adjust how each discount type is displayed when using the [`ibexa_discounts_render_discount_badge` Twig function](discounts_twig_functions.md#ibexa_discounts_render_discount_badge) by implementing a custom formatter.

You must implement a custom formatter for each custom rule.

To do it, create a class implementing the [`DiscountValueFormatterInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountValueFormatterInterface.html) and use the `ibexa.discounts.value.formatter` service tag:

``` php
[[= include_file('code_samples/discounts/src/Discounts/Rule/PurchaseParityValueFormatter.php') =]]
```

``` yaml
    App\Discounts\Rule\PurchaseParityValueFormatter:
        tags:
            - name: ibexa.discounts.value.formatter
              rule_type: !php/const App\Discounts\Rule\PurchasingPowerParityRule::TYPE
```

## Change discount priority

You can change the [the default discount priority](discounts_guide.md#discounts-priority) by creating a class implementing the [`DiscountPrioritizationStrategyInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html) and aliasing to it the default implementation.

The example below decorates the default implementation to prioritize recently updated discounts above all the others.
It uses one of the existing [discount search criteria](discounts_criteria.md).

``` php
[[= include_file('code_samples/discounts/src/Discounts/RecentDiscountPrioritizationStrategy.php') =]]
```

``` yaml
    App\Discounts\RecentDiscountPrioritizationStrategy:
        decorates: Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface
        arguments:
            $inner: '@.inner'
```
