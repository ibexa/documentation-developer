---
description: Configuring PayPal payments with Payum.
edition: commerce
---

# Configuring PayPal payments with Payum

## Integration via Payum Configuration

PayPal offers a versatile payment gateway that supports various payment methods, including credit cards, debit cards, Pay Later options, and alternative payment methods like Venmo.
Integrating PayPal allows for a secure and convenient checkout experience.

## Account setup

[Create a PayPal business account](https://www.paypal.com/bizsignup/#/singlePageSignup) and obtain API credentials.

## Configuration setup

Add the following configuration snippet to your YAML configuration file (`payum.yaml` or similar):

```yaml
payum:
    gateways:
        <method_identifier>:
            factory: paypal_express_checkout
            username: <paypal_username>
            password: <paypal_password>
            signature: <paypal_signature>
```

Replace `<method_identifier>` with a unique identifier for the PayPal payment method.
The username, password, and signature fields should contain your PayPal API credentials obtained from your PayPal business account.

## Translations for payment methods

For language translations of PayPal payment method names, use the provided translation key structure within your translation files:

```yaml
ibexa:
    payment_method:
        type:
            <method_identifier>:
                name: "Translated PayPal Method Name"

```

Replace `<method_identifier>` with the identifier used in the Payum configuration.
Add translations for each PayPal payment method identifier within the `ibexa_payment_type` namespace in your translation files.

### Implementation

- Ensure the provided PayPal API credentials (username, password, and signature) are from your PayPal business account and are correctly configured within your application.
- Maintain consistency between the payment method identifiers used in the Payum configuration and the corresponding translations in your language files.

### Conclusion

By configuring PayPal payments as described in the Payum documentation and incorporating translations for payment method names,
you can enhance the user experience by presenting a localized interface while securely processing payments using PayPal's reliable platform.