---
description: Use Payum to integrate the Stripe payment processing service.
edition: commerce
---

# Enable Stripe payments with Payum

Stripe is a comprehensive payment platform that offers a suite of tools to handle online and in-person payments, subscriptions, fraud prevention, and more.
By using Payum to integrate Stripe into your application, you can securely process payments with credit cards, bank transfers, and alternative payment methods.

Before you can proceed with integrating Stripe, [sign up for a Stripe account](https://dashboard.stripe.com/register) and obtain the API keys required for integration.

Then, add the following configuration to your YAML configuration file (`payum.yaml` or similar):

```yaml
payum:
    gateways:
        stripe_payment_platform:
            factory: stripe_checkout
            publishable_key: <publishable_key>
            secret_key: <secret_key>

```

!!! tip

    You can replace `stripe_payment_platform` with a different unique identifier.

Ensure that the `publishable_key` and `secret_key` fields contain the Stripe API keys.

You can now provide language translations for the Stripe payment platform name.
To do it, within the `ibexa_payment_type` namespace in your translation files, use the provided translation key structure within your translation files:

```yaml
ibexa:
    payment_method:
        type:
            stripe_payment_platform:
                name: "Translated Stripe platform name"

```