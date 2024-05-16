---
description: Install and configure Ibexa Engage.
edition: experience
---

# Install on Ibexa Engage

[[= product_name_engage =]] is a data collection tool. It enables you to engage your audiences by using the [Qualifio](https://qualifio.com/) tools.
You can use interactive content to gather valuable data, for example, customer personal data or recent orders list, and create connections.

## Prepare configuration files

First, run the `composer ibexa:setup` command:

``` bash
composer require ibexa/connector-qualifio
```

This command adds to your project configuration files required for using [[= product_name_engage =]].

## Create an account

Log in to https://qualifio.co or create an account if you don't have one yet.

# Create campaign

You can create personalized, visual attractive campaigns using available templates, such as quizzes, pools, forms provided by Qualifio.
Design, themes, backgrounds are all configured by Qualifio.

A campaign is a set of concepts, divided into steps, that the user can configure.
It includes a welcome screen, an interaction element, a form step, and an exit screen.

You can also set up prizes for customer when an email or another required pool is filled.
A prize can be, for example, special discount, bonus, free access to some content, and so on.

Some additional parameters can be configured. You can set up a specific time frame for each campaign, use conditions, and design.

Technically, each campaign has a unique campaign ID, that is automatically defined by the Qualifio platform when it is created.

## Publication channels

Every campaign includes a minimum of one publication channel that you can choose from the three options the platform provides for publishing a campaign:

- **Widget/iframe** - uses a JavaScript code or an HTML iframe from Qualifio. Additionally, you can use oEmbed, Facebook Instant articles, and AMP technologies to publish iframes. You need to manually paste the code into your website or CMS.

- **Minisite** - uses a unique URL from Qualifio that can hosts the campaign. This URL points to your subdomain.

- **Mobile** - uses a link from Qialifio to integrate a campaign that is optimized for mobile usage.

Each publication channel type is automatically responsive and can be use on any mobile device.

## Add block in Page Builder

You can add [Campaign block] in Page Builder.
To add the campaign,  go to **Properties** tab -> **Campaign** and choose campaign from the drop-down list. This list includes all available campaigns created and configured in Qualifio.
Go to **Campaign Feeds**, find the campaign and click a copy icon.

![Campaign block](campaign_block.png)

## Embed campaign block in the text field

You can embed campaign block in the text field with Campaign custom tag.
To do it, insert campaign content item in the Rich Text Field.

![Campaign custom tag](campaign_custom_tag.png)

# Use Ibexa Connect

You can create workflows using [[= product_name_connect =]].
In this case [[= product_name_engage =]] collects user data and pass it right to [[= product_name_connect =]].
With this data, you can create scenario, like adding a user to newsletter or to specific user segment group.

![Ibexa Connect](connect_ibexa_engage.png)