# Ibexa Engage

Install and configure Ibexa Engage.

Editions: Experience

Ibexa Engage is a data collection tool. It enables you to engage your audiences by using the [Qualifio](https://qualifio.com/) tools. You can use interactive content to gather valuable data, for example, customer data or recent orders list, and create connections.

For more information, see [Qualifio Developers documentation](https://developers.qualifio.com/docs/engage/).

## Enable Ibexa Engage account

To use Ibexa Engage, you must make arrangements with Ibexa DXP to define the initial configuration. Ibexa team creates and provides user account. An invitation link is sent during the setup process.

For more information, see [Ibexa Engage in User Documentation](../../../user/ibexa_engage/ibexa_engage/index.md#request-access).

## Install Ibexa Engage

Ibexa Engage comes from v4.6.6 of Ibexa Experience. If you have different version, run the following command to install the bundle:

```bash
composer require ibexa/engage
```

You can check for its presence by using the following command:

```bash
composer show | grep "ibexa/engage"
```

This command adds to your project configuration files required for using Ibexa Engage.

## Prepare configuration files

In `config/packages` directory add the following `ibexa_connector_qualifio.yaml` [YAML configuration](../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_connector_qualifio:
    client_id: 1234
    channel: 'd882c3f1-1b05-48c8-bc1d-c11a45e2c23a'
    feed_url: 'https://api.qualif.io/v1/campaignfeed/channels/d882c3f1-1b05-48c8-bc1d-c11a45e2c23a/json?clientId=1234'
    variable_map:
        form:
            shipping_address:
                first_name: 'firstname'
                last_name: 'lastname'
                email: 'email'
                street: 'address'
                postal_code: 'zip_code'
                locality: 'locality'
                country: 'country'
                phone_number: 'phone'
            billing_address:
                first_name: 'firstname'
                last_name: 'lastname'
                email: 'email'
                street: 'address'
                postal_code: 'zip_code'
                locality: 'locality'
                country: 'country'
                phone_number: 'phone'
            content:
                birthday: 'birthday'
                first_name: 'firstname'
                last_name: 'lastname'
                company: 'company'
                position: 'position'
                phone: 'phone'
                gender: 'gender'
            account:
                name: 'name'
                email: 'email'
                id: 'userid'
                remote_id: 'identifier'
                login: 'login'
```

- `client_id` - an identifier of the user.
- `channel` - an UUID identifier format: a string of 30+ characters, divided by four hyphens, specific per publication channel.
- `feed_url` - an URL link of the campaign feed. To create a campaign feed, follow the [Qualifio documentation](https://support.qualifio.com/hc/en-us/articles/360022954454-About-Campaign-Feeds).

> **Note: Note**
>
> Ibexa configures the `channel` and `client_id` values so that the selections can be filled up automatically on Ibexa DXP side.
>
> The `feed_url` and `variable_map` values don't need to be set at the installation process. They're preconfigured and can be overwritten.
