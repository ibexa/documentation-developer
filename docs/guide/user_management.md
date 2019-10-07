# User management

## Passwords

### Changing and recovering passwords

The user may request to change their password, or may forget it and ask to have it reset.

To change password, the user must have the `user/password` permission.

When the user requests a reset of a forgotten password, an email is sent to them with a token.
It allows them to create a new password.

The template for this email is located in `/Resources/views/Security/mail/forgot_user_password.html.twig` in `ezsystems/ezplatform-user`.
You can customize it according to your needs.

The validity of the password recovery token can be set using the `ezpublish.system.<siteaccess>.security.token_interval_spec` parameter.
By default it is set to `PT1H` (one hour).

### Setting password expiration

You can set password expiry rules, which will force users to change their passwords periodically.

Password expiry is defined per User Field Type.
You can set it for the User Content Type in the `ezuser` Field Type's settings:

![Password expiry settings](img/password_expiry.png)

You can also decide when the user will be notified that they need to change their password.
The notification will be displayed in the Back Office after login and in the User Content item's preview.

### Repeating passwords

You can set a rule that the password cannot be reused.
You set it for the User Content Type in the `ezuser` Field Type's settings.
When this is set, the user will not be able to set a password that had been in use before.

This rule is valid by default when password expiration is set.

## Registering new users

You can allow your users to create accounts by employing the `/register` route. This route leads to a registration form that, when filled in, creates a new User Content item in the repository.

### User Groups

By default, new Users generated in this way are placed in the Guest accounts group. You can select a different default group in the following section of configuration:

``` yaml
ezpublish:
    system:
        default:
            user_registration:
                group_id: <userGroupContentId>
```

### Registration form templates

You can use custom templates for the registration form and registration confirmation page.

The templates are defined with the following configuration:

``` yaml
ezpublish:
    system:
        default:
            user_registration:
                templates:
                    form: user/registration_form.html.twig
                    confirmation: user/registration_confirmation.html.twig
```

With this configuration you place the templates in `app/Resources/views/user/registration_form.html.twig` and `app/Resources/views/user/registration_confirmation.html.twig`.

Here are default templates that you can reuse and/or modify:

**Registration form:**

``` html+twig
{% extends noLayout is defined and noLayout == true ? viewbaseLayout : pagelayout %}
{% block content %}
     {% import "EzSystemsRepositoryFormsBundle:Content:content_form.html.twig" as contentForms %}

     <section class="ez-content-edit">
         {{ contentForms.display_form(form) }}
     </section>
{% endblock %}
```

**Registration confirmation:**

``` html+twig
{% extends noLayout is defined and noLayout == true ? viewbaseLayout : pagelayout %}
{% block content %}
    <h1>Your account has been created</h1>
    <p class="user-register-confirmation-message">
        Thank you for registering an account. You can now <a href="{{ path('login') }}">login</a>.
    </p>
{% endblock %}
```

### Other user management templates

You can also modify the following form templates:

**Changing user password:**

``` yaml
ezsettings.<siteaccess>.user_change_password.templates.form
ezsettings.<siteaccess>.user_change_password.templates.success
```

**Password recovery forms:**

``` yaml
ezsettings.<siteaccess>.user_forgot_password.templates.form
ezsettings.<siteaccess>.user_forgot_password_success.templates.form
ezsettings.<siteaccess>.user_forgot_password_login.templates.form
ezsettings.<siteaccess>.user_forgot_password.templates.mail
```

**Resetting password:**

``` yaml
ezsettings.<siteaccess>.user_reset_password.templates.form
ezsettings.<siteaccess>.user_reset_password.templates.invalid_link
ezsettings.<siteaccess>.user_reset_password.templates.success
```

**User settings:**

``` yaml
ezsettings.<siteaccess>.user_settings.templates.list
ezsettings.<siteaccess>.user_settings.templates.update
```
