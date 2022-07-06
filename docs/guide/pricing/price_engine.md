---
description: The price engine calculates product prices taking into account customer groups, currencies and taxes.
---

# Prices

The price engine is responsible for calculating prices in the shop.

It can, for example, calculate prices based on imported product information
and the business logic of an ERP system. 

It can combine the ERP logic and a local price provider to get the best compromise between real-time data and shop performance.
In addition, it offers fallbacks for when ERP is not available. 

## Price providers

The entry point for the price engine is [`ChainPriceService`](price_api/price_providers.md#chainpriceservice),
which determines a chain of price providers that are responsible for calculating the prices. 

In addition to prices, `ChainPriceService` can retrieve stock information,
since the ERP systems usually provide this information in the price request. 

|Provider|Logic|
|--- |--- |
|Shop price provider|Offers currency and customer group support|
|Remote price engine|Gets prices from the ERP|
