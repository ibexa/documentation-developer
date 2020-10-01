# Checkout FAQ

## Can I extend the size limit on orders?

Due to a restriction in JmsPaymentBundle, an order exceding 99999.99999 causes an error message.

It is possible to extend this limit using an [official workaround for the JMSPaymentCoreBundle.](http://jmspaymentcorebundle.readthedocs.io/en/latest/guides/overriding_entity_mapping.html)

Also check [Payment FAQ](../payment/payment_faq.md) for more details.

## Can I show the invoice form even if a customer has a customer number?

See [AjaxCheckoutController](checkout_api/ajaxcheckoutcontroller.md).

## How can I use the "store delivery address" information in the order?

When a customer selects the checkbox "Store address" in the checkout (in the delivery address step)
a flag is stored in the basket and order.

It can be mapped in the xslt:

``` 
<Create_Shipping_Address><xsl:value-of select="Delivery/DeliveryParty/SesExtension/store" /></Create_Shipping_Address>
```

## How can I change the subject of the confirmation mail?

This translations can be edited in order to change the subject of the order confirmation mails:

```
siso_core.default.shop_owner_mail_subject: "common.shop_owner_mail_subject"
siso_core.default.sales_contact_mail_subject: "common.sales_contact_mail_subject"
```
