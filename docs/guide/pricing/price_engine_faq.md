# Price engine FAQ

## Does the price engine support volume-based prices?

It depends on the price provider.

The remote price engine provides volume-based prices as defined in the ERP.

## How do I get delivery costs or additional costs?

The price provider returns such information as additional lines with a special type.

## How can I access stock information?

You can get stock information from `PriceLine` in `PriceResponse`:

``` php
$priceResponse = $priceService->getPrices($priceRequest, $contextId);

foreach ($priceResponse->getLines() as $priceLine) {
    //get stock
    $stockNumeric = $priceLine->getStockNumeric();
    if (isset($stockNumeric)) {
        $stock = new StockField(array('stockNumeric' => $stockNumeric));
        $productNode->setStock($stock);
    }
}
```

## How is currency handled?

It depends on the price provider.

- Local price provider uses the customer currency that is set in the price request.
- Remote price provider uses the currency returned from the ERP and if not set, also uses the customer currency.

## How can I find out which provider calculates my prices?

If the price provider calculates the prices, it sets a source type in `PriceResponse`.

Possible source types:

```
PriceConstants::PRICE_RESPONSE_SOURCE_TYPE_REMOTE = 'remote'
PriceConstants::PRICE_RESPONSE_SOURCE_TYPE_LOCAL = 'local'
```

``` php
//if the prices are not calculated by a remote source, set an error message in the basket
if ($priceResponse->getSourceType() !== PriceConstants::PRICE_RESPONSE_SOURCE_TYPE_REMOTE) {
    $basket->setErrorMessage(
        $this->transService->translate('Remote prices can not be calculated!')
    );
}
```

## What happens if ERP is not available?

For the basket, the local price provider calculates prices as a fallback.
The customer sees an error message that real-time prices are not available at the moment,
if the remote price provider is configured in the chain on the first place.

## When is an error message shown?

When the chain for the context ID is configured so that the first provider is remote
and the remote price calculation fails, en error message can be displayed.
The shop checks the chain for the context ID.
An error message can be displayed in the basket if the remote price calculation fails, but not in the wishlist.

You have to configure the service ID of the remote price provider:

``` yaml
siso_price.default.price_service_chain_remote: siso_price.price_provider.remote

siso_price.default.price_service_chain.basket:
 - siso_price.price_provider.remote
    - siso_price.price_provider.local

siso_price.default.price_service_chain.stored_basket:
 - siso_price.price_provider.local

siso_price.default.price_service_chain.wish_list:
 - siso_price.price_provider.local
```

## Why can's the user see prices on product detail page with the necessary Role?

Caching has to be configured to use `user-hash` in order to display the correct product detail page to anonymous or registered users.
If this is not done, the first call is cached for all users.

## Why can't a user see prices in sliders, catalog list, product detail or comparison?

The user doesn't have the necessary `siso_policy/see_product_price` Policy to see prices.
