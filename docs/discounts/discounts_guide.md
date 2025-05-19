---
description: Discounts LTS Update enables reducing prices on products or product categories based on a detailed logic resolution.
month_change: false
---

# Discounts product guide

## What are Discounts

Just like brick-and-mortar shops, online stores use clever strategies to attract new customers, keep loyal ones, boost sales, highlight special products, and clear out inventory.

One powerful technique that helps achieve these goals is offering discounts.
Discounts allow online stores to temporarily or permanently reduce prices on specific products or categories, making deals more attractive to potential buyers.
They can be used to encourage first-time purchases, reward loyal customers, promote new or slow-moving items, or drive sales during seasonal events.
By displaying discounted prices clearly in the catalog or cart, businesses can create a sense of urgency, increase customer satisfaction, and ultimately boost revenue.

[[= product_name =]] can be equipped with the Discounts [LTS update](ibexa_dxp_v4.6.md#lts-updates), that introduces a highly extensible solution for building discounts.

Store managers can apply general discounts for products from the product catalogue or specific discounts for products in the customer's shopping cart.
Once the target is selected, they can set the type of discount by choosing a discount calculation rule.
Then they can use an extended set of conditions to decide when their discounts are applied.

Out of the box, the Discounts module delivers three types of discounts:

- "Fixed amount" - where a specified amount of money, for example, 5 Euro, is deducted from the base price
- "Percentage" - where a specified percentage, for example, 10%, is used to calculate the deducted amount
- "Buy X, get Y" - where customers purchase a specified number of items (X) and receive additional items (Y) for free or at a discounted price

A selection of conditions used to limit the applicability of a discount is broader, and includes, for example, rules that check whether:

- the product belongs to a specific category
- the customer belongs to a specific customer group
- the purchase is made within a defined timeframe
- a minimum purchase amount is met

!!! note "Difference between discounts and price rules"

    Unlike flexible and highly configurable discounts, [prices applied to customer groups](prices.md#custom-pricing) cannot have time limits, only apply to specific customer groups, and do not offer flexibility to adjust prices at cart level.

You can extend the solution's capabilities beyond the default setup by ...

## Availability

Discounts are an opt-in capability available as an [LTS update](editions.md#lts-updates) starting with the v4.6.XX version of [[= product_name =]], regardless of its edition.
To begin using Discounts, you must first [install the required packages and perform initial configuration](install_discounts.md).

## How it works

Discounts LTS update relies on an extensible AI framework, which is responsible for gathering information from various sources, such as Discount types, Discount configurations, and contextual details like SiteAccess, user details, locale settings, and more.
This data can then be combined with user input.
It's then passed to a service for final processing on [[= product_name =]] side.
...

### Core concepts

#### Promotion

Promotions are a marketing tool used to increase sales of certain products or product lines.
They enable sellers to apply various discounts to their stock, generate personalized discount coupons, and can follow strategic promotion schedules.

#### Discount

A a reduction in the usual price, a deduction applied to an online purchase, typically implemented as part of a marketing campaign.
Discounts can apply to specific items, shipping costs, total order amount and so on.

- Automatic discounts

...

- Discount codes (aka. coupons)

...

### 

## Capabilities

### Management

Users with the appropriate permissions, governed by role-based [policies](policies.md#disc ounts), can control the lifecycle of Discounts by creating, editing, executing, and deleting them.
Additionally, Discount configurations can be enabled or disabled depending on the organization's needs.

![Discount management screen](img/discount_list.png)

An intuitive Discounts interface displays a list of all available Discounts.
Here, you can search for specific discounts and filter them by type or status.
By accessing the detailed view of individual Discounts, you can quickly review all their parameters.

### Extensibility

Built-in Discount types offer a good starting point, but the real power of the Discounts lies in extensibility.
Extending Discounts opens up new possibilities for building promotional campaigns that help move stock and attach customers.
...

For example, [[= product_name =]] could apply a special discount when a customer places their 1st, 10th, or 100th order in the storefront.
This would encourages first-time purchases, repeat business, and long-term customer loyalty. 

## Use cases

Out of the box, the [[= product_name_base =]] Discounts LTS update comes with multiple discount types that can be applied in the following use cases.

### ...
