---
description: Customize user authentication.
---

# User authentication

## Authenticate user with multiple user providers

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/user_providers.html).
This makes it easier to integrate any kind of login handlers, including SSO and existing third party bundles (for example, [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), or [BeSimpleSsoAuthBundle](https://github.com/BeSimple/BeSimpleSsoAuthBundle)).

However, to be able to use *external* user providers with [[= product_name =]], a valid Platform user needs to be injected into the repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you either want to create a Platform user, return an existing user, or even always use a generic user.

Whenever an *external* user is matched (i.e. one that doesn't come from Platform repository, like coming from LDAP), [[= product_name =]] kernel initiates an `MVCEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `Ibexa\Core\MVC\Symfony\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it's up to the listener to retrieve a Platform user from the repository and to assign it back to the event object.
This user is injected into the repository and used for the rest of the request.

If no [[= product_name =]] user is returned, the Anonymous user is used.

### User exposed and security token

When an *external* user is matched, a different token is injected into the security context, the `InteractiveLoginToken`.
This token holds a `UserWrapped` instance which contains the originally matched user and the *API user* (the one from the [[= product_name =]] repository).

The *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customize the user class

It's possible to customize the user class used by extending `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener` service, which defaults to `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener`.

You can override `getUser()` to return whatever user class you want, as long as it implements `Ibexa\Core\MVC\Symfony\Security\UserInterface`.

The following is an example of using the in-memory user provider:

``` yaml
# config/packages/security.yaml
security:
    providers:
        # Chaining in_memory and ibexa user providers
        chain_provider:
            chain:
                providers: [in_memory, ibexa]
        ibexa:
            id: ibexa.security.user_provider
        in_memory:
            memory:
                users:
                    # You will then be able to log in with username "from_memory_user" and password "from_memory_pass"
                    from_memory_user: { password: from_memory_pass, roles: [ 'ROLE_USER' ] }
    password_hashers:
        # The "in memory" provider requires an encoder
        Symfony\Component\Security\Core\User\InMemoryUser: plaintext
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
    firewalls:
        ibexa_front:
            pattern: ^/
            provider: chain_provider
            # …
```

### Implement the listener

In the `config/services.yaml` file:

``` yaml
services:
    App\EventSubscriber\InteractiveLoginSubscriber:
        arguments: ['@ibexa.api.service.user']
        tags:
            - { name: kernel.event_subscriber }
```

Don't mix `MVCEvents::INTERACTIVE_LOGIN` event (specific to [[= product_name =]]) and `SecurityEvents::INTERACTIVE_LOGIN` event (fired by Symfony security component).

``` php
<?php

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\MVC\Symfony\Security\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin'
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $userMap = [
            'from_memory_user' => 'generic_customer_account',
        ];
        $userLogin = $userMap[$event->getAuthenticationToken()->getUserIdentifier()] ?? 'anonymous';
        $ibexaUser = $this->userService->loadUserByLogin($userLogin);
        $event->getAuthenticationToken()->setUser(new User($ibexaUser));

        return $event;
    }
}
```
