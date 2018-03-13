# User management

## Passwords

### Changing passwords

The user may request to change their password, or may forget it and ask to have it reset.

To change password, the user must have the `user/password` permission.

In such a case an email is sent to the user with a one-time token. It allows them to create a new password.

The template for this email is located in `/Resources/views/Security/mail/forgot_user_password.html.twig`.
You can customize it according to your needs.

The validity of the password recovery token can be set using the `ezsettings.default.security.token_interval_spec` parameter.
By default it is set to `PT1H` (one hour).
