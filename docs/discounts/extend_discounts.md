---
description: Extend Discounts by adding your own rules and conditions
editions: 
    - lts-update
    - commerce
month_change: true
---

# Extend Discounts

By extending [Discounts](discounts_guide.md), you can increase flexibility and control over how promotions are applied to suit your unique business rules.
Together with the existing [events](event_reference.md) and the [Discounts PHP API](discounts_api.md), extending discounts gives you the ability to cover additional use cases related to selling products.

!!! tip

    If you prefer learning from videos, two presentations from Ibexa Summit 2025 cover the Discounts feature:

    - Konrad Oboza: [Introduction to the Discounts system in Ibexa DXP](https://www.youtube.com/watch?v=kTgtxY38srw)
    - Paweł Niedzielski: [Extending new Discounts to suit your needs](https://www.youtube.com/watch?v=pDJxEKJLwPs)

## Create custom conditions

With custom [conditions](discounts_api.md#conditions) you can create more advanced discounts that apply only in specific scenarios.

The logic for both the conditions and rules is specified using [Symfony's expression language](https://symfony.com/doc/current/components/expression_language.html).

### Available expressions

The following expressions are available for conditions and rules:

| Type | Name | Value | Available for | 
| --- | --- | --- | --- |
| Function | `get_current_region()` | [Region object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-RegionInterface.html) of the current siteaccess.| Conditions, rules |
| Function | `is_in_category()` | `true/false`, depending if a product belongs to given [product categories](pim_guide.md#product-categories).| Conditions, rules |
| Function | `is_user_in_customer_group()` | `true/false`, depending if an user belongs to given [customer groups](customer_groups.md). | Conditions, rules |
| Function | `calculate_purchase_amount()` | Purchase amount, calculated for all products in the cart before the discounts are applied.| Conditions, rules |
| Function | <nobr>`is_product_in_product_codes()`</nobr> | `true/false`, depending if the product is part of the given list.| Conditions, rules |
| Variable | `cart` | [Cart object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-CartInterface.html) associated with current context.| Conditions, rules |
| Variable | `currency` | [Currency object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CurrencyInterface.html) of the current siteaccess. | Conditions, rules |
| Variable | `customer_group` | [Customer group object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CustomerGroupInterface.html) associated with given price context or the current user.| Conditions, rules |
| Variable | `amount` | Original price of the product | Rules |
| Variable | `product` | [Product object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html)| Rules |

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
The function accepts an optional argument, `tolerance`, allowing you to extend the range of dates that are acccepted as anniversaries.

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

### Implement custom condition

The following example creates a new discount condition. It allows you to offer a special discount for customers on the date when their account was created, making use of the expressions added above.

The `tolerance` option allows you to make the discount usable for a longer period of time (for example, a day before or after the registration date) to allow more time for the customers to use it.

Create the condition by creating a class implementing the [`DiscountConditionInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountConditionInterface.html):

``` php
[[= include_file('code_samples/discounts/src/Discounts/Condition/IsAccountAnniversary.php') =]]
```

The `tolerance` option is made available for usage in the expression by passing it in the constructor.
The expression can evaluate to `true` or `false` depending on the custom expressions values.



For each custom condition class, you must create a dedicated condition factory, a class implementing the `\Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface` inteface.

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

You can now use the condition using the PHP API.

To learn how to integrate it into the back office, see [Extend Discounts wizard](extend_discounts_wizard.md).

## Create custom rules

The following example implements a [purchasing power parity](https://en.wikipedia.org/wiki/Purchasing_power_parity) discount, adjusting product's price in the cart based on buyer's region. 
You could use it, for example, in regions sharing the same currency and apply the rule only to them by using the [`IsInRegions` condition](discounts_api.md#conditions).

To implement a custom rule, create a class implementing the [`DiscountRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountRuleInterface.html).


``` php
[[= include_file('code_samples/discounts/src/Discounts/Rule/PurchasingPowerParityRule.php', 0, 42) =]]
```

As with conditions, create a dedicated rule factory:

``` php
[[= include_file('code_samples/discounts/src/Discounts/Rule/PurchasingPowerParityRuleFactory.php', 0, 14) =]]
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

You can change the [the defualt discount priority](discounts_guide.md#discounts-priority) by creating a class implementing the [`DiscountPrioritizationStrategyInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html) and aliasing to it the default implementation.

The example below decorates the default implementation to prioritize recently updated discounts above all the others.
It uses one of the existing [discount search criterions](discounts_criteria.md).

``` php
[[= include_file('code_samples/discounts/src/Discounts/RecentDiscountPrioritizationStrategy.php') =]]
```

``` yaml
    App\Discounts\RecentDiscountPrioritizationStrategy:
        decorates: Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface
        arguments:
            $inner: '@.inner'
```

