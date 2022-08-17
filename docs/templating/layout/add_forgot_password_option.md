---
description: Add a "forgot password" form and configure templates for it.
---

# Add "forgot password" option

The "forgot password" option allows users of a specific SiteAccess, admin or front, to request a password change.
You can customize the template used in the `/user/forgot-password` route.

Follow the instructions to create and configure a "forgot password" form.

Edit `config/packages/ibexa.yaml` and add the following configuration:

```yaml
ibexa:
    system:
        <siteaccess>:
            user_forgot_password:
                templates:
                    form: <path_to_template>
                    mail: <path_to_template>
```

Under the `templates` key, provide the path to templates responsible for rendering the forgot password form (`form`) and email (`mail`),
which users receive after they request a password change.

The [default templates](https://github.com/ibexa/user/tree/main/src/bundle/Resources/views) for forgot password form and email are located in `ibexa/user/src/bundle/Resources/views`.
The [templates](https://github.com/ibexa/admin-ui/tree/main/src/bundle/Resources/views/themes/admin/account/forgot_password) specific for the Back Office are in `ibexa/admin-ui/src/bundle/Resources/views/themes/admin/account`.

You can also modify [other user management templates](user_management.md#other-user-management-templates).

To add a link redirecting to the reset password form, in the page layout template, provide the following code:

```html+twig
<a href="{{ path('ibexa.user.forgot_password') }}" tabindex="4">{{ 'authentication.forgot_password'|trans|desc('Forgot password?') }}</a>
```

You can customize the layout of templates according to your needs.

For more information, see [Template documentation](templates.md).
