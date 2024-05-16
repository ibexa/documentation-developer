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

Log in to https://qualifio.com or create an account if you don't have one yet.

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

## Embed campaign block in the text field

You can embed campaign block in the text field with Campaign custom tag.
To do it, insert campaign content item in the Rich Text Field.

# Use Ibexa Connect

You can create workflows using [[= product_name_connect =]].
In this case [[= product_name_engage =]] collects user data and pass it right to [[= product_name_connect =]].
With this data, you can create scenario, for example, to add a user to newsletter or to specific user segment group.