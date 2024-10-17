---
description: Set up user login methods.
---

# Login methods

Two login methods are available: with user name or with email.

Providers for these two methods are `ibexa.security.user_provider.username` and `ibexa.security.user_provider.email`.

You can configure which method is allowed under the `security` [configuration key](configuration.md#configuration-files):

``` yaml
security:
    providers:
        ibexa:
            chain:
                providers: [ibexa_username, ibexa_email]

        ibexa_username:
            id: ibexa.security.user_provider.username

       ibexa_email:
            id: ibexa.security.user_provider.email

    firewalls:
        #...
        ibexa_front:
            # ...
            provider: ibexa
```

You can customize per user field whether the email address used as a login method must be unique or not.

To check that all existing user accounts have unique emails, run the `ibexa:user:audit-database` command.
It lists all user accounts with duplicate emails.

!!! caution

    Because logging in with email was not available until version v3.0, you can come across issues if you use the option on an existing database.

    This may happen if more than one account uses the same email address.
    Login through the user name is still available.

    To resolve the issues, run `ibexa:user:audit-database` and manually modify accounts that have duplicate emails.

## Login rules

You can set the rules for allowed user names in the back office per user field.
The rules are set using regular expressions.

For example, to ensure that user names can only contain lowercase letters, set `[a-z]+$` as **Username pattern**:

![Setting a user name pattern](username_pattern.png)

To check that all existing user accounts have names that fit the current pattern, run the `ibexa:user:audit-database` command.
It checks all user accounts in the database and lists those that don't fit the pattern.