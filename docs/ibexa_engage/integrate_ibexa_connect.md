---
description: Integrate Ibexa Engage with Ibexa Connect.
edition: experience
---

# Use Ibexa Connect

You can create workflows using [Ibexa Connect](https://doc.ibexa.co/projects/connect/en/latest/general/ibexa_connect/).
[[= product_name_engage =]] collects user data and passes it directly to [[= product_name_connect =]].
With this data, you can create scenarios, for example, to add a user to newsletter, or to specific user segment group.

For more information, see [Ibexa Connect documentation](https://doc.ibexa.co/projects/connect/en/latest/).

## Integrate [[= product_name_engage =]] with [[= product_name_connect =]]

Webhooks provide a powerful way to transfer data between applications in real-time.
You can use webhooks to connect [[= product_name_engage =]] with [[= product_name_connect =]] - integration platform (iPaaS).

This integration allows to collect data using [[= product_name_engage =]] and then push it to another systems, such as CRMs, CDP, Marketing Automation platforms, or more.

### Get the webhook URL

Use [[= product_name_engage =]] App and scenario to get the webhook URL from [[= product_name_connect =]].

To set up a webhook in [[= product_name_connect =]], follow the steps:

1\. Log in to your [[= product_name_connect =]] account.

2\. Go to **Scenarios** and click the plus button to create a new scenario.

3\. Select **Receive participation data**.

![Create a scenario](create_scenario.png "Create a scenario")

4\. Click **Create a webhook** and provide a name for the new webhook.

5\. Click **Copy address to clipboard** to save the URL.

![Create a webhook](create_webhook.png "Create a webhook")

### Configure [[= product_name_engage =]]

The next step is to configure [[= product_name_engage =]].

When a form submission event takes place, data can be sent through the obtained webhook URL.

To do it, perform the following actions::

1\. Log in to your [[= product_name_engage =]] account.

2\. Go to **Engage** -> **Integrations** -> **Integrations** and select **Webhook**.

3\. Paste the URL from the clipboard into **Webhook Host** field and click **Save**.

![Configure Ibexa Engage](configure_ibexa_engage.png "Configure Ibexa Engage")

4\. Then, go to **Engage** -> **Integrations** -> **Push rules** to define the default or specific rules for new campaign or website. Select the created webhook.