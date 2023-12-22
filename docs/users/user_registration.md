---
description: Register new users.
---

# Register new users

You can allow your users to create accounts by employing the `/register` route. This route leads to a registration form that, when filled in, creates a new User Content item in the repository.

### User types

There are two user types defined: `users` and `customers`.
`users` are Back Office users that are involved in creating the page such as editors, and `customers` are frontend users.
To decide where the user should be registered to, you need to specify their user type under the `ibexa.system.<scope>.user_type_identifier` [configuration key](configuration.md#configuration-files).

```yaml
ibexa:
    system:
        <scope>:
            user_registration:
                user_type_identifier: user
```

### User Groups

By default, new Users generated in this way are placed in the Guest accounts group. You can select a different default group in the following section of configuration:

``` yaml
ibexa:
    system:
        default:
            user_registration:
                group_id: <userGroupContentId>
```

### Registration form field configuration

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

### Other user management templates

You can also modify form templates in the following way:

**Changing user password:**

``` yaml
ibexa:
    system:
        <siteaccess>:
            user_change_password:
                templates:
                    form: <path_to_template>
```

**Password recovery forms:**

``` yaml
ibexa.site_access.config.<siteaccess>.user_forgot_password.templates.form
ibexa.site_access.config.<siteaccess>.user_forgot_password_success.templates.form
ibexa.site_access.config.<siteaccess>.user_forgot_password_login.templates.form
ibexa.site_access.config.<siteaccess>.user_forgot_password.templates.mail
```

**Resetting password:**

``` yaml
ibexa.site_access.config.<siteaccess>.user_reset_password.templates.form
ibexa.site_access.config.<siteaccess>.user_reset_password.templates.invalid_link
ibexa.site_access.config.<siteaccess>.user_reset_password.templates.success
```

**User settings:**

``` yaml
ibexa.site_access.config.<siteaccess>.user_settings.templates.list
ibexa.site_access.config.<siteaccess>.user_settings.templates.update
```

**Changing registration form templates:**

To change the registration form template, follow instructions in [Invitation and registration form templates](invitations.md#invitation-and-registration-form-templates).