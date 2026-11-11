# Use Ibexa Connect

Integrate Ibexa Engage with Ibexa Connect.

Editions: Experience

You can use [Ibexa Connect](https://doc.ibexa.co/projects/connect/en/latest/general/ibexa_connect/) to create workflows. Ibexa Engage collects user data and passes it directly to Ibexa Connect. With this data, you can create scenarios, for example, to add a user to newsletter, or to specific user segment group.

For more information, see [Ibexa Connect documentation](https://doc.ibexa.co/projects/connect/en/latest/).

## Integrate Ibexa Engage with Ibexa Connect

Webhooks provide a powerful way to transfer data between applications in real-time. You can use webhooks to connect Ibexa Engage with Ibexa Connect - integration platform (iPaaS).

This integration allows to collect data using Ibexa Engage and then push it to another systems, such as CRMs, CDP, Marketing Automation platforms, or more.

### Get the webhook URL

Use Ibexa Engage App and scenario to get the webhook URL from Ibexa Connect.

To set up a webhook in Ibexa Connect, follow the steps:

1. Log in to your Ibexa Connect account.

2. Go to **Scenarios** and click the plus button to create a new scenario.

3. Select **Receive participation data**.

![Create a scenario](https://doc.ibexa.co/en/5.0/ibexa_engage/img/create_scenario.png "Create a scenario")

4. Click **Create a webhook** and provide a name for the new webhook.

5. Click **Copy address to clipboard** to save the URL.

![Create a webhook](https://doc.ibexa.co/en/5.0/ibexa_engage/img/create_webhook.png "Create a webhook")

### Configure Ibexa Engage

The next step is to configure Ibexa Engage.

When a form submission event takes place, data can be sent through the obtained webhook URL.

To do it, perform the following actions::

1. Log in to your Ibexa Engage account.

2. Go to **Engage** -> **Integrations** -> **Integrations** and select **Webhook**.

3. Paste the URL from the clipboard into **Webhook Host** field and click **Save**.

![Configure Ibexa Engage](https://doc.ibexa.co/en/5.0/ibexa_engage/img/configure_ibexa_engage.png "Configure Ibexa Engage")

4. Then, go to **Engage** -> **Integrations** -> **Push rules** to define the default or specific rules for new campaign or website. Select the created webhook.
