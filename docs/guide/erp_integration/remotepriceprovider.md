---
edition: commerce
---

# RemotePriceProvider

`RemotePriceProvider` can contact an ERP system to get prices for one or more products.
To request prices from ERP, you must provide customer and optional contact number.

If the ERP system does not provide information about VAT, the VAT can be determined in the shop.
In that case the shop uses [VatService](../pricing/price_api/localvatservice.md) to get the `vatPercent` by the `vatCode`.

## Using customer and contact numbers

`RemotePriceProvider` uses customer and contact numbers from the price request.
If they are not set, it uses the numbers set in the Buyer Party.

If neither customer nor contact number are set, and template debitor is enabled in the configuration,
[StandardTemplateDebitorService](../pricing/price_api/standardtemplatedebitorservice.md) determines the customer and/or contact number to use.

``` yaml
siso_core.default.use_template_debitor_customer_number: true
siso_core.default.use_template_debitor_contact_number: true
```

!!! note

    Using a template debitor only works if price requests without customer number are enabled for the `RemotePriceProvider`.
    They can be enabled/disabled in the [shop configuration settings](../../guide/basket/basket.md).

    When this setting is disabled, an exception is thrown in the `remotePriceProvider` and fallback is used.
