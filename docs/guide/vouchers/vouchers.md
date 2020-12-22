# Vouchers [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] supports vouchers that are managed in ERP. The customer can enter a voucher number in the basket.
Then the voucher is sent to the ERP and, if it is valid, the customer gets a discount.

Voucher data is sent to the ERP in `PriceRequest` and `CreateOrderRequest`.
The price request contains the voucher code.

If enabled in the [configuration](#configuration), an additional line with negative quantity is also sent.
The ERP must respond with negative cost.

The ERP can send a message that the voucher is invalid. 
When this happens, a message is displayed in the basket.

## Configuration

``` yaml
twig:
    globals:
        voucher_active: true
```

With the `send_vouchers_as_lines` setting, you can configure whether the voucher is sent to ERP as an additional line with negative quantity (`true`)
or in the header (`false`):

``` yaml
parameters:
    siso_voucher.default.send_vouchers_as_lines: true
```

## VoucherManager

The `Siso/Bundle/VoucherBundle/Service/VoucherManager` service manages general voucher processes, like redeeming or removing the voucher.

``` php
//get the voucher manager
$voucherManager = $this->get('siso_voucher.voucher_manager'); 

//redeem the voucher
$voucherManager->redeemVoucherNumber($basket, $voucherNumber);

//remove the voucher
$voucherManager->removeVoucher($basket, $voucherNumber);
```
