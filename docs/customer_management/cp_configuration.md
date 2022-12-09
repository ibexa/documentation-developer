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

`ibexa_default_settings.yaml` contains a setting that indicates what Content Types should be treated like Users in terms of, for example, usage in `UserService`:

```yaml
ibexa:
    system:
        default:
            user_content_type_identifier: ['user', 'customer']
```

## Roles and Policies

You can add custom roles to your installation
by adding them to the configuration file `vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`:

```yaml
parameters:
    ibexa.site_access.config.default.corporate_accounts.roles:
        admin: Company Admin
        buyer: Company Buyer
        custom_role: Company Assistant
```

## Content Type names

You can change names of default Content Types by assigning what
Content Types should be used to describe `Company` and `Member` in the Back Office.
Proceed only if you already have a `Company` Content Type in your system, and you don't want to change its identifier.

Configuration for Content Type names is placed under the `ibexa_corporate_account` key,
like shown in `Ibexa\Bundle\CorporateAccount\DependencyInjection\Configuration`.
To change Content Type names, adjust corporate account configuration in the following way:

```yaml
ibexa_corporate_account:
    content_type_mappings:
        company: your_ct_identifier
```

!!! caution "Migration"

    If you decide to change deafult names of Content Types, during migration you have to adjust files accordingly.


## Registration

You can define what fields are required in the Customer Portal registration form.
To do so, [create and configure user registration form](create_user_registration_form.md).

## Address

With the Address Field Type, you can customize address Fields and configure them per country.
To learn more, see [Address Field Type documentation](addressfield.md).

## Templates

You can also define new templates for, among others: invitation email,
reset password message and the information screens after any of the user's actions in 
`config/packages/ibexa.yaml`.

```yaml
ibexa:
    system:
        site_group:
            content_view:
                full:
                  confirmation_page:
                        template: "@@ibexadesign/customer_portal/account/forgot_password/confirmation_page.html.twig"
                        match:
                            Identifier\ContentType: confirmation_page
```
