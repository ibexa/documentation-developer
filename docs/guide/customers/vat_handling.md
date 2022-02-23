# VAT handling

The VAT handling for customers is controlled by:

1. The settings from the User Content item
1. Default settings configured in a YAML file, if the information is not set up in the Content item
1. Settings defined per SiteAccess, as a fallback

## VAT settings from the User Content item

The VAT handling can be defined per User. 

![](../img/customers_vat_setting.png)

Disable **Customer has to pay VAT** if for legal reasons the customer does not have to pay VAT. 
The shop will not calculate VAT.

If you disable **Display VAT**, the prices in the shop will be displayed without VAT.

## VAT settings from configuration

The same settings are available in configuration:

``` yaml
ibexa.commerce.customer_profile_data.isPriceInclVat: true
ibexa.commerce.customer_profile_data.setHasToPayVat: true
```
