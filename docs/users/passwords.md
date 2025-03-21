---
description: Set up user password rules.
---

# Passwords

## Changing and recovering passwords

The user may request to change their password, or may forget it and ask to have it reset.

To change password, the user must have the `user/password` permission.

When the user requests a reset of a forgotten password, an email is sent to them with a token.
It allows them to create a new password.

For information about how to create and configure the template, see [Add forgot password option](add_forgot_password_option.md)

The template for this email is located in `Resources/views/forgot_password/mail/forgot_user_password.html.twig` in `ibexa/user`.
You can [customize it according to your needs](add_login_form.md#customize-login-form).

The validity of the password recovery token can be set by using the `ibexa.system.<siteaccess>.security.token_interval_spec` parameter.
By default, it's set to `PT1H` (one hour).

## Revoking passwords

In case of a security situation such as a data leakage, you may need to force users to change their passwords.
You can do it with the help of the `ibexa:user:expire-password` command, which revokes the passwords for specific users, user groups, or users belonging to the chosen content type.

To select which users to revoke passwords for, use one of the following options with the command:

- `--user-id|-u` - the ID of the user. Accepts multiple user IDs
- `--user-group-id|-ug` - the ID of the user group. Accepts multiple group IDs
- `--user-content-type-identifier|-ct` - the identifier of the user content type. Accepts multiple content types

You can use the following additional options with the command:

- `--force|-f` - commits the change, otherwise the command only performs a dry run
- `--iteration-count|-c` - defines how many users are fetched at once. Lowering this value helps with memory issues
- `--password-ttl|-t` - number of days after which new passwords expire. Used when the command enables password expiration for user content types that don't use it yet.

For example, to revoke the passwords of all users of the `user` content type, run:

``` bash
php bin/console ibexa:user:expire-password --user-content-type-identifier=user --force
```

To perform a dry run (without saving the results) of revoking passwords of all users from user group 13, run:

``` bash
php bin/console ibexa:user:expire-password --user-group-id=13
```

## Password rules

You can customize the password policy in your project.
Each password setting is customizable per user field type.
You can change the [password attributes](#password-attributes) or [password expiration settings](#password-expiration), and determine the rules for [repeating passwords](#repeating-passwords).

To access the password settings:

1. In the back office, go to **Content** -> **Content types**.
1. In the **Content type groups** table, click **Users**.
1. Edit the **User** content type.
1. In the **Field definitions** list, view the settings for **User account (ezuser)**.

!!! tip

    There can be other content types that function as users, beyond the built-in user content type.
    For details, see [User Identifiers](repository_configuration.md#user-identifiers).

## Password attributes

In the **User account (ezuser)** Field definition, you can determine if the password must contain at least:

- One uppercase letter
- One lowercase letter
- One number
- One non-alphanumeric character

You can also set the minimum password length.

## Password expiration

In the **User account (ezuser)** field definition, you can set password expiration rules, which forces users to change their passwords periodically.

![Password expiry settings](password_expiry.png)

You can also decide when the user is notified that they need to change their password.
The notification is displayed in the back office after login and in the user content item's preview.

## Repeating passwords

You can set a rule that the password cannot be reused.
You set it for the user content type in the **User account (ezuser)** field type's settings.
When this is set, the user cannot type in the same password when it expires.
It has to be changed to a new one.

This only checks the new password against the current one.
A password that has been used before can be used again.

This rule is valid by default when password expiration is set.

## Breached passwords

You can set a rule that prevents using passwords which have been exposed in a public breach.
To do this, in the **User account (ezuser)** field definition, select "Password must not be contained in a public breach".

![Protection against using breached passwords](password_breached.png)

This rule checks the password against known password dumps by using the https://haveibeenpwned.com/ API.
It doesn't check existing passwords, so it doesn't block login for anyone.
It applies only to new passwords when users change them.

!!! note

    The password itself isn't sent to the https://haveibeenpwned.com/ API, which makes this check secure.

    For more information on how that is possible, see [Validating Leaked Passwords with k-Anonymity](https://blog.cloudflare.com/validating-leaked-passwords-with-k-anonymity/).
