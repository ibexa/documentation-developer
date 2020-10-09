# Checkout functions

## getBasketPaymentMethods

`/api/ezp/v2/siso-rest/checkout/payment-methods (GET)`

Returns available payment options for the current basket.

Parameter-based default implementation can be replaced by overriding the service ID.

Standard service ID: `siso_rest_api.payment_methods_service`

### Request

empty

### Response

```
{
    "PaymentMethodDataResponse": {
        "_media-type": "application\/vnd.ez.api.PaymentMethodDataResponse+json",
        "paymentMethods": {
            "paypal": "paypal",
            "invoice": "invoice"
        },
        "defaultMethod": "invoice"
    }
}
```

## getBasketShippingMethods

`/api/ezp/v2/siso-rest/checkout/shipping-methods (GET)`

Returns available delivery options for the current basket.

Parameter-based default implementation can be replaced by overriding the service ID.

Standard service ID: `siso_rest_api.shipping_methods_service`

### Request

empty

### Response

```
{
    "ShippingMethodDataResponse": {
        "_media-type": "application\/vnd.ez.api.ShippingMethodDataResponse+json",
        "shippingMethods": {
            "LIEFERUNG": "standard_mail",
            "mail": "mail",
            "expressDel": "express_delivery"
        },
        "defaultMethod": "LIEFERUNG"
    }
}
```
