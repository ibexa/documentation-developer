# Commerce REST API

[[= product_name_com =]] extends the REST API of [[= product_name =]] with the following features:

## Basket API

| Feature | Method | Notes |
| ------- | ------ | ----- |
|Gets current basket	|`/api/ezp/v2/siso-rest/basket/current`||
|Reads list of baskets|	`/api/ezp/v2/siso-rest/basket/header/{basket_type}`|Returns wishlist/stored baskets|
|Updates party information in the basket|`/api/ezp/v2/siso-rest/basket/current/party/invoice (PATCH)`</br>`/api/ezp/v2/siso-rest/basket/current/party/delivery (PATCH)`</br>`/api/ezp/v2/siso-rest/basket/current/party/buyer (PATCH)`||
|Updates shipping information|	`/api/ezp/v2/siso-rest/basket/current/shippingmethod` ||
|Updates payment information|	`/api/ezp/v2/siso-rest/basket/current/paymentmethod`	||
|Updates and checks voucher|	`/api/ezp/v2/siso-rest/basket/current/voucher`||
|Adds a product to a basket|	`/api/ezp/v2/siso-rest/basket/current/lines`||
|Updates information in the basketline	|`/api/ezp/v2/siso-rest/basket/update` ||

## Checkout API

| Feature | Method |
| ------- | ------ |
|Gets list of payment methods | `/api/ezp/v2/siso-rest/checkout/payment-methods`	|
|Gets list of shipping methods | `/api/ezp/v2/siso-rest/checkout/shipping-methods`	|

## Common API

| Feature | Method |
| ------- | ------ |
|Gets list of payment methods | `/api/ezp/v2/siso-rest/country-selection` |

## Customer API

| Feature | Method |
| ------- | ------ |
|Gets list of shipping addresses from customer | `/api/ezp/v2/siso-rest/customer/addresses/shipping`|
