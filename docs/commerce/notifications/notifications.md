---
description: With transactional emails you can notify end users about changes in the status of orders, payments, shipments, and so on.
edition: commerce
---

# Transactional emails

Transactional emails are messages that [[= product_name =]] can send through [Actito](https://www.actito.com/en-BE/) gateway to your end-users to notify them about changes in the status of various actions taken in relation to your commerce presence.

By default, notifications are sent in relation to the following events, to an email address of the end-user who has originated these events:

- Order processing:
    - order is created
    - order is processing
    - order is completed
    - order is cancelled
- Payment:
    - payment failed
    - payment has been cancelled
- Shipment:
    - order is shipped

You can change the events that trigger sending a transactional email.

## Configure transactional emails

### Configure Actito integration

Before you can start configuring the notifier engine to process and dispatch notifications to be forwarded as transactional emails, you must first obtain and configure an [Actito license](lihttps://www.actito.com/en-BE/pricing/nk).

Once you gain access to the Actito dashboard:

1. Configure the API to make calls with the GET method.
2. Get the [API key](https://cdn3.actito.com/fe/actito-documentation/docs/Managing_API_users) and entity name.
3. Set these values in the YAML configuration files, under the `ibexa.system.default.connector_actito` key:

``` yaml
ibexa:
    system:
        default:
            connector_actito:
                api_key: 12ea56789o1ea56789012ea56789o12e
                entity: <entity_name>
```

4\. Set the notification channel.

5\. Set Actito gateway details.

6\. Define columns in Actito database for storing notification attributes.

!!! note

    By default, a trigger message coming from [[= product_name =]] contains the following attributes with information about the end-user: name, surname, and email.

    Those attributes can then be used to present statistics in the Actito dashboard.
    If this set of attributes is insufficient for your needs, you can [add more attributes to the trigger message](extend_notifications.md#customize-actito-end-user-profile-schema).

### Create email campaigns

Create campaigns of transactional email type, one for each notification type that you want to deliver.
When you build a campaign template, make sure that you use the variables supported by [[= product_name =]].
For a complete list of parameters, see [Transactional email variables reference](notification_parameters.md)

!!! Tip

    When you invent names for your campaigns, keep them simple, and do not use special characters or spaces.


Campaign emails can be sent in one language only.
To send emails in different languages, for example, because your application serves end-users from different locales, for each notification and language pair, you must create a separate campaign and [extend the solution to support that](extend_notifications.md#send-emails-in-language-of-commerce-presence).


### Configure mapping

After you create and configure campaigns in Actito user interface, one for each type of notifications coming from [[= product_name =]], in YAML configuration files, under the `ibexa.system.default.connector_actito.campaign_mapping` key, you define mappings between notifications and email campaigns, for example:

``` yaml
                campaign_mapping:
                    Ibexa\Contracts\Payment\Notification\PaymentWorkflowStateChange:
                        campaign: <actito_campaign_name_1>

                    Ibexa\Contracts\OrderManagement\Notification\OrderWorkflowStateChange:
                        campaign: <actito_campaign_name_2>

                    Ibexa\Contracts\Shipping\Notification\ShipmentWorkflowStateChange:
                        campaign: <actito_campaign_name_3>
```
