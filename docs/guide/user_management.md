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
When this is set, the user cannot type in the same password when it expires.
It has to be changed to a new one.

This only checks the new password against the current one.
A password that has been used before can be used again.

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

Symfony provides native support for [multiple user providers](https://symfony.com/doc/3.4/security/multiple_user_providers.html). This makes it easy to integrate any kind of login handlers, including SSO and existing third party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

!!! caution

    `BeSimpleSsoAuthBundle` requires an outdated version of `kriswallsmith/buzz` package (>=0.7,<=0.16.1) and therefore cannot be used in eZ Platform 2.5 until that is solved in `BeSimpleSsoAuthBundle` itself.
    
However, to be able to use *external* user providers with eZ Platform, a valid Platform user needs to be injected into the repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you will either want to create a Platform user, return an existing user, or even always use a generic user.

Whenever an *external* user is matched (i.e. one that does not come from Platform repository, like coming from LDAP), eZ Platform kernel initiates an `MVCEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it is up to the listener to retrieve a Platform user from the repository and to assign it back to the event object.
This user will be injected into the repository and used for the rest of the request.

If no eZ Platform user is returned, the Anonymous User will be used.

### User exposed and security token

When an *external* user is matched, a different token will be injected into the security context, the `InteractiveLoginToken`.
This token holds a `UserWrapped` instance which contains the originally matched user and the *API user* (the one from the eZ Platform repository).

Note that the *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customizing the User class

It is possible to customize the user class used by extending `ezpublish.security.login_listener` service, which defaults to `eZ\Publish\Core\MVC\Symfony\Security\EventListener\SecurityListener`.

You can override `getUser()` to return whatever User class you want, as long as it implements `eZ\Publish\Core\MVC\Symfony\Security\UserInterface`.

The following is an example of using the in-memory user provider:

``` yaml
# app/config/security.yml
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

In the `services.yml` file in your AcmeExampleBundle:

``` yaml
parameters:
    acme_example.interactive_event_listener.class: Acme\ExampleBundle\EventListener\InteractiveLoginListener

services:
    acme_example.interactive_event_listener:
        class: '%acme_example.interactive_event_listener.class%'
        arguments: ['@ezpublish.api.service.user']
        tags:
            - { name: kernel.event_subscriber } 
```

Do not mix `MVCEvents::INTERACTIVE_LOGIN` event (specific to eZ Platform) and `SecurityEvents::INTERACTIVE_LOGIN` event (fired by Symfony security component).

``` php
<?php

namespace Acme\ExampleBundle\EventListener;

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
        // This loads a generic user and assigns it back to the event.
        // You may want to create users here, or even load predefined users depending on your own rules.
        $event->setApiUser($this->userService->loadUserByLogin( 'lolautruche' ));
    }
} 
```
