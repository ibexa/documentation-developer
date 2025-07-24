---
description: Discounts enable reducing prices on products or product categories based on a detailed logic resolution.
month_change: true
editions:
    - commerce
---

# Discounts API

## Manage discounts and discount codes

By integrating with the [Discount feature](discounts_guide.md) you can automate the process of managing discounts, streamlining the whole process and automating business rules.

For example, you can automatically create a discount when a customer places their 3rd order, encouraging them to make another purchase and increase their chances of becoming a loyal customer.

You can manage discounts using [data migrations](importing_data.md#discounts), [REST API](/api/rest_api/rest_api_reference/rest_api_reference.html#discounts), or the PHP API by using the [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html) service.

The core concepts when working with discounts through the APIs are listed below.

### Types

When using the PHP API, the discount type defines where the discount can be applied.

Discounts are applied in two places, listed in the [`DiscountType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountType.html) class:

- **Product catalog** - `catalog` discounts are activated when browsing the product catalog and do not require any action from the customer to be activated
- **Cart** - `cart` discounts can activate when entering the [cart](cart.md), if the right conditions are met. They may also require entering a discount code to be activated

Regardless of activation place, discounts always apply to products and reduce their base price.

To define when a discount activates and how the price is reduced, use rules and conditions.
They make use of the [Symfony Expression language]([[= symfony_doc=]]//components/expression_language.html).
Use the expression values provided below when using data migrations or when parsing REST API responses.

### Rules

Discount rules define how the calculate the price reduction.
The following discount rule types are available:

| Rule type | Identifier | Description | Expression value |
|---|---|---|---|
| `Ibexa\Discounts\Value\DiscountRule\FixedAmount` | <nobr>`fixed_amount`</nobr> | Deducts the specified amount, for example <nobr>10 EUR</nobr>, from the base price | <nobr>`discount_amount`</nobr> |
| `Ibexa\Discounts\Value\DiscountRule\Percentage` | <nobr>`percentage`</nobr> | Deducts the specified percentage, for example -10%, from the base price | <nobr>`discount_percentage`</nobr> |

Only a single discount can be applied to a given product, and a discount can only have a single rule.

### Conditions

With conditions you can narrow down the scenarios in which the discount applies. The following conditions are available:

| Condition | Applies to | Identifier | Description | Expression values |
|---|---|---|---|---|
| `Ibexa\Discounts\Value\DiscountCondition\IsInCategory` | Cart, Catalog | `is_in_category` | Checks if the product belongs to specified [product categories]([[= user_doc =]]/pim/work_with_product_categories/) | `categories` |
| `Ibexa\Discounts\Value\DiscountCondition\IsInCurrency` | Cart, Catalog |`is_in_currency` | Checks if the product has price in the specified currency | `currency_code` |
| `Ibexa\Discounts\Value\DiscountCondition\IsInRegions` | Cart, Catalog | `is_in_regions` | Checks if the customer is making the purchase in one of the specified regions | `regions` |
| `Ibexa\Discounts\Value\DiscountCondition\IsProductInArray` | Cart, Catalog| `is_product_in_array` | Checks if the product belongs to the group of selected products | `product_codes` |
| `Ibexa\Discounts\Value\DiscountCondition\IsUserInCustomerGroup` | Cart, Catalog| `is_user_in_customer_group` | Check if the customer belongs to specified [customer groups](customer_groups.md) | `customer_groups` |
| `Ibexa\Discounts\Value\DiscountCondition\IsProductInQuantityInCart` | Cart | `is_product_in_quantity_in_cart` | Checks if the required minimum quantity of a given product is present in the cart | `quantity` |
| `Ibexa\Discounts\Value\DiscountCondition\MinimumPurchaseAmount` | Cart | `minimum_purchase_amount` | Checks if purchase amount in the cart exceeds the specified minimum | `minimum_purchase_amount` |
| `Ibexa\DiscountsCodes\Value\DiscountCondition\IsValidDiscountCode` | Cart | `is_valid_discount_code` | Checks if the correct discount code has been provided and how many times it was used by the customer | `discount_code`, `usage_count` |

When multiple conditions are specified, all of them must be met.

### Priority

You can set discount priority as a number between 1 and 10 to indicate which discount should have [higher priority](discounts_guide.md#discounts-priority) when choosing the one to apply.

### Start and end date

Discounts can be permanent, or valid only in a specified time frame.

Every discount has a start date, which defaults to the date when the discount was created.
The end date can be set to `null` to make the discount permanent.

### Status

You can disable a discount anytime to stop it from being active, even if the conditions enforced by start and end date are met.

Only disabled discounts can be deleted.

### Discount translations

The discount has four properties that can be translated:

| Property | Usage |
|---|---|
| Name | Internal information for store managers |
| Description | Internal information for store managers |
| Promotion label | Information displayed to customers |
| Promotion description | Information displayed to customers |

Use the [`DiscountTranslationStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountTranslationStruct.html) to provide translations for discounts.

### Discount codes

To activate a cart discount only after a proper discount code is provided, you need to:

1. Create a discount code using the [`DiscountCodeServiceInterface::createDiscountCode()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-DiscountCodeServiceInterface.html#method_createDiscountCode) method
1. Attach it to a discount by using the `IsValidDiscountCode` condition

Set the [`usedLimit`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Struct-DiscountCodeCreateStruct.html#method___construct) property to the number of times a single customer can use this code, or to `null` to make the usage unlimited.

The [`DiscountCodeServiceInterface::registerUsage()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-DiscountCodeServiceInterface.html#method_registerUsage) method is used to track the number of times a discount code has been used.

### Example API usage

The example below contains a Command creating a cart discount. The discount:

- has the highest possible [priority](#priority) value
- [rule](#rules) deducts 10 EUR from the base price of the product
- is [permanent](#start-and-end-date)
- [depends](#conditions) on
    - being bought from Germany or France
    - 2 products
    - a `summer10` [discount code](#discount-codes) which can be used unlimited number of times

``` php hl_lines="60-66 68-92"
[[= include_file('code_samples/discounts/src/Command/ManageDiscountsCommand.php') =]]
```

Similarly, use the `deleteDiscount`, `deleteTranslation`, `disableDiscount`, `enableDiscount`, and `updateDiscount` methods from the [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html) to manage the discounts. You can always attach additional logic to the Discounts API by listening to the [available events](discounts_events.md).

## Search

You can search for Discounts using the [`DiscountServiceInterface::findDiscounts()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html#method_findDiscounts) method.
To learn more about the available search options, see Discounts' [Search Criteria](discounts_criteria.md) and [Sort Clauses](discounts_sort_clauses.md).

For discount codes, you can query the database for discount code usage using [`DiscountCodeServiceInterface::findCodeUsages()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-DiscountCodeServiceInterface.html#method_findCodeUsages) and [`DiscountCodeUsageQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Value-Query-DiscountCodeUsageQuery.html).
