# Development Security

!!! tip

    See [Permissions](permissions.md) for information about the permissions system in [[= product_name =]].

!!! note "Security checklist"

    See the [Security checklist](security_checklist.md) for a list of security-related issues
    you should take care of before going live with a project.

## Symfony authentication

To use Symfony authentication with [[= product_name =]], use the following configuration (in `config/packages/security.yaml`):

``` yaml
security:
    firewalls:
        ezpublish_front:
            pattern: ^/
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            anonymous: ~
            form_login:
                require_previous_session: false
            logout: ~
```

And in `config/routes.yaml`:

``` yaml
login:
    path: /login
    defaults: { _controller: ezpublish.security.controller:loginAction }
login_check:
    path: /login_check
logout:
    path: /logout
```

!!! note

    You can fully customize the routes and/or the controller used for login.
    However, remember to match `login_path`, `check_path` and `logout.path` from `security.yaml`.

    See [security configuration reference]([[= symfony_doc =]]/reference/configuration/security.html) and [standard login form documentation]([[= symfony_doc =]]/security/form_login_setup.html).

### Authentication using Symfony Security component

Authentication is provided using the Symfony Security component.

[Native and universal `form_login`]([[= symfony_doc =]]/security/form_login_setup.html) is used, in conjunction with an extended `DaoAuthenticationProvider` (DAO stands for *Data Access Object*), the `RepositoryAuthenticationProvider`. Native behavior of `DaoAuthenticationProvider` has been preserved, making it possible to still use it for pure Symfony applications.

#### Security controller

A `SecurityController` is used to manage all security-related actions and is thus used to display the login form. It follows all standards explained in [Symfony security documentation]([[= symfony_doc =]]/security/form_login_setup.html).

The base template used is [`Security/login.html.twig`](https://github.com/ibexa/core/blob/main/src/bundle/Core/Resources/views/Security/login.html.twig).

The layout used by default is `%ezpublish.content_view.viewbase_layout%` (empty layout) but can be configured together with the login template:

``` yaml
ezplatform:
    system:
        my_siteaccess:
            user:
                layout: layout.html.twig
                login_template: user/login.html.twig
```

##### Redirection after login

By default, Symfony redirects to the [URI configured in `security.yaml` as `default_target_path`]([[= symfony_doc =]]/reference/configuration/security.html). If not set, it defaults to `/`.

#### Remember me

It is possible to use the "Remember me" functionality.
Refer to the [Symfony cookbook on this topic]([[= symfony_doc =]]/security/remember_me.html).

If you want to use this feature, you must at least extend the login template in order to add the required checkbox:

``` html+twig
{% extends "@EzPublishCore/Security/login.html.twig" %}

{% block login_fields %}
    {{ parent() }}
    <input type="checkbox" id="remember_me" name="_remember_me" checked />
    <label for="remember_me">Keep me logged in</label>
{% endblock %}
```

#### Login handlers / SSO

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/multiple_user_providers.html). This makes it easy to integrate any kind of login handlers, including SSO and existing third-party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

See [Authenticating a user with multiple user provider](user_management/user_management.md#authenticating-user-with-multiple-user-providers) for more information.

## JWT authentication

To use [JWT authentication](https://jwt.io/) with eZ Platform, in the provided ` config/packages/lexik_jwt_authentication.yaml` file,
modify the existing configuration by setting `authorization_header` to `enabled`:

``` yaml hl_lines="8"
lexik_jwt_authentication:
    secret_key: '%env(APP_SECRET)%'
    encoder:
        signature_algorithm: HS256
    # Disabled by default, because Page builder uses a custom extractor
    token_extractors:
        authorization_header:
            enabled: true
        cookie:
            enabled: false
        query_parameter:
            enabled: false
```

You also need a new Symfony firewall configuration for REST and/or GraphQL APIs.
It is already provided in `config/packages/security.yaml`, you only need to uncomment it:

``` yaml
security:
    firewalls:
        ezplatform_rest:
            request_matcher: Ibexa\AdminUi\REST\Security\NonAdminRESTRequestMatcher
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            anonymous: ~
            guard:
                authenticators:
                    - lexik_jwt_authentication.jwt_token_authenticator
                entry_point: lexik_jwt_authentication.jwt_token_authenticator
            stateless: true

        ezplatform_graphql:
            request_matcher: Ibexa\GraphQL\Security\NonAdminGraphQLRequestMatcher
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            anonymous: ~
            guard:
                authenticators:
                    - lexik_jwt_authentication.jwt_token_authenticator
                entry_point: lexik_jwt_authentication.jwt_token_authenticator
            stateless: true
```
