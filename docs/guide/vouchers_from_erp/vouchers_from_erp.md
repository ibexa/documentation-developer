# Vouchers from ERP

eZ Commerce supports vouchers that are managed in ERP. The customer can enter a voucher number in the basket.
Then the voucher is sent to the ERP and, if valid, the customer gets a discount.

## Configuration

``` yaml
twig:
    globals:
        # if false, vouchers are not active in the project
        voucher_active: true

parameters:
    # if true the voucher is sent to ERP as additional line with negative quantity
    # otherwise it is sent in the header
    siso_voucher.default.send_vouchers_as_lines: true
```

## VoucherManager

The `Siso/Bundle/VoucherBundle/Service/VoucherManager.php` service manages general voucher processes, like redeeming or removing the voucher.

``` php
$voucherNumber = '123456789';

$basketService = $this->getBasketService();
$basket = $basketService->getBasket($request);

//get the voucher manager
$voucherManager = $this->get('siso_voucher.voucher_manager'); 

//redeem the voucher
$voucherManager->redeemVoucherNumber($basket, $voucherNumber);

//remove the voucher
$voucherManager->removeVoucher($basket, $voucherNumber);
```
