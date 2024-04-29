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
It includes a welcome screen, an interaction element (such as quiz, memory, and so on), a form step, and an exit screen.

You can also set up prizes for customer when an email or another required pool is filled.
A prize can be, for example, special discount, bonus, free access to some content, and so on.

Some additional parameters can be configured. You can set up a specific time frame for each campaign, use conditions, and design.

Technically, each campaign has a unique campaign ID, that is automatically defined by the Qualifio platform when it is created.

## Publication channels

Every campaign includes at least one publication channel chosen from the three options the platform provides for publishing a campaign:

- **Widget/iframe** - Qualifio offers JavaScript code or an HTML iframe. AMP, Facebook Instant Article, and oEmbed technologies can also be used to publish iframes. (an integration code that needs to be manually entered into your CMS or website).

- **Minisite** - To host the campaign, Qualifio offers a special URL. (A website that you can connect to your subdomain with).

- **Mobile** - Qualifio provides a link that allows for the smooth integration of a mobile-optimized campaign. However, it is important to note that both mentioned publication channels are responsive by nature and can effectively target a mobile audience.

## Add block in Page Builder

You can add Qualifio block in Page Builder.
To add the campaign,  go to **Properties** tab -> **Campaign** and choose campaign from the drop-down list. This list includes all available campaigns created and configured in Qualifio.
Go to **Campaign Feeds**, find the campaign and click a copy icon.

## Embed campaign block in the text field

You can embed campaign block in the text field with Qualifio custom tag.
To do it, insert campaign content item in the Rich Text Field.

# Use Ibexa Connect

You can create workflows using [[= product_name_connect =]].
In this case [[= product_name_engage =]] collects user data and pass it right to [[= product_name_connect =]].
With this data, you can create scenario, like adding a user to newsletter or to specific user segment group.