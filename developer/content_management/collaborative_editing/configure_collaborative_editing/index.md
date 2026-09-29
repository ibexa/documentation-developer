# Collaborative editing

Configure the Collaborative editing feature.

Collaborative editing feature is available in Ibexa DXP starting with version v5.0.2 or higher, regardless of its edition.

## Installation

### Install Real-time editing feature package

If you have an arrangements with Ibexa to use Real-time editing feature, you need to install following package:

```bash
composer require ibexa/fieldtype-richtext-rte
```

This command installs also `ibexa/ckeditor-premium` package and adds the new real-time editing functionality to the Rich Text field type. It also modifies the permission system to account for the new functionality.

### Modify the bundles file

Then, if not using Symfony Flex, add the following code to the `config/bundles.php` file:

```php
<?php

return [
    // A lot of bundles…
    Ibexa\Bundle\FieldTypeRichTextRTE\IbexaFieldTypeRichTextRTEBundle::class => ['all' => true],
    Ibexa\Bundle\CkeditorPremium\IbexaCkeditorPremiumBundle::class => ['all' => true],
];
```

## Configure Collaborative editing

Before you can start Collaborative editing feature, you must enable it by following these instructions.

### Security configuration

After an installation process is finished, go to `config/packages/security.yaml` and make following changes:

- uncomment following lines with `shared` user provider under the `providers` key:

```yaml
security:
    providers:
        # ...
        shared:
            id: Ibexa\Collaboration\Security\User\ShareableLinkUserProvider
```

- uncomment following lines under the `ibexa_shareable_link` key:

```yaml
security:
    # ...
    firewalls:
        ibexa_shareable_link:
            request_matcher: Ibexa\Collaboration\Security\RequestMatcher\ShareableLinkRequestMatcher
            pattern: ^/
            provider: shared
            stateless: true
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            custom_authenticators:
                - Ibexa\Collaboration\Security\Authenticator\ShareableLinkAuthenticator
```

### Configuration

You can configure Collaborative editing per [Repository](../../../administration/configuration/repository_configuration/index.md).

Under `ibexa.repositories.<repository_name>.collaboration` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files), indicate the settings for collaboration:

```yaml
ibexa:
    repositories:
        <repository_name>:
            collaboration:
                participants:
                    allowed_types:
                        - internal
                        - external
                    auto_invite: <value>
                session:
                    public_link_enabled: <value>
```

The following settings are available:

- participants:
  - `allowed_types` - defines allowed user types, values: `internal`, `external`, you can set one or both of the values
  - `auto_invite` - determines whether invitations should be sent automatically when inviting someone to a session, default value: `true`, available values: `true`, `false`
- session:
  - `public_link_enabled` - determines whether the public link is available, default value: `false`, available values: `true`, `false`

#### `ibexa/share` configuration

To share content model, you need to configure the `ibexa/share` package. Under `ibexa.system` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files), indicate the settings:

```yaml
ibexa:
    system:
        admin_group:
            share:
                content_type_groups:
                    - 'Content'
                excluded_content_types:
                    - 'tag'
                    - 'landing_page'
                    - 'product_category_tag'
```

The following setting is available:

- `content_type_groups` – defines groups of content types for which the **Share** button is displayed (it can still be disabled for specific content types within these groups by using the `excluded_content_types` setting)

In the example configuration above, the **Share** button is displayed for any content that belongs to the `Content` group, except for `tag`, `landing_page`, and `product_category_tag` content types.

You can also control which user content types can use the feature through the `ibexa.share.permission_check_context.content.user_content_type_identifiers` container parameter. It accepts an array of content type identifiers and the default value is `['editor']`.

You can now restart you application and start working with the Collaborative editing feature. To add the real-time editing capabilities, continue with the instruction below.

## Configure real-time editing

You must have an arrangement with Ibexa before configuring the real-time editing. If you haven't already, you must also accept the Terms of Service in the [Service portal](https://support.ibexa.co/).

Only then you can create a new Collaborative editing environment. To do it, log in to the service portal, go to your **Service Portal** and select **Create environment** (this requires the **Portal administrator** access level).

Once the environment is created, you can proceed with the configuration in Ibexa DXP.

Use the generated values to set the `environment_id`, `environment_secret`, and `web_socket_url` for your [repositories](../../../administration/configuration/repository_configuration/index.md) as in the example below:

```yaml
ibexa:
    repositories:
        default:
            fieldtype_richtext_rte:
                environment_id: '%env(CKEDITOR_ENVIRONMENT_ID)%'
                environment_secret: '%env(CKEDITOR_ENVIRONMENT_SECRET)%'
                web_socket_url: '%env(CKEDITOR_WEB_SOCKET_URL)%'
```

Then, enable real-time editing for specific [SiteAccesses](../../../multisite/siteaccess/siteaccess/index.md). The following example enables it for the back office:

```yaml
ibexa:
    system:
        admin_group:
            fieldtype_richtext_rte:
                enabled: true
```

Finish the configuration by running:

```bash
composer run post-install-cmd
```

## Accepting new Terms of Service

Real-Time Collaboration service is only available after accepting its Terms and Conditions. Any new version of this document released by Ibexa must be accepted before the assigned deadline.

The **Portal administrator** for your [Service portal](https://support.ibexa.co) can accept it in Service portal's service details.

If not done in time, the Real-Time Collaboration service will be disabled until the latest Terms and Conditions are accepted.
