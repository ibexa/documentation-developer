---
description: Ensure the security of your Ibexa DXP installation by using one of the available authentication methods.
---

# Development security

!!! tip

    See [Permissions](permissions.md) for information about the permissions system in [[= product_name =]].

!!! note "Security checklist"

    See the [Security checklist](security_checklist.md) for a list of security-related issues you should take care of before going live with a project.

## Symfony authentication

To use Symfony authentication with [[= product_name =]], use the following configuration (in `config/packages/security.yaml`):

``` yaml
security:
    firewalls:
        ibexa_front:
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
    defaults: { _controller: Ibexa\Core\MVC\Symfony\Controller\SecurityController::loginAction }
login_check:
    path: /login_check
logout:
    path: /logout
```

!!! note

    You can fully customize the routes and/or the controller used for login.
    However, remember to match `login_path`, `check_path` and `logout.path` from `security.yaml`.

    See [security configuration reference]([[= symfony_doc =]]/reference/configuration/security.html) and [standard login form documentation]([[= symfony_doc =]]/security.html#form-login).

### Authentication using Symfony Security component

Authentication is provided by the Symfony Security component.

[Native and universal `form_login`]([[= symfony_doc =]]/security.html#form-login) is used, in conjunction with an extended `DaoAuthenticationProvider` (DAO stands for *Data Access Object*), the `RepositoryAuthenticationProvider`.
Native behavior of `DaoAuthenticationProvider` has been preserved, making it possible to still use it for pure Symfony applications.

#### Security controller

A `SecurityController` is used to manage all security-related actions and is thus used to display the login form.
It follows all standards explained in [Symfony security documentation]([[= symfony_doc =]]/security.html#form-login).

The base template used is [`Security/login.html.twig`](https://github.com/ibexa/core/blob/5.0/src/bundle/Core/Resources/views/Security/login.html.twig).

The layout used by default is `%ibexa.content_view.viewbase_layout%` (empty layout) but can be configured together with the login template:

``` yaml
ibexa:
    system:
        my_siteaccess:
            user:
                layout: layout.html.twig
                login_template: user/login.html.twig
```

##### Redirection after login

By default, Symfony redirects to the [URI configured in `security.yaml` as `default_target_path`]([[= symfony_doc =]]/reference/configuration/security.html). If not set, it defaults to `/`.

#### Remember me

It's possible to use the "Remember me" functionality.
Refer to the [Symfony cookbook on this topic]([[= symfony_doc =]]/security/remember_me.html).

If you want to use this feature, you must at least extend the login template to add the required checkbox:

``` html+twig
{% extends "@IbexaCore/Security/login.html.twig" %}

{% block login_fields %}
    {{ parent() }}
    <input type="checkbox" id="remember_me" name="_remember_me" checked />
    <label for="remember_me">Keep me logged in</label>
{% endblock %}
```

#### Login handlers / SSO

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/user_providers.html).
This makes it easy to integrate any kind of login handlers, including SSO and existing third-party bundles (for example, [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](https://github.com/BeSimple/BeSimpleSsoAuthBundle), and more).

See [Authenticating a user with multiple user provider](user_authentication.md#authenticate-user-with-multiple-user-providers) for more information.

## JWT authentication

To use [JWT authentication](https://www.jwt.io/) with [[= product_name =]], in the provided `config/packages/lexik_jwt_authentication.yaml` file, modify the existing configuration by setting `authorization_header` to `enabled`:

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

You also need to configure Symfony firewalls for the APIs with which you want to use JWT authentication.
It's already provided in `config/packages/security.yaml`, you need to uncomment the `ibexa_jwt_rest` and the ones for the desired APIs:

``` yaml
security:
    firewalls:
        ibexa_jwt_rest:
            request_matcher: Ibexa\Rest\Security\JWTTokenCreationRESTRequestMatcher
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            stateless: true
            provider: ibexa
            json_login:
                check_path: ibexa.rest.create_token
                username_path: JWTInput.username
                password_path: JWTInput.password
                success_handler: lexik_jwt_authentication.handler.authentication_success
                failure_handler: lexik_jwt_authentication.handler.authentication_failure

        ibexa_jwt_rest.api:
            request_matcher: Ibexa\Rest\Security\AuthorizationHeaderRESTRequestMatcher
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            provider: ibexa
            stateless: true
            jwt: ~

        ibexa_jwt_graphql:
            request_matcher: Ibexa\GraphQL\Security\NonAdminGraphQLRequestMatcher
            provider: ibexa
            stateless: true
            jwt: ~
```

- `ibexa_jwt_rest` is the firewall that allows to generate a JWT token through REST or GraphQL
- `ibexa_jwt_rest.api` is the firewall to [use JWT authentication for REST API](rest_api_authentication.md#jwt-authentication) instead of session-based
- `ibexa_jwt_graphql` is the firewall to [use JWT authentication for GraphQL API](graphql.md#jwt-authentication)

For example, to use JWT authentication only for GraphQL API and keep session-based authentication for REST API:

- uncomment `ibexa_jwt_rest` and `ibexa_jwt_graphql` to activate them
- keep `ibexa_jwt_rest.api` commented and disabled

### Use PEM keys

Out of the box, JWT tokens are created by using HMAC (Hash-based Message Authentication Code) with `APP_SECRET` as the secret key and the `HS256` (HMAC-SHA256) algorithm.

You can use PEM (Privacy-enhanced Electronic Mail) keys and the `RS256` (RSA-SHA256) algorithm instead.


1. Set the `JWT_PASSPHRASE` secret

In an `.env` file, you should have the following variables:

```dotenv
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ……
```

Set your `JWT_PASSPHRASE`, its value must be strong, random, and securely stored.
For more recommendations and to learn how to generate one, see [`APP_SECRET` and other secrets](security_checklist.md#app_secret-and-other-secrets).

2\. In `config/packages/lexik_jwt_authentication.yaml`, use the following configuration:

``` yaml hl_lines="2-4 6"
lexik_jwt_authentication:
    secret_key: '%env(resolve:JWT_SECRET_KEY)%'
    public_key: '%env(resolve:JWT_PUBLIC_KEY)%'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
    encoder:
        signature_algorithm: RS256
    # …
```

3\. Generate a [PEM encoded key pair](https://symfony.com/bundles/LexikJWTAuthenticationBundle/2.x/index.html#generate-the-ssl-keys) by using the following command which outputs key files in the `config/jwt` directory:

```bash
php bin/console lexik:jwt:generate-keypair
```

!!! note "[[= product_name_cloud =]]"

    To store the tokens on [[= product_name_cloud =]], define the `config/jwt` directory as a volume in the `.platform.app.yaml` file. 
    In 3-node cluster setups, ensure that the key pair is the same on all 3 servers. 
    You can use a network share, or use a local mount and manually copy the key pair between the servers.

For more information, see [LexikJWTAuthenticationBundle configuration reference](https://symfony.com/bundles/LexikJWTAuthenticationBundle/2.x/1-configuration-reference.html).
