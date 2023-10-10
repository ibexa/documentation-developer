---
description: Storefront covers actions related to the purchase process.
edition: commerce
---

# Storefront

The Storefront package provides a starting kit for the developers.
It is a set of components that serves as a basis, which developers can 
customize and extend to create their own implementation of a web store.

## Default UI components

The Storefront package contains the following default UI components and widgets.
You can modify them when you build your own web store.

| Component | Description |
|------------|----------|
|Cancel order|Allows logged-in users to cancel their orders in a pending status.|
| Cart summary | Displays a subtotal net value of cart lines, a shipping cost disclaimer, a series of tax values applicable to products in cart, a composition of different taxes, and a total cart value (gross, shipping and taxes included). |
| Checkout | Displays a series of screens that allow buyers to place an order for cart items. |
| Currency menu | Enables selecting between currencies, to dynamically change the contents of the product listing page. |
| Language menu | Enables selecting between languages, to change an active language. |
| Login/register page |  Provides user interface for the login/registration page that enables buyers to access the Product catalog.|
| Main cart component | Main UI component of the cart. Displays a list of items selected for purchase and requested cart item quantities. Users can remove individual items. |
| Mini cart widget | Consists of a counter that displays a total number of items added to a cart. |
|Orders list|Displays a list of orders with such information as status, date, value, order ID. |
| Product category page | Displays products that belong to a specific category. |
| Product filters component | Allows for narrowing the list of products displayed in the listing by using different filters, such as product type, availability and price. |
| Product listing page | Allows for browsing through products, displays product name, code, price, and image. |
| Region menu | Enables selecting between regions, to dynamically change the contents of the product listing page. | 
| Reorder |Allows logged-in users to repurchase previously bought items. |
|Searching and filtering of orders| Allows logged-in users to search and filter their past orders on the orders page.|
| Search for specific product component | Allows for searching for products, for example on the product listing page. |
| Sort products component | Enables sorting products based on different criteria on a product listing page. |
| Quick order |Enables buyer to provide or upload a list of products, with their quantities, intended for purchase.|

To become familiar with a complete set of templates that covering all functionalities of a store, visit the `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront` directory of your installation.

!!! note "Customization and permissions"

    For more information about modifying the storefront components, whether by changing their appearance or modifying the underlying logic, see [Customize the storefront layout](../../templating/layout/customize_storefront_layout.md).

    For more information about overriding the default checkout component, see [Customize checkout](../checkout/customize_checkout.md).

    For information about roles and permissions that control access to various components of the purchase process, see [Permission use cases](permission_use_cases.md#commerce).