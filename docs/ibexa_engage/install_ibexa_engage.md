---
description: Install and configure Ibexa Engage.
edition: experience
---

# Ibexa Engage

[[= product_name_engage =]] is a data collection tool. It enables you to engage your audiences by using the [Qualifio](https://qualifio.com/) tools.
You can use interactive content to gather valuable data, for example, customer data or recent orders list, and create connections.

For more information, see [Qualifio Developers documentation](https://developers.qualifio.com/docs/engage/).

## Enable [[= product_name_engage =]] account

To use [[= product_name_engage =]], you must make arrangements with [[= product_name =]] to define the initial configuration.
[[= product_name_base =]] team creates and provides user account. An invitation link is sent during the setup process.

For more information, see [Ibexa Engage in User documentation]([[= user_doc =]]/ibexa_engage/ibexa_engage/#request-access).

## Install [[= product_name_engage =]]

[[= product_name_engage =]] comes from v4.6.6 of [[= product_name_exp=]].
If you have different version, run the following command to install the bundle:

``` bash
composer require ibexa/engage
```

You can check for its presence by using the following command:

``` bash
composer show | grep "ibexa/engage"
```

This command adds to your project configuration files required for using [[= product_name_engage =]].

## Prepare configuration files

In `config/packages` directory add the following `ibexa_connector_qualifio.yaml` [YAML configuration](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/ibexa_engage/config/packages/ibexa_connector_qualifio.yaml') =]]
```

- `client_id` - an identifier of the user.
- `channel` - an UUID identifier format: a string of 30+ characters, divided by four hyphens, specific per publication channel.
- `feed_url` - an URL link of the campaign feed. To create a campaign feed, follow the [Qualifio documentation](https://support.qualifio.com/hc/en-us/articles/360022954454-About-Campaign-Feeds).

!!! note

    [[= product_name_base =]] configures the `channel` and `client_id` values so that the selections can be filled up automatically on [[= product_name =]] side.

    The `feed_url` and `variable_map` values don't need to be set at the installation process. They are preconfigured and can be overwritten.