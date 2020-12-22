# Customer SKUs [[% include 'snippets/commerce_badge.md' %]]

In some projects, (B2B) customers know products by their own article number (SKU) that comes from the ERP.
When the customer e.g. searches for a product in the shop, they search for an article number that is only known to them.

The shop often knows these customer article numbers, because it imports them from ERP.
They are taken into account in search and quick order management.

## CustomerSkuService

Customer SKUs are handled by means of the `Silversolutions\Bundle\EshopBundle\Service\CustomerSkuService` (ID: `siso_core.customer_sku_service`).

`CustomerSkuService` is used to fetch the `sku` or `customer_sku`. For that purpose the following methods are available:

``` php
public function getSku($customerSku, $customerNumber = null)
public function getCustomerSku($sku, $customerNumber)
public function getOneByCustomerSku($customerSku, $customerNumber = null)
public function getOneBySku($sku, $customerNumber)
```

You can activate or deactivate `CustomerSkuService` using the `customer_sku_service_active` configuration parameter:

``` yaml
siso_core.default.customer_sku_service_active: true
```

## Twig functions

Two Twig functions can output SKUs in a template:

``` html+twig
{{ get_sku('customer_sku', 'customer_number') }}
{{ get_customer_sku('real_sku', ses.profile.sesUser.customerNumber) }}
```
