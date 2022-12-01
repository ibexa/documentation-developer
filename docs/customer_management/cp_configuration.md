---
description: Configure Customer Portal to fit the needs of your business.
edition: experience
---

# Customer Portal configuration

You can overwrite the default configuration of the Customer Portal
to fit its capabilities to the unique needs of your business.

## `corporate` SiteAccess

The predefined `corporate` SiteAccess in `corporate_group`
(configured in `config/packages/ibexa.yaml`) serves the Customer Portal.
If you need a multisite setup with multiple Customer Portals,
add any additional SiteAccesses to `corporate_group`.

## Customer identifier

`ibexa_default_settings.yaml` contains setting that indicate which Content Types are treated like customers:

```yaml
ibexa:
    system:
        default:
            user_content_type_identifier: ['user', 'customer']

```

You can override these settings if you have other Content Types
that should be treated as customers in the Back Office and Customer Portal.
When viewing such Content in the Back Office and Customer Portal, you will be able to see e.g. the assigned Policies.

## Roles and Policies

You can easily add custom roles to your installation
by adding them to the configuration file `vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`:

```yaml
parameters:
    ibexa.site_access.config.default.corporate_accounts.roles:
        admin: Company Admin
        buyer: Company Buyer
        custom_role: Company Assistant
```

## Content Types names

To change names of default Content Types, you need to define them in the configuration
`vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`:

```yaml
parameters:
    ibexa.site_access.config.default.user_content_type_identifier: ['user', 'customer', 'member']
    ibexa.site_access.config.admin_group.user_content_type_identifier: ['user', 'customer', 'member']
```

## Registration

You can define what fields are required in the Customer Portal registration form 
and what Content Type and what identifier customers get after registering.
To do so, go to `vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`.

```yaml
parameters:
    ibexa.site_access.config.corporate_group.user_content_type_identifier: [ 'member' ]
    ibexa.site_access.config.corporate_group.user_registration.user_type_identifier: 'member'
    ibexa.site_access.config.corporate_group.user_registration.form.allowed_field_definitions_identifiers:
        - first_name
        - last_name
        - phone_number
        - user
```

## Address

With the Address Field Type, you can customize address Fields and configure them per country.
To lern more see [Address Field Type documentation](../content_management/field_types/field_type_reference/addressfield.md).

## Templates

You can also define new templates for among others: invitation email,
reset password message and the information screens after any of the user's action in 
`vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`.

```yaml
parameters:
    ibexa.site_access.config.corporate_group.user_settings.templates.list: "@@ibexadesign/customer_portal/account/settings/list.html.twig"
    ibexa.site_access.config.corporate_group.user_settings.templates.update: "@@ibexadesign/customer_portal/account/settings/update.html.twig"
    ibexa.site_access.config.corporate_group.user_change_password.templates.form: "@@ibexadesign/customer_portal/account/change_password/index.html.twig"
    ibexa.site_access.config.corporate_group.user_forgot_password.templates.form: "@@ibexadesign/customer_portal/account/forgot_password/index.html.twig"
    ibexa.site_access.config.corporate_group.user_forgot_password_success.templates.form: "@@ibexadesign/customer_portal/account/forgot_password/confirmation_page.html.twig"
    ibexa.site_access.config.corporate_group.user_forgot_password_login.templates.form: "@@ibexadesign/customer_portal/account/forgot_password/index_with_login.html.twig"
    ibexa.site_access.config.corporate_group.user_forgot_password.templates.mail: "@@ibexadesign/customer_portal/account/forgot_password/mail.html.twig"
    ibexa.site_access.config.corporate_group.user_reset_password.templates.form: "@@ibexadesign/customer_portal/account/reset_password/index.html.twig"
    ibexa.site_access.config.corporate_group.user_reset_password.templates.invalid_link: "@@ibexadesign/customer_portal/account/reset_password/invalid_link_page.html.twig"
    ibexa.site_access.config.corporate_group.user_reset_password.templates.success: "@@ibexadesign/customer_portal/account/reset_password/confirmation_page.html.twig"
    ibexa.site_access.config.corporate_group.user_registration.templates.form: "@@ibexadesign/customer_portal/account/register/index.html.twig"
    ibexa.site_access.config.corporate_group.user_registration.templates.confirmation: "@@ibexadesign/customer_portal/account/register/register_confirmation.html.twig"
```
