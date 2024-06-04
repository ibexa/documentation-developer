---
description: Install and configure Ibexa Engage.
edition: experience
---

# Install [[= product_name_engage =]]

[[= product_name_engage =]] is a data collection tool. It enables you to engage your audiences by using the [Qualifio](https://qualifio.com/) tools.
You can use interactive content to gather valuable data, for example, customer personal data or recent orders list, and create connections.
For more information, see [Qualifio Developers documentation](https://developers.qualifio.com/docs/engage/).

## Prepare configuration files

[[= product_name_engage =]] comes with v4.6.6 of [[= product_name_exp=]].
If you do not have it, run the `composer ibexa:setup` command:

``` bash
composer require ibexa/connector-qualifio
```

This command adds to your project configuration files required for using [[= product_name_engage =]].

## [[= product_name_engage =]] account

[[= product_name =]] creates and provides user account. An invitation link is sent during the setup process.

# Create campaign

[Campaign]([[= user_doc =]]/ibexa_engage/ibexa_engage/#campaign) is a set of concepts, divided into steps, that the user can configure.
It includes a welcome screen, an interaction element, a form step, and an exit screen.
Design, themes, backgrounds are all configured by Qualifio.

Technically, each campaign has a unique campaign ID, that is automatically defined by the Qualifio platform when it is created.

## Publication channels

Every campaign includes a minimum of one publication channel that you can choose from the three options the platform provides for publishing a campaign.
For more information about publication channels, see [Publication channel]([[= user_doc =]]/ibexa_engage/ibexa_engage/#publication-channel) in the User Documentation.

## Add block in Page Builder

You can add [Campaign block]([[= user_doc =]]/content_management/block_reference/#campaign-block) in Page Builder.
To add the campaign,  go to **Properties** tab -> **Campaign** and choose campaign from the drop-down list. This list includes all campaigns available on user's Qualifio account which are active or scheduled to launch in the future.

![Campaign block](campaign_block.png)

## Embed campaign in the Rich text field

You can embed campaign in the Rich text field with Campaign custom tag.
To do it, insert campaign content item in the Rich Text Field and paste Campaign URL.

![Campaign custom tag](campaign_custom_tag.png)

# Use Ibexa Connect

You can create workflows using [[= product_name_connect =]].
[[= product_name_engage =]] collects user data and passes it directly to [[= product_name_connect =]].
With this data, you can create scenarios, for example, to add a user to newsletter, or to specific user segment group.

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

![Create scenario](create_scenario.png)

4\. Click **Create a webhook** and provide a name for the new webhook.

5\. Click **Copy address to clipboard** to save the URL.

![Create webhook](create_webhook.png)

### Configure [[= product_name_engage =]]

The next step is to configure [[= product_name_engage =]].

When a form submission event takes place, data can be sent through the obtained webhook URL.

To do it, perform the following actions::

1\. Log in to your [[= product_name_engage =]] account.

2\. Go to **Engage** -> **Integrations** -> **Integrations** and select **Webhook**.

3\. Paste the URL from the clipboard into **Webhook Host** field and click **Save**.

![Configure Ibexa Engage](configure_ibexa_engage.png)

4\. Then, go to **Engage** -> **Integrations** -> **Push rules** to define the default or specific rules for new campaign or website. Select the created webhook.