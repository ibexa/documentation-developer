---
description: Explore the key features, functionalities, and advantages of the Commerce SDK that adds e-commerce capabilities to Cohesivo.
edition: commerce
month_change: false
---

# [[= product_name_commerce_sdk =]] product guide

## What is [[= product_name_commerce_sdk =]]

[[= product_name_commerce_sdk =]] is a package that you install on top of [[= product_name =]] to add e-commerce capabilities to your project.

Together with the content management, customization, and product catalog features of [[= product_name =]], it assists you in managing each aspect of your customers' journey in a single, dedicated solution.

With [[= product_name_commerce_sdk =]], you get a streamlined, unified platform where you can personalize each aspect of the online shopping experience.
You can completely revamp your online stores and give your consumers exceptional purchasing experiences, from first contact to post-purchase support.

![Ibexa Cloud - part of [[= product_name =]]](../getting_started/img/cloud_cohesivo_commercesdk_stack.png)

## Availability

To start using [[= product_name_commerce_sdk =]], you need an additional subscription.

[Contact us](https://cohesivo.com/en/about-us/contact-us) or [one of our partners](https://cohesivo.com/en/partners) to learn more about pricing.

## How it works

### Technical backstage

[[= product_name_commerce_sdk =]] requires [[= product_name =]].
After you have [installed [[= product_name =]]](../getting_started/install_cohesivo.md), you can [install [[= product_name_commerce_sdk =]]](../commerce/install_commerce_sdk.md) by using Composer.

Version control systems and environment variables allow you to deploy your extensions and settings on several environments, such as [[[= product_name_cloud =]]](../ibexa_cloud/ibexa_cloud_guide.md).

## Capabilities and benefits

With [[= product_name_commerce_sdk =]] you can focus on accelerating your transformation into a fully-fledged eCommerce.
It comes with all the necessary tools: personalized checkout workflows, payment gateway integration, order and shipping management, discounts, and more.

### Core features

[[= product_name_commerce_sdk =]] includes all the features you need to launch your online store and reduce the time it takes to go live.

#### Cart and Quick order

The [Cart](cart.md) component covers actions related to the creation and handling of a list of products that the buyer intends to purchase.
With the [Quick order](quick_order.md) form, registered and guest users can process orders with multiple items in bulk through the storefront: they fill in a form with product codes (SKU) and quantities, or upload their own list.

#### Checkout and Reorder

[Checkout](checkout.md) is a multi-step process that collects necessary transaction data, such as billing and shipping addresses, payment and shipping information, and allows buyers to place an order for cart items.
The component is highly configurable and extensible, so the checkout process can range between a straightforward and an extremely complicated one.
With [Reorder](reorder.md), customers can repeat their past purchases: based on a past order, the cart is recreated and validated.

#### Order management

With the advanced [Order management]([[= user_doc =]]/commerce/order_management/order_management/) tools, you can manage orders with ease.
Depending on your permissions, you can search for orders, review their details and updates, track completion status, and cancel orders that are created when store customers purchase products.
When searching for orders, you can use filters to save time and reduce effort.
Order management is strongly connected with other components of the [[= product_name_commerce_sdk =]], such as [Cart](cart.md) and [Checkout](checkout.md), so users can speed up the process by uploading an order list or repeating previous transactions.

![Order management](order_management.png)

#### Payment management

The [Payment](payment.md) component allows users to search for payment methods and payments, create new and manage existing payments and payment methods, and filter search results.
Users can also enable or disable payment methods, change payment details, and cancel payments, depending on their role.

![Payment management](payment_management.png)

#### Shipping management

With the [Shipping](shipping_management.md) component, users can create and manage shipments, search for shipments, filter search results, and define and manage various shipping methods.
Depending on their role, users can also enable or disable shipping methods, change status of shipments, and cancel shipments.

![Shipping management](shipping_management.png)

#### Storefront

The [Storefront](storefront.md) component includes a starter kit for developers.
It's a foundational set of components that developers can customize and extend to create their own web store implementations.
It contains default UI components and widgets that can be modified to [create a customized web store](customize_storefront_layout.md).

#### Discounts

With [Discounts](discounts.md), store managers can reduce prices on specific products or categories for all or selected customers.
Temporary or permanent discounts can be applied against items from the product catalog or cart.

#### Shopping list

A [shopping list](shopping_list_guide.md) allows users to save potential purchases, recurring product sets, and other items for future use in the cart.
A user can have several shopping lists, including a default one named "My Wishlist".

#### Relevant faceted search

Search becomes crucial when your product catalog is extensive.
Products can be sorted according to a variety of criteria using faceted search.
The value it brings makes it a vital component in merchandising.
You can set up your search engine to help clients find what they're looking for more easily, which could result in more purchases.

### Extensions

You can further extend [[= product_name_commerce_sdk =]] with [transactional emails](transactional_emails.md), by installing the Actito connector [add-on](cohesivo_products.md#add-ons).
Transactional emails are messages that [[= product_name =]] can send through the [Actito](https://actito.com/en) gateway to your end-users, to notify them about changes in the status of various actions taken in relation to your commerce presence.

## Use cases

#### Create personalized shopping experience

Use the [Raptor connector](raptor_connector_guide.md) [add-on](cohesivo_products.md#add-ons) to transform your online stores and give your consumers great buying experiences, from initial contact to post-purchase support.
No matter how complicated your product or sales process are, you can present your offer in an approachable way.
Creating engaging and personalized shopping experiences with targeted offers and recommendations helps you boost sales.
Within eCommerce, product recommendations can assist users in finding the exact item that meets their needs.
Recommendations can be used to propose related, alternative, or complimentary products to users who are unsure what to buy.

#### Use effective merchandising

Merchandising assists in keeping the consistency of the brand and providing customized product recommendations with captivating visuals and powerful search features.
You can engage your customers with eye-catching graphics and information.
The search engine makes it easy to find what they're looking for by providing quick and easy access to the product catalogs.

The customer experience takes an important step forward by facilitating financial transactions through the use of individualized product suggestions and unique pricing for various customer groups.

#### Launch consumer-facing web stores

[[= product_name_commerce_sdk =]] comes with all the features you need to launch and manage your web store, like storefront starter kit, real-time cart management, discounts, and more.
Together with the [product catalog](product_catalog_guide.md) of [[= product_name =]], it enables you to design flawless sales experiences regardless of the complexity of your business model.
You can create online store that really fits your needs.

#### Increase B2B sales

Together with the corporate account management and Customer Portal of [[= product_name =]], [[= product_name_commerce_sdk =]] helps you speed up your B2B digital transformation with tailored catalogs, customized workflows, effortless reordering, quick orders, custom pricing, and more.

#### Automate business processes

With [[= product_name_commerce_sdk =]], the automation process becomes easier, which is essential if your company wants to do more with less effort.
It comes with order management and integrates with the customer data and custom pricing of [[= product_name =]].
With [[= product_name_connect =]], you can integrate with over 1,300 standard apps, including your CRM, ERP, PIM, and DAM systems, and build custom connectors.
Also, you can use the ready-to-use pre-designed templates.
