# User management

## Passwords

### Changing and recovering passwords

The user may request to change their password, or may forget it and ask to have it reset.

To change password, the user must have the `user/password` permission.

When the user requests a reset of a forgotten password, an email is sent to them with a token.
It allows them to create a new password.

The template for this email is located in `templates/Security/mail/forgot_user_password.html.twig` in `ezsystems/ezplatform-user`.
You can [customize it according to your needs](#customize-login-form).

The validity of the password recovery token can be set using the `ezpublish.system.<siteaccess>.security.token_interval_spec` parameter.
By default it is set to `PT1H` (one hour).

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

With this configuration you place the templates in `templates/user/registration_form.html.twig` and `templates/user/registration_confirmation.html.twig`.

Here are default templates that you can reuse and/or modify:

**Registration form:**

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
     {% import "EzSystemsRepositoryFormsBundle:Content:content_form.html.twig" as contentForms %}

     <section class="ez-content-edit">
         {{ contentForms.display_form(form) }}
     </section>
{% endblock %}
```

**Registration confirmation:**

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <h1>Your account has been created</h1>
    <p class="user-register-confirmation-message">
        Thank you for registering an account. You can now <a href="{{ path('login') }}">login</a>.
    </p>
{% endblock %}
```

### Customize login form

You can use a custom template for example to display information about password expiration or to customize [other user management templates](#other-user-management-templates).

If you need only to change a template, you can use the following configuration:

```yaml
ezpublish:
    system:
        my_siteaccess:
            user:
                login_template: '@ezdesign/Security/login.html.twig'
```

In case of more advanced template customization, you can use a subscriber similar to the following:

``` php hl_lines="23 35 40 42"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use eZ\Publish\Core\MVC\Symfony\View\LoginFormView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;

final class LoginFormViewSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MVCEvents::PRE_CONTENT_VIEW => 'onPreContentView',
        ];
    }
    
    public function onPreContentView(PreContentViewEvent $event): void
    {
        $view = $event->getContentView();
        
        if (!($view instanceof LoginFormView)) {
            return ;
        }
        
        $view->addParameters([
            'foo' => 'foo',
            'bar' => 'bar'
        ]);
        
        if ($view->CredentialsExpiredException() instanceof CredentialsExpiredException) {
            // View with instruction to unlock account
            $view->setTemplateIdentifier('templates/login/expired_credentials.html.twig');
        }
    }
}

```

In the provided example, in line 23, the `PRE_CONTENT_VIEW` event is used (for details, see [eZ Publish Core events](content_rendering.md#ez-publish-core)).
You can also pass additional parameters to the view (line 35).
In this case, at the instance of exception (line 40), the subscriber displays the `expired_credentials.html.twig` template (line 42).

Remember to provide a template and point to it in the subscriber.

Template example:

```html+twig
{% extends '@ezdesign/Security/base.html.twig' %}

{%- block content -%}
    <h2 class="ez-login__header">
        {{ 'authentication.credentials_expired'|trans|desc('Your password has expired') }}
    </h2>
    <p>
        {{ 'authentication.credentials_expired.message'|trans|desc(
            'For security reasons, your password has expired and needs to be changed. An email has been sent to you with instructions.'
        ) }}
    </p>
    <p>
        <a href="{{ path('ezplatform.user.forgot_password') }}" class="btn btn-primary ez-btn ez-btn--login">
            {{ 'authentication.credentials_expired.reset_password'|trans|desc('Reset password') }}
        </a>
    </p>
{%- endblock -%}
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
