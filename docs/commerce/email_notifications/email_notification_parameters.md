---
description: Extend Payment with custom payment method types.
edition: commerce
---

# Transactional email variables reference

The following variables are provided with an installation of [[= product_name_base =]].
You can use them when you create a template within an Actito transactional email campaign.
If this extensive list of variables is not sufficient, you can [extend it to include additional variables](extend_email_notifications.md#define-additional-variables).

|Category|Variable|Description|Example values|Notes|
|:----|:----|:----|:----|:----|
|Order processing|orderId|Order numerical ID|123|
| |orderIdentifier|Order identifier|660575f7-aa75-47af-b4d3-db2693f7e37c|
| |orderCurrency|Currency code|EUR|
| |orderSource|Order source|storefront|
| |orderValueNet|Total value (net)|€700,00|
| |orderValueGross|Total value (gross)|€749,50|
| |orderValueVat|Vat value|€49,50|
| |shippingAddressCountry|Country code|US|
| |shippingAddressRegion|Region|California|
| |shippingAddressLocality|City|Los Angeles|
| |shippingAddressStreet|Street|10250 Santa Monica Blvd|
| |shippingAddressPostalCode|Postal code|90067|
| |shippingAddressEmail|E-mail address|user@example.com|
| |shippingAddressPhoneNumber|Phone number|123456789|
| |billingAddressCountry|Country code|US|
| |billingAddressTaxId|Tax Identification Number i.e. VAT|12345678|
| |billingAddressRegion|Region|California|
| |billingAddressLocality|City|Los Angeles|
| |billingAddressStreet|Street|10250 Santa Monica Blvd|
| |billingAddressPostalCode|Postal code|90067|
| |billingAddressEmail|E-mail address|user@example.com|
| |billingAddressPhoneNumber|Phone number|123456789|
|Payment|paymentMethodIdentifier|Technical identifier of payment method| | |
| |paymentMethodName|Human readable name of payment method| | |
| |paymentMethodDescription|Human readable description of payment method|Prepaid cards and gift cards (offline ver.)| |
| |paymentMethodTypeName|Human readable name of payment method type|Offline| |
| |paymentStatus|Technical identifier of payment status|pending, failed|Only available in PaymentStatusChange notification|
|Shipment|shippingMethodIdentifier|Technical identifier of shipping method| | |
| |shippingMethodName|Human readable name of shipping method| | |
| |shippingMethodDescription|Human readable description of shipping method| | |
| |shippingMethodTypeName|Technical name of shipping method type| | |
| |shipmentStatus|Technical identifier of shipment status| |Only available in ShipmentStatusChange notification|
|Product information|products.id|Product numerical ID|123|
| |products.code|Product code, SKU|123456|
| |products.name|Product name|iPhone 15 Pro 256GB Space Gray|
| |products.url|Product view URL|https://example.com/product/iphone-15-pro-256gb-space-gray/|
| |products.thumbnail|Product thumbnail URL|https://example.com/assets/images/iphone-15-pro-256gb-space-gray.jpg|
| |products.quantity|Quantity|5|
| |products.unitPriceNet|Unit price (net)|€700,00|
| |products.unitPriceGross|Unit Price (gross)|€749,50|
| |products.subtotalPriceNet|Subtotal price (net), quantity * unit price (net)|€2700,00|
| |products.subtotalPriceGross|Subtotal price (gross), quantity * unit price (gross)|€2749,50|
|User information|userId|Numerical ID|255|
| |userLogin|User login|john.doe|
| |userEmail|User e-mail address|john.doe@example.com|
| |userName|User name|John Doe|
|Password reset|token|Token used to reset password|5bcc871f1a966db58c06187369813447|
| |passwordResetUrl|Absolute URL to reset password|http://example.com/user/reset-password/5bcc871f1a966db58c06187369813447|