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

## Create custom conditions

With custom [conditions](discounts_api.md#conditions) you can create more advanced discounts that apply only in specific scenarios.

The following example create discounts valid for your customers only on the anniversary of their account creation.
Having a custom condition allows you to model this scenario using a single discount, hiding all the complexity within the condition.

The logic for both the conditions and rules is specified using [Symfony's expression language](https://symfony.com/doc/current/components/expression_language.html).

### Available expressions

The following expressions are available for conditions and rules:

| Type | Name | Value | Available for | 
| --- | --- | --- | --- |
| Function | `get_current_region()` | [Region object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-RegionInterface.html) of the current siteaccess.| Conditions, rules |
| Function | `is_in_category()` | `true/false`, depending if a product belongs to given [product categories](pim_guide.md#product-categories).| Conditions, rules |
| Function | `is_user_in_customer_group()` | `true/false`, depending if a user belongs to given [customer groups](customer_groups.md). | Conditions, rules |
| Function | `calculate_purchase_amount()` | Purchase amount, calculated for all products in the cart before the discounts are applied.| Conditions, rules |
| Function | <nobr>`is_product_in_product_codes()`</nobr> | `true/false`, depending if the product is part of the given list.| Conditions, rules |
| Variable | `cart` | [Cart object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-CartInterface.html) associated with current context.| Conditions, rules |
| Variable | `currency` | [Currency object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CurrencyInterface.html) of the current siteaccess. | Conditions, rules |
| Variable | `customer_group` | [Customer group object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CustomerGroupInterface.html) associated with given price context or the current user.| Conditions, rules |
| Variable | `amount` | Original price of the product | Rules |
| Variable | `product` | [Product object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html)| Rules |

### Custom expressions

You can create your own variables and functions to make creating the conditions easier.
To create the condition checking the registration date, the following example will use an additinal variable and a function:

- `current_user`, a variable with the current [User object](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-User-User.html)

To add it, create a class implementing the [`DiscountVariablesResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountVariablesResolverInterface.html):

``` php
todo: verify
```

And mark it as a service using the `ibexa.discounts.expression_language.variable_resolver` service tag:

``` yaml
todo: verify
```

- `is_anniversary()`, a function returning a boolean value indicating if the two dates passed as arguments fall on the same day.

``` php
todo: verify
```

Mark it as a service using the `ibexa.discounts.expression_language.function` service tag and specify the function name in the service definition.

``` yaml
todo: verify
```

Two new expressions are now available for use in custom conditions and rules.

### Implement custom condition

Now, create the condition by creating a class implementing the [`DiscountConditionInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountConditionInterface.html).

``` php
todo: verify
```

The expression can evaluate to `true` or `false` depending on the custom expressions values.
An additional variable, `today`, is defined to store the current date for comparison.

For each condition class you must create a dedicated condition factory, a class implementing the `\Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface` inteface.

This allows you to create conditions when working in the context of the Symfony service container.

``` php
todo
```

Mark it as a service using the `ibexa.discounts.condition.factory` service tag and specify the condition's identifier.

``` yaml
todo
```

## Create custom rules

To implement a custom rule, create a class implementing the [`DiscountRuleInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountRuleInterface.html).

The following example implements a [purchasing power parity discount](https://en.wikipedia.org/wiki/Purchasing_power_parity), adjusting product's price in the cart based on buyer's region.

``` php
todo
```

As with conditions, create a dedicated rule factory.

``` php
todo
```

Mark it as a service using the `ibexa.discounts.condition.factory` service tag and specify the rule's type.

``` yaml
todo
```

### Custom discount formatting

You can adjust how each discount type is displayed when using the [`ibexa_discounts_render_discount_badge` Twig function](discounts_twig_functions.md#ibexa_discounts_render_discount_badge) by implementing a custom formatter.

To do it, create a class implementing the [`DiscountValueFormatterInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountValueFormatterInterface.html) and use the `ibexa.discounts.value.formatter` service tag:

``` php
todo
```

``` yaml
todo
```

## Change discount priority

You can change the [the defualt discount priority](discounts_guide.md#discounts-priority) by creating a class implementing the [`DiscountPrioritizationStrategyInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountPrioritizationStrategyInterface.html) and aliasing to it the default implementation.

The example below decorates the default implementation to prioritize recently created discounts above all the others.

``` php
todo
```

``` yaml
todo
```

## Form integration

### Condition

### Rules
