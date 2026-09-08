---
description: Register new users.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Registration, forgotten password, and user settings templates are all configured per
    SiteAccess. Confirm which of these per-SiteAccess settings survive once SiteAccess
    configuration moves to a UI.

    Links to the deleted 8_enable_account_registration.md page were removed; check that
    the surrounding text still reads correctly.
---

# Register new users

You can allow your users to create accounts by using the `/register` route.
This route leads to a registration form that, when filled in, creates a new user content item in the repository.
To give anonymous users the possibility to register themselves, grant the anonymous user the `user` / `register` [policy](/permissions/policies.md).

## User types

There are two user types defined: `users` and `customers`.
`users` are back office users that are involved in creating the page such as editors, and `customers` are frontend users.
To decide where the user should be registered to, you need to specify their user type under the `ibexa.system.<scope>.user_type_identifier` [configuration key](configuration.md#configuration-files).

```yaml
ibexa:
    system:
        <scope>:
            user_registration:
                user_type_identifier: user
```

## User groups

By default, new users generated in this way are placed in the Guest accounts group.
You can select a different default group in the following section of configuration:

``` yaml
ibexa:
    system:
        default:
            user_registration:
                group_remote_id: <userGroupContentRemoteId>
```

## Registration form field configuration

To modify the registration form template, add or remove fields under the `allowed_field_definitions_identifiers` [configuration key](configuration.md#configuration-files):

```yaml
ibexa:
    system:
        <scope>:
            user_registration:
                user_type_identifier: user
                form:
                    allowed_field_definitions_identifiers:
                        - first_name
                        - last_name
                        - user_account
```
