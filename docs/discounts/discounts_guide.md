---
description: Discounts LTS Update enables reducing prices on products or product categories based on a detailed logic resolution.
month_change: false
editions:
    - lts-update
    - commerce
---

# Discounts product guide

## What are Discounts

Just like brick-and-mortar shops, online stores use clever strategies to attract new customers, keep loyal ones, boost sales, highlight special products, and clear out inventory.

One powerful technique that helps achieve these goals is offering discounts.
Discounts allow online stores to temporarily or permanently reduce prices on specific products or categories, making deals more attractive to potential buyers.
They can be used to encourage first-time purchases, reward loyal customers, promote new or slow-moving items, or drive sales during seasonal events.
By displaying discounted prices clearly in the catalog or cart, businesses can create a sense of urgency, increase customer satisfaction, and ultimately boost revenue.

[[= product_name =]] can be equipped with the Discounts [LTS update](ibexa_dxp_v4.6.md#lts-updates), that introduces a highly extensible solution for building discounts.

Store managers can create general discounts that apply for products from the product catalog or specific discounts that apply for products in the customer's shopping cart.
Once the target is selected, they can set the type of discount by choosing a discount calculation rule.
Then they can use an extended set of conditions to decide when their discounts are applied.

Out of the box, the Discounts module delivers two types of discounts:

- "Fixed amount" - where a specified amount of money, for example, 5 Euro, is deducted from the base price of the product
- "Percentage" - where a specified percentage, for example, 10%, is used to calculate the deducted amount from the product

A selection of conditions used to limit the applicability of a discount is broader, and includes, for example, rules that check whether:

- the product belongs to a specific category
- the customer belongs to a specific customer group
- the purchase is made within a defined time frame
- a minimum purchase amount is met (per cart)
- a minimum quantity amount is met (per product)

!!! note "Difference between discounts and price rules"

    Unlike flexible and highly configurable discounts, [prices applied to customer groups](prices.md#custom-pricing) cannot have time limits, only apply to specific customer groups, and do not offer flexibility to adjust prices at cart level.

## Availability

Discounts are an opt-in capability available as an [LTS update](editions.md#lts-updates) starting with the v4.6.XX version of [[= product_name_com =]].
To begin using Discounts, you must first [install the required packages and perform initial configuration](install_discounts.md).

## How it works

The discount feature hooks into the price resolving logic of products, allowing you to modify it before it's displayed to the customers.

### Core concepts

#### Discounts

Discounts are reductions in the price of a product, typically implemented as part of a marketing campaign.

Discounts are applied in two places:

- **catalog** discounts are activated when browsing the product catalog and do not require any action from the customer to be activated
- **cart discounts** are activated when browsing the [cart](cart.md) and may require entering a discount code to be activated

A shopping cart can have multiple active discounts, but a specific product can only have a single discount applied at a time.

When two or more discounts could be applied to a single product, the system evaluates the following properties to choose the right one:

- discount activation place (cart discounts rank higher over catalog discounts)
- discount priority (higher priority ranks higher)
- creation date (newer discounts ranks higher)

The properties are evaluated in the order given above until a single discount is selected.

#### Discount properties

After choosing where the discount applies (catalog or cart), you can choose the discount type:

- "Fixed amount" - where a specified amount of money, for example, 5 Euro, is deducted from the base price of the product
- "Percentage" - where a specified percentage, for example, 10%, is used to calculate the deducted amount from the product

Discounts are translatable and are valid for specific [regions](pim_guide.md#regions)and currencies.
They can be permanent or be active only in a specified time frame.

The discount data is split into two parts: 

- name and description act internal information for the store managers
- promotion information acts as additional information displayed to the customers

#### Target groups

With discounts, you can target your entire customer base or only a subset of it belonging to specified [customer groups](customer_groups.md).

#### Product selection

All products, including [product variants](pim_guide.md#product-variants), can be selected when creating a discount. You can also limit this choice to a subset of products:

- belonging to selected [product categories](pim_guide.md#product-categoties)
- hand-picked manually for special cases

#### Conditions

For **cart discounts**, you can specify additional conditions that must be met for the discount to apply.

These conditions can include:

- minimum purchase quantity (per product)
- minimum purchase amount (total cart value)
- special discount codes

##### Discount codes

For **cart discounts**, you can specify an additional text value that needs to be entered during checkout for the discount to apply.

The discount code usage can be limited per customer:

- single use: every customer can use this code only once
- limited use: every customer can use the code a specified number of times
- unlimited

## Capabilities

### Management

Users with the appropriate permissions, governed by role-based policies, can control the lifecycle of Discounts by creating, editing, and deleting them.
Additionally, Discount configurations can be enabled or disabled depending on the organization's needs.

TODO
![Discount management screen](img/discount_list.png)

An intuitive Discounts interface displays a list of all available Discounts.
Here, you can search for specific discounts and filter them by type or status.
By accessing the detailed view of individual Discounts, you can quickly review all their parameters.

### Extensibility

Built-in Discount types offer a good starting point, but the real power of the Discounts lies in extensibility.
Extending Discounts opens up new possibilities for building promotional campaigns that help move stock and attach customers.

For example, [[= product_name =]] could apply a special discount when a customer places their 1st, 3rd, or 100th order in the storefront.
This would encourages first-time purchases, repeat business, and long-term customer loyalty.

## Use cases

Out of the box, the [[= product_name_base =]] Discounts LTS update comes with multiple discount types that can be applied in the following use cases.

### End of Season Sale

Create a permanent discount for products manufactured last season to increase attention for them.

### Temporary sales

Create urgency by offering promoted sales that are active only in a specified time frame to attract new customers or increase conversation, for example during events like Black Week or Cyber Monday.

### Reward loyal customers

Make your newsletters readers or chosen customer groups feel special by providing them with a dedicated discount that applies only to them, either by manually selecting a target audience, or by using a discount code.

### Reward large purchases

Encourage larger purchases and increase the average order size by applying an automatic discount when the purchase amount or quantity exceeds specified threshold.
