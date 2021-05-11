# User management

## Passwords

### Changing and recovering passwords

The user may request to change their password, or may forget it and ask to have it reset.

To change password, the user must have the `user/password` permission.

When the user requests a reset of a forgotten password, an email is sent to them with a token.
It allows them to create a new password.

The template for this email is located in `templates/Security/mail/forgot_user_password.html.twig` in `ezsystems/ezplatform-user`.
You can [customize it according to your needs](#customize-login-form).

The validity of the password recovery token can be set using the `ezplatform.system.<siteaccess>.security.token_interval_spec` parameter.
By default it is set to `PT1H` (one hour).

## Password rules

You can customize the password policy in your project.
Each password setting is customizable per User Field Type.
You can change the [password attributes](#password-attributes) or [password expiration settings](#password-expiration), and determine the rules for [repeating passwords](#repeating-passwords).

To access the password settings:

1. In the Back Office, in the **Admin** Panel, open the **Content Types** tab.
1. In the **Content Type groups** table, click on **Users**.
1. Edit the User Content Type.
1. In the **Field definitions** list, view the settings for **User account (ezuser)**.

!!! tip

    There can be other Content Types that function as users, beyond the built-in User Content Type.
    For details, see [User Identifiers](../config_repository.md#user-identifiers).

### Password attributes

In the **User account (ezuser)** Field definition, you can determine if the password must contain at least:

- One uppercase letter
- One lowercase letter
- One number
- One non-alphanumeric character

You can also set the minimum password length.

### Password expiration

In the **User account (ezuser)** Field definition, you can set password expiration rules, which will force users to change their passwords periodically.

![Password expiry settings](../img/password_expiry.png)

You can also decide when the user will be notified that they need to change their password.
The notification will be displayed in the Back Office after login and in the User Content item's preview.

### Repeating passwords

You can set a rule that the password cannot be reused.
You set it for the User Content Type in the **User account (ezuser)** Field Type's settings.
When this is set, the user cannot type in the same password when it expires.
It has to be changed to a new one.

This only checks the new password against the current one.
A password that has been used before can be used again.

This rule is valid by default when password expiration is set.

## Login methods

Two login methods are available: with User name or with email.

Providers for these two methods are `ezpublish.security.user_provider.username`
and `ezpublish.security.user_provider.email`, respectively.

You can configure which method is allowed in `packages/security.yaml`:

``` yaml
security:
    providers:
        ezplatform:
            chain:
                providers: [ezplatform_username, ezplatform_email]

        ezplatform_username:
            id: ezpublish.security.user_provider.username

        ezplatform_email:
            id: ezpublish.security.user_provider.email

    firewalls:
        #...    
        ezpublish_front:
            # ...
            provider: ezplatform
```

You can customize per User Field whether the email address used as a login method must be unique or not.

To check that all existing User accounts have unique emails,
run the `ibexa:user:audit-database` command.
It will list all User accounts with duplicate emails.

!!! caution

    Because logging in with email was not available until version v3.0,
    you can come across issues if you use the option on an existing database.
    
    This may happen if more than one account uses the same email address.
    Login through the User name will still be available.
    
    To resolve the issues, run `ibexa:user:audit-database`
    and manually modify accounts that have duplicate emails.

### Login rules

You can set the rules for allowed User names in the Back Office per User Field.

The rules are set using regular expressions.

For example, to ensure that User names can only contain lowercase letters,
set `[a-z]+$` as **Username pattern**:

![Setting a User name pattern](../img/username_pattern.png)

To check that all existing User accounts have names that fit the current pattern,
run the `ibexa:user:audit-database` command.
It will check all User accounts in the database and list those that do not fit the pattern.

## Registering new users

You can allow your users to create accounts by employing the `/register` route. This route leads to a registration form that, when filled in, creates a new User Content item in the repository.

### User Groups

By default, new Users generated in this way are placed in the Guest accounts group. You can select a different default group in the following section of configuration:

``` yaml
ezplatform:
    system:
        default:
            user_registration:
                group_id: <userGroupContentId>
```

### Registration form templates

You can use custom templates for the registration form and registration confirmation page.

The templates are defined with the following configuration:

``` yaml
ezplatform:
    system:
        default:
            user_registration:
                templates:
                    form: user/registration_form.html.twig
                    confirmation: user/registration_confirmation.html.twig
```

With this configuration you place the templates in `templates/user/registration_form.html.twig` and `templates/user/registration_confirmation.html.twig`.

Example registration form:

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <section class="ez-content-edit">
        {{ form_start(form) }}

        {% for fieldForm in form.fieldsData %}
            {% set fieldIdentifier = fieldForm.vars.data.fieldDefinition.identifier %}
            <div class="col-md-6">
                {{ form_widget(fieldForm.value, {
                    'contentData': form.vars.data
                }) }}
            </div>
            {%- do fieldForm.setRendered() -%}
        {% endfor %}

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {{ form_widget(form.register, {'attr': {
                    'class': 'btn btn-block btn-primary'
                }}) }}
            </div>
        </div>

        {{ form_end(form) }}
    </section>
{% endblock %}
```

Example confirmation form:

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

You can use a custom template for example to display information about password expiration
or to customize [other user management templates](#other-user-management-templates).

If you need only to change a template, you can use the following configuration:

```yaml
ezpublish:
    system:
        my_siteaccess:
            user:
                login_template: '@ezdesign/Security/login.html.twig'
```

In case of more advanced template customization, you can use a subscriber,
for example in `src/EventSubscriber/LoginFormViewSubscriber.php`:

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
        
        if ($view->getLastAuthenticationException() instanceof CredentialsExpiredException) {
            // View with instruction to unlock account
            $view->setTemplateIdentifier('login/expired_credentials.html.twig');
        }
    }
}
```

In the provided example, in line 23, the `PRE_CONTENT_VIEW` event is used.
You can also pass additional parameters to the view (line 35).
In this case, at the instance of exception (line 40), the subscriber displays the `expired_credentials.html.twig` template (line 42).

Remember to provide a template and point to it in the subscriber
(in this case, in `templates/login/expired_credentials.html.twig`):

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
ezpublish:
    system:
        <siteaccess>:
            user_change_password:
                templates:
                    form: <path_to_template>
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

## Authenticating user with multiple user providers

Symfony provides native support for [multiple user providers](https://symfony.com/doc/5.0/security/multiple_user_providers.html).
This makes it easy to integrate any kind of login handlers, including SSO and existing third party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

However, to be able to use *external* user providers with [[= product_name =]], a valid Platform user needs to be injected into the Repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you will either want to create a Platform User, return an existing User, or even always use a generic User.

Whenever an *external* user is matched (i.e. one that does not come from Platform repository, like coming from LDAP), [[= product_name =]] kernel initiates an `MVCEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it is up to the listener to retrieve a Platform User from the Repository and to assign it back to the event object.
This user will be injected into the repository and used for the rest of the request.

If no [[= product_name =]] User is returned, the Anonymous User will be used.

### User exposed and security token

When an *external* user is matched, a different token will be injected into the security context, the `InteractiveLoginToken`.
This token holds a `UserWrapped` instance which contains the originally matched User and the *API user* (the one from the [[= product_name =]] Repository).

Note that the *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customizing the User class

It is possible to customize the user class used by extending `ezpublish.security.login_listener` service, which defaults to `eZ\Publish\Core\MVC\Symfony\Security\EventListener\SecurityListener`.

You can override `getUser()` to return whatever User class you want, as long as it implements `eZ\Publish\Core\MVC\Symfony\Security\UserInterface`.

The following is an example of using the in-memory user provider:

``` yaml
# config/packages/security.yaml
security:
    providers:
        # Chaining in_memory and ezpublish user providers
        chain_provider:
            chain:
                providers: [in_memory, ezpublish]
        ezpublish:
            id: ezpublish.security.user_provider
        in_memory:
            memory:
                users:
                    # You will then be able to login with username "user" and password "userpass"
                    user:  { password: userpass, roles: [ 'ROLE_USER' ] }
    # The "in memory" provider requires an encoder for Symfony\Component\Security\Core\User\User
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext
```

### Implementing the listener

In the `config/services.yaml` file:

``` yaml
services:
    App\EventListener\InteractiveLoginListener:
        arguments: ['@ezpublish.api.service.user']
        tags:
            - { name: kernel.event_subscriber } 
```

Do not mix `MVCEvents::INTERACTIVE_LOGIN` event (specific to [[= product_name =]]) and `SecurityEvents::INTERACTIVE_LOGIN` event (fired by Symfony security component).

``` php
<?php

namespace App\EventListener;

use eZ\Publish\API\Repository\UserService;
use eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InteractiveLoginListener implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\API\Repository\UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public static function getSubscribedEvents()
    {
        return [
            MVCEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin'
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        // This loads a generic User and assigns it back to the event.
        // You may want to create Users here, or even load predefined Users depending on your own rules.
        $event->setApiUser($this->userService->loadUserByLogin( 'lolautruche' ));
    }
} 
```
