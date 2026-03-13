---
description: Customize user authentication.
---

# User authentication

## Authenticate user with multiple user providers

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/user_providers.html).
This makes it easier to integrate any kind of login handlers, including SSO and existing third party bundles (for example, [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), or [BeSimpleSsoAuthBundle](https://github.com/BeSimple/BeSimpleSsoAuthBundle)).

However, to be able to use *external* user providers with [[= product_name =]], a valid Ibexa user needs to be injected into the repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you either want to create and return an Ibexa user, or return an existing user, even a generic one.

Whenever an *external* user is matched (i.e. one that doesn't come from Platform repository, like coming from LDAP), [[= product_name =]] kernel initiates a `SecurityEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `Symfony\Component\Security\Http\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it's up to the listener to retrieve an Ibexa user from the repository and to assign it back to the event object.
This user is injected into the repository and used for the rest of the request.

If no [[= product_name =]] user is returned, the Anonymous user is used. TODO: check this statement.

### User exposed and security token

When an *external* user is matched, a different token is injected into the security context, the `InteractiveLoginToken`.
TODO: There is no such token class
This token holds a `UserWrapped` instance which contains the originally matched user and the *API user* (the one from the [[= product_name =]] repository).

The *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customize the user class

It's possible to customize the user class used by extending `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener` service, which defaults to `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener`.
TODO: There is no such class

You can override `getUser()` to return whatever user class you want, as long as it implements `Ibexa\Core\MVC\Symfony\Security\UserInterface`.

The following is an example of using the in-memory user provider:

``` yaml
# config/packages/security.yaml
[[= include_file('code_samples/user_management/in_memory/config/packages/security.yaml') =]]
```

### Implement the subscriber

In the `config/services.yaml` file:

``` yaml
[[= include_file('code_samples/user_management/in_memory/config/services.yaml') =]]
```

``` php
[[= include_file('code_samples/user_management/in_memory/src/EventSubscriber/InteractiveLoginSubscriber.php') =]]
```
