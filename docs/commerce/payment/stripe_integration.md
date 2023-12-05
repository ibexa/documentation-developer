---
description: Configuring Stripe payments with Payum.
edition: commerce
---

# Configuring Stripe payments with Payum

Stripe is a comprehensive payment platform offering a suite of tools to handle online and in-person payments, subscriptions, fraud prevention, and more.
Integrating Stripe into your application allows you to securely process payments using credit cards, bank transfers, and alternative payment methods.

## Account setup

[Sign up for a Stripe account](https://dashboard.stripe.com/register) to obtain API keys required for integration.

## Configuration setup

Add the following configuration snippet to your YAML configuration file (payum.yaml or similar):

```yaml
payum:
    gateways:
        <method_identifier>:
            factory: stripe_checkout
            publishable_key:  <publishable_key>
            secret_key:  <secret_key>

```

Replace `<method_identifier>` with a unique identifier for the payment method.
The `publishable_key` and `secret_key` fields should contain your Stripe API keys, obtained from your Stripe account dashboard.

### Translations for payment methods

For language translations of payment method names, use the provided translation key structure within your translation files:

```yaml
ibexa:
    payment_method:
        type:
            <method_identifier>:
                name: "Translated Payment Method Name"

```

Replace `<method_identifier>` with the identifier used in the Payum configuration.
Add translations for each payment method identifier within the `ibexa_payment_type` namespace in your translation files.

Example:

Let's say you have a Stripe payment method configured in Payum with the identifier `stripe_payment`:

```yaml
payum:
    gateways:
        stripe_payment:
            factory: stripe_checkout
            publishable_key: pk_test_your_publishable_key
            secret_key: sk_test_your_secret_key

```

For language translations, in your translation files:

```yaml
ibexa:
    payment_method:
        type:
            stripe_payment:
                name: "Stripe Payment Method"

```

Ensure to replace "Stripe Payment Method" with the translated name in the respective language.

### Implementation

- Verify that the provided API keys (publishable and secret) are from your Stripe account and are correctly configured within your application.
- Maintain consistency between the payment method identifiers used in the Payum configuration and the corresponding translations in your language files.

### Conclusion

By configuring Stripe payments in line with the Payum documentation and incorporating translations for payment method names, you can enhance the user experience by presenting a localized interface while securely processing payments using Stripe's robust platform.