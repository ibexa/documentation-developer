---
description: The commerce component of Ibexa DXP covers various steps of making a transaction from listing available products, through adding products to a cart, to checkout and confirmation.
edition: commerce
page_type: landing_page
---

<head>
  <style>
    .tile {
      border-radius: 5px;
      border: 1px solid #c9c9d0;
      padding-left: 15px;
      padding-right: 15px;
      width: 30%;
      margin-right: 2%;
      margin-left: 2%;
      margin-top: 2%;
      margin-bottom: 2%;
      float: left;
      box-sizing: border-box;
      color: #ffffff;
    }

    @media (max-width: 900px) {
      .tile {
        width: 100%;
        float: none;
      }
    }

  </style>
</head>

# Test

The commerce component of [[= product_name =]] covers various steps of making a transaction,
from listing available products, through adding products to a cart, to checkout and confirmation.


<body>
<body>
  <div class="tile">
    <h4>Cart</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>
  
  <div class="tile">
    <h4>Checkout</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>
  
  <div class="tile">
    <h4>Order management</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>
  
  <div class="tile">
    <h4>Payment management</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>
  
  <div class="tile">
    <h4>Shipping management</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>
  <div class="tile">
    <h4>Storefront</h4>
    <ul>
      <li><a href="https://example.com">Random Site 1</a></li>
      <li><a href="https://example.com">Random Site 2</a></li>
      <li><a href="https://example.com">Random Site 3</a></li>
      <li><a href="https://example.com">Random Site 4</a></li>
    </ul>
  </div>  
</body>

[[= cards([
"commerce/commerce_cart",
"commerce/cart/cart",
"commerce/checkout/checkout",
"commerce/order_management/order_management",
"commerce/payment/payment",
"commerce/shipping_management/shipping_management",
"commerce/storefront/storefront"
], columns=4) =]]

## Configuration

[[= cards([
"commerce/checkout/configure_checkout",
"commerce/order_management/configure_order_management",
"commerce/payment/configure_payment",
"commerce/shipping_management/configure_shipment",
"commerce/storefront/configure_storefront"
], columns=4) =]]

## Customization

[[= cards([
"commerce/checkout/customize_checkout",
"commerce/payment/extend_payment",
"commerce/storefront/extend_storefront"
], columns=4) =]]

## API reference

[[= cards([
"commerce/cart/cart_api",
"commerce/checkout/checkout_api",
"commerce/order_management/order_management_api",
"commerce/payment/payment_api",
"commerce/payment/payment_method_api",
"commerce/shipping_management/shipping_method_api",
"commerce/shipping_management/shipment_api"
], columns=4) =]]
