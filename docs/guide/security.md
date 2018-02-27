# Security

## Introduction

eZ Platform offers security and access control for your website using a complex permission system which allows you to define very fine-grained rights for all your users.

See [Permissions](repository.md#permissions) for more information.

## Configuration

To use Symfony authentication with eZ Platform, the configuration goes as follows:

``` yaml
# app/config/security.yml
security:
    firewalls:
        ezpublish_front:
            pattern: ^/
            anonymous: ~
            form_login:
                require_previous_session: false
            logout: ~
```

``` yaml
# app/config/routing.yml
login:
    path:   /login
    defaults:  { _controller: ezpublish.security.controller:loginAction }
login_check:
    path:   /login_check
logout:
    path:   /logout
```

!!! note

    You can fully customize the routes and/or the controller used for login. However, remember to match `login_path`, `check_path` and `logout.path` from `security.yml`.

    See [security configuration reference](http://symfony.com/doc/2.3/reference/configuration/security.html) and [standard login form documentation](http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form).

## Usage

Authentication is provided using the Symfony Security component.

### Authentication using Symfony Security component

[Native and universal `form_login`](http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form) is used, in conjunction with an extended  `DaoAuthenticationProvider` (DAO stands for *Data Access Object*), the `RepositoryAuthenticationProvider`. Native behavior of `DaoAuthenticationProvider` has been preserved, making it possible to still use it for pure Symfony applications.

#### Security controller

A `SecurityController` is used to manage all security-related actions and is thus used to display login form. It is pretty straightforward and follows all standards explained in [Symfony security documentation](http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form).

Base template used is `EzPublishCoreBundle:Security:login.html.twig` and stands as follows:

``` php
{% extends layout %}

{% block content %}
    {% block login_content %}
        {% if error %}
            <div>{{ error.message|trans }}</div>
        {% endif %}

        <form action="{{ path( 'login_check' ) }}" method="post">
        {% block login_fields %}
            <label for="username">{{ 'Username:'|trans }}</label>
            <input type="text" id="username" name="_username" value="{{ last_username }}" />

            <label for="password">{{ 'Password:'|trans }}</label>
            <input type="password" id="password" name="_password" />

            <input type="hidden" name="_csrf_token" value="{{ csrf_token("authenticate") }}" />

            {#
                If you want to control the URL the user
                is redirected to on success (more details below)
                <input type="hidden" name="_target_path" value="/account" />
            #}

            <button type="submit">{{ 'Login'|trans }}</button>
        {% endblock %}
        </form>
    {% endblock %}
{% endblock %}
```

The layout used by default is `%ezpublish.content_view.viewbase_layout%` (empty layout) but can be configured easily together with the login template:

``` yaml
# ezplatform.yml
ezpublish:
    system:
        my_siteaccess:
            user:
                layout: "AcmeTestBundle::layout.html.twig"
                login_template: "AcmeTestBundle:User:login.html.twig"
```

##### Redirection after login

By default, Symfony redirects to the [URI configured in `security.yml` as `default_target_path`](http://symfony.com/doc/2.3/reference/configuration/security.html). If not set, it will default to `/`.

This setting can be set by siteaccess, via [`default_page` setting](best_practices.md#default-page).

#### Access control

See the [documentation on access control](repository.md#permissions).

#### Remember me

It is possible to use the `remember_me` functionality. For this you can refer to the [Symfony cookbook on this topic](http://symfony.com/doc/2.3/cookbook/security/remember_me.html).

If you want to use this feature, you must at least extend the login template in order to add the required checkbox:

``` html
{# your_login_template.html.twig #}
{% extends "EzPublishCoreBundle:Security:login.html.twig" %}

{% block login_fields %}
    {{ parent() }}
    <input type="checkbox" id="remember_me" name="_remember_me" checked />
    <label for="remember_me">Keep me logged in</label>
{% endblock %}
```

#### Login handlers / SSO

Symfony provides native support for [multiple user providers](http://symfony.com/doc/2.3/book/security.html#using-multiple-user-providers). This makes it easy to integrate any kind of login handlers, including SSO and existing third-party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

Further explanation can be found in the [multiple user providers recipe](../cookbook/authenticating_a_user_with_multiple_user_providers.md).

#### Integration with Legacy

- When **not** in legacy mode, legacy `user/login` and `user/logout` views are deactivated.
- Authenticated user is injected in legacy kernel.

### Authentication with Legacy SSO Handlers

To be able to use your legacy SSO (Single Sign-on) handlers, use the following config in your `ezpublish/config/security.yml`:

``` yaml
# Use your legacy SSO handlers
security:
    firewalls:
        ezpublish_front:
            pattern: ^/
            anonymous: ~
            # Adding the following entry will activate the use of old SSO handlers.
            ezpublish_legacy_sso: ~
```

If you need to [create your legacy SSO Handler, please read this entry](http://share.ez.no/learn/ez-publish/using-a-sso-in-ez-publish).

## Security advisories

!!! caution

    ### Executable packages with Legacy Bridge

    [This issue](http://share.ez.no/community-project/security-advisories/ezsa-2018-002-the-files-uploaded-via-packages-component-are-executable) affects installations using eZ Publish Legacy, either stand-alone, or as part of eZ Platform 5.x, or in eZ Platform 1.11 and newer using LegacyBridge. If you are not using Legacy in any way, you are not affected.

    The package system, by design, allows you to package an extension into a file, and export/import such packages. Extensions can of course contain PHP scripts, and they usually do. Such scripts can be used in an attack on the server. This problem is fundamental and cannot be fixed by any other means than by removing the feature.

    By default, only the Administrator has the permissions to use the package system. It follows that the Administrator role, and any others granted packaging permissions, can only be held by users who already have access to the server, and/or can be trusted not to exploit this access.

    As a consequence eZ Publish legacy should not be used in the type of shared hosting installation where Administrators are not supposed to have access to the underlying operating system, or to other eZ Publish installations on the same server. The package system is an old part of eZ Publish legacy, and it was not designed for that kind of installation. Currently this is not considered best practice anyway - setups using e.g. Docker and Platform.sh allow you to completely separate installations from each other. This is a better way to keep things secure than relying on PHP scripts being read-only even for administrators. (The package system does not exist in eZ Platform and will not be added there, since extensions are not used there.)

    In summary:

    If you are responsible for legacy installations where administrators cannot be fully trusted not to exploit their privileges, make sure to properly lock down the package system and/or fully separate web sites from each other.
    Make sure that the administrator password(s) are secure, and not using the default administrator password.

    **Proposed quick solution for those affected:**

    If you are administrating a shared hosting solution of this kind, it may take a while to change the setup. Meanwhile, one quick way to lock down the package system is to use rewrite rules to block all access to package URLs. Apache example:

    `RewriteRule ^/package/.* - [R=403,L]`

    or with URL-based SiteAccess:

    `RewriteRule ^/my_site_access/package/.* - [R=403,L]`

    or supporting both cases, and multiple SiteAccesses:

    `RewriteRule ^(/my_site_access|/my_site_access_admin)?/package/.* - [R=403,L]`
    
    This can be placed before other rules.

    To be absolutely certain you can also (or instead of this) delete the `/kernel/package` directory in the eZ Publish web root. Please note that this will break the legacy installation wizard, since it relies on the package system to install the demo design.

    Once the situation is resolved these measures should be reversed, to bring back the package features. You may want to do a review of whether the issue may have been exploited on your server(s).
