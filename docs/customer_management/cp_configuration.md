---
description: Configure Customer Portal to fit the needs of your business.
edition: experience
---

# Customer Portal configuration

You can overwrite the default configuration of the Customer Portal to fit its capabilities to the unique needs of your business.

## `corporate` SiteAccess

The predefined `corporate` SiteAccess in `corporate_group` (configured in `config/packages/ibexa.yaml`) serves the Customer Portal.
If you need a multisite setup with multiple Customer Portals, add any additional SiteAccesses to `corporate_group`.

## Customer identifier

`ibexa_default_settings.yaml` contains a setting that indicates what content types should be treated like Users in terms of, for example, usage in `UserService`:

```yaml
ibexa:
    system:
        default:
            user_content_type_identifier: ['user', 'customer']
```

## Roles and policies

You can add custom roles to your installation by listing them under the `ibexa.site_access.config.default.corporate_accounts.roles` [configuration](configuration.md#configuration-files).
This key overwrites the default list set in `vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml` (the following example redeclares them for clarity):

```yaml
parameters:
    ibexa.site_access.config.default.corporate_accounts.roles:
        admin: Company Admin
        buyer: Company Buyer
        custom_role: Company Assistant
```

You can do it per SiteAccess or SiteAccess group by using [SiteAccess-aware configuration](siteaccess_aware_configuration.md).

## Content type names

You can change names of default content types by assigning what content types should be used to describe `Company` and `Member` in the back office.
Proceed only if you already have a `Company` content type in your system, and you don't want to change its identifier.

Configuration for content type names is placed under the `ibexa_corporate_account` key, like shown in `Ibexa\Bundle\CorporateAccount\DependencyInjection\Configuration`.
To change content type names, adjust corporate account configuration in the following way:

```yaml
ibexa_corporate_account:
    content_type_mappings:
        company: your_ct_identifier
```

!!! caution "Migration"

    If you decide to change deafult names of content types, during migration you have to adjust files accordingly.


## Registration

You can define what fields are required in the Customer Portal registration form.
To do so, [create and configure user registration form](create_user_registration_form.md).

## Address

With the Address field type, you can customize address fields and configure them per country.
To learn more, see [Address field type documentation](addressfield.md).

## Templates

You can also define new templates for, among others: invitation email, reset password message and the information screens after any of the user's actions.

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

## Order management

Reviewing pending and past orders in Customer Portal requires that you configure all currencies that any of the customers may use under the `ibexa.system.<siteaccess_name>.product_catalog.currencies` key.
The first currency from the list is then used for filtering the orders list and calculating the **Average order** and **Total amount** values.

For more information, see [Enable purchasing products](enable_purchasing_products.md).