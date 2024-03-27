---
description: Install and configure Ibexa Engage.
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

You can also set up prizes for customer when an email or another required pool is filled.
A prize can be, for example, special discount, bonus, free access to some content, etc.

Some additional parameters can be configured. You can set up a specific time frame for each campaign, use conditions, and design.

## Add block in Page Builder

You can add QNTM Qualifio block in Page Builder.
To add the campaign,  go to **Properties** tab -> **Campaign** and paste an URL of the selected campaign.
You can find campaign URL in on your Ibexa Engage page. 
Go to **Campaign Feeds**, find the campaign and click a copy icon.

## Embed campaign block in the text field

You can embed campaign block in the text field.
To do it, insert campaign content item in the Rich Text Field.

# Use Ibexa Connect

You can create workflows using [[= product_name_connect =]]. 
In this case [[= product_name_engage =]] collects user data and pass it right to [[= product_name_connect =]]. 
With this data, you can create scenario, like adding a user to newsletter or to specific user segment group.