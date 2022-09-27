---
description: A finished order sends out a configurable confirmation email.
edition: commerce
---

# Order confirmation

After finishing the checkout (in case of an electronic payment transaction after redirection from the payment provider) the user is redirected to the confirmation page.

## Confirmation email

The `Ibexa\Platform\Commerce\Checkout\Event\Listener\OrderConfirmationListener` event listener sends the order confirmation.

Both the customer and a sales contact (if configured) should receive confirmation emails.
The confirmation is sent using `MailHelperService`.  

In case of a failure (for example, when the mail server is unreachable), the issue is logged into `var/log/<env>/dev-siso.mails.log`.

Processing the confirmation email address is handled in `Ibexa\Platform\Commerce\Checkout\Service\SummaryCheckoutFormService`.

### Customer confirmation

The customer's confirmation email address depends on the user type and is stored in the basket object during the checkout process.

For an anonymous customer, the email address is taken from the invoice address of the basket object.
For a logged-in customer, the address is taken from customer profile data.

### Sales contact confirmation

A second confirmation email can be sent to a sales contact.
This address is also stored in the basket object, next to the customer's address. 
The behavior is configurable:

#### `sales_email_mode`

`ibexa_commerce_checkout.default.order_confirmation.sales_email_mode` can take the following values:

- `config` - the address is taken from the `sales_email_address` setting
- `customer` - the address is taken from `salesContactEmail` in the `sesUser` part
of the [customer's profile data](customer_profile_data.md).
If there is no address in the contact data, the configuration parameter below is used as the default.

#### `sales_email_address`

`ibexa_commerce_checkout.default.order_confirmation.sales_email_address` can be set to a valid email address of the sales contact person.
If it's left empty, no sales contact confirmations are sent, except if `sales_email_mode` is set to `customer`
and the respective profile data contains a valid address.

Sales contact information also receives a confirmation email for a local order
if `is_sales_contact` is set to `true`, and with the following configuration:

``` yaml
ibexa_commerce_checkout.default.order_confirmation.sales_email_mode: customer
ibexa_commerce_checkout.default.order_confirmation.sales_email_address:
```

### Shop owner

Owner of the shop also receives a receives a confirmation email for a local order
if `is_shop_owner` is set to `true`.

This email contains a special message and subject.

- `shop_owner_mail_subject` (set in the email configuration)
 `email_shop_owner_intro_text` (text module in the Back Office)
