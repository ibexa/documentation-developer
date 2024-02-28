---
description: The Ibexa CDP (Customer Data Platform) product guide provides a full description of its features as well as the benefits it brings to the client.
---

# Ibexa CDP (Customer Data Platform) product guide

## What is Ibexa CDP

Ibexa CDP is a Customer Data Platform module that helps you build unique experiences for your customers.
With Ibexa CDP you can track and aggregate data of your customers' activity on multiple channels.
It also allows you to create individual customer profiles that enable you to personalize their experience on your platform.

## Availability

CDP is available in all [[= product_name =]] editions.

## How does Ibexa CDP work

Ibexa CDP unifies customer data across your organization to help you activate your users and provide them with real-time engagement. 
With defined audiences you can target your user segments at the right time, through the most used channel, with the relevant message, content, or products.

![How does Ibexa CDP work](img/how_cdp_works.png)

### Configuration

To configure Ibexa CDP, use the `ibexa.system.<scope>.cdp` configuration key, which includes following parameters:

- `account_number` - a [number](#account-number) obtained from Accounts settings in [[= product_name_cdp =]] dashboard
- `stream_id` - stream ID generated when importing data from the stream file in Data Manage
- `activations` - activation details. You can configure multiple activations. They have to be of type `Ibexa` in [[= product_name =]] dashboard
- `client_id` and `client_secret` - client credentials are used to authenticate against the Webhook endpoint. Make sure they are random and secure
- `segment_group_identifier` - a [location](#segment-group) to which CDP data is imported

#### Account number

You need to provide account number. Log in to Ibexa CDP and in the top right corner, select available accounts.

## Capabilities

### Data export

### CDP data export schedule

Configuration in Ibexa CDP allows you to automate the process of exporting Content, Users and Products.
Under the schedule setting you can find separate sections for exporting User, Content, and Product. Structure of each section is exactly the same and includes interval and options elements:

- Interval - sets the frequency of the command invoke, for example, '*/30 * * * *' means "every 30 minutes", '0 */12 * * *' means "every 12 hours". It uses a standard crontab format, see examples.

- Options - allows you to add arguments that have to be passed to the export command.

This configuration allows you to provide multiple export workflows with parameters. It's important, because each type of content/product must have its own parameters on the CDP side, where each has a different Stream ID key and different required values, which are configured per data source.

### Data customization

​You can customize Content and Product data exported to CDP and you can control what Field Type information you want to export.

#### Export Field Type values


#### Built in Field Value Processors for custom Field Types

### Client-side Tracking

## Limitations

CDP doesn't support column mapping, which allows you to match records on JSON data directly.

## Benefits