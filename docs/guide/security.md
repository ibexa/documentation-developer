# Development Security

!!! tip

    See [Permissions](permissions.md) for information about the permissions system in eZ Platform.

## Symfony authentication

To use Symfony authentication with eZ Platform, use the following configuration (in `app/config/security.yml`):

``` yaml
security:
    firewalls:
        ezpublish_front:
            pattern: ^/
            anonymous: ~
            form_login:
                require_previous_session: false
            logout: ~
```

And in `app/config/routing.yml`:

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
    However, remember to match `login_path`, `check_path` and `logout.path` from `security.yml`.

    See [security configuration reference](http://symfony.com/doc/3.4/reference/configuration/security.html) and [standard login form documentation](http://symfony.com/doc/3.4/security/form_login_setup.html).

### Authentication using Symfony Security component

Authentication is provided using the Symfony Security component.

[Native and universal `form_login`](http://symfony.com/doc/3.4/security/form_login_setup.html) is used, in conjunction with an extended `DaoAuthenticationProvider` (DAO stands for *Data Access Object*), the `RepositoryAuthenticationProvider`. Native behavior of `DaoAuthenticationProvider` has been preserved, making it possible to still use it for pure Symfony applications.

#### Security controller

A `SecurityController` is used to manage all security-related actions and is thus used to display the login form. It follows all standards explained in [Symfony security documentation](http://symfony.com/doc/3.4/security/form_login_setup.html).

The base template used is [`EzPublishCoreBundle:Security:login.html.twig`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Bundle/EzPublishCoreBundle/Resources/views/Security/login.html.twig).

The layout used by default is `%ezpublish.content_view.viewbase_layout%` (empty layout) but can be configured together with the login template (in `ezplatform.yml`):

``` yaml
ezpublish:
    system:
        my_siteaccess:
            user:
                layout: AcmeTestBundle::layout.html.twig
                login_template: AcmeTestBundle:User:login.html.twig
```

##### Redirection after login

By default, Symfony redirects to the [URI configured in `security.yml` as `default_target_path`](http://symfony.com/doc/3.4/reference/configuration/security.html). If not set, it defaults to `/`.

#### Remember me

It is possible to use the "Remember me" functionality.
Refer to the [Symfony cookbook on this topic](http://symfony.com/doc/3.4/security/remember_me.html).

If you want to use this feature, you must at least extend the login template in order to add the required checkbox:

``` html+twig
{% extends "EzPublishCoreBundle:Security:login.html.twig" %}

{% block login_fields %}
    {{ parent() }}
    <input type="checkbox" id="remember_me" name="_remember_me" checked />
    <label for="remember_me">Keep me logged in</label>
{% endblock %}
```

#### Login handlers / SSO

Symfony provides native support for [multiple user providers](https://symfony.com/doc/3.4/security/multiple_user_providers.html). This makes it easy to integrate any kind of login handlers, including SSO and existing third-party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

See [Authenticating a user with multiple user provider](user_management.md#authenticating-user-with-multiple-user-providers) for more information.

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
