---
description: Customize user authentication.
---

# User authentication

## Authenticate user with multiple user providers

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/multiple_user_providers.html).
This makes it easier to integrate any kind of login handlers, including SSO and existing third party bundles (e.g. [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), [BeSimpleSsoAuthBundle](http://github.com/BeSimple/BeSimpleSsoAuthBundle), etc.).

However, to be able to use *external* user providers with [[= product_name =]], a valid Platform user needs to be injected into the Repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you either want to create a Platform User, return an existing User, or even always use a generic User.

Whenever an *external* user is matched (i.e. one that does not come from Platform repository, like coming from LDAP), [[= product_name =]] kernel initiates an `MVCEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `Ibexa\Core\MVC\Symfony\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it is up to the listener to retrieve a Platform User from the Repository and to assign it back to the event object.
This user is injected into the repository and used for the rest of the request.

If no [[= product_name =]] User is returned, the Anonymous User is used.

### User exposed and security token

When an *external* user is matched, a different token is injected into the security context, the `InteractiveLoginToken`.
This token holds a `UserWrapped` instance which contains the originally matched User and the *API user* (the one from the [[= product_name =]] Repository).

The *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customize the User class

It is possible to customize the user class used by extending `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener` service, which defaults to `Ibexa\Core\MVC\Symfony\Security\EventListener\SecurityListener`.

You can override `getUser()` to return whatever User class you want, as long as it implements `Ibexa\Core\MVC\Symfony\Security\UserInterface`.

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
                    # You will then be able to login with username "user" and password "userpass"
                    user:  { password: userpass, roles: [ 'ROLE_USER' ] }
    # The "in memory" provider requires an encoder for Symfony\Component\Security\Core\User\User
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext
```

### Implement the listener

In the `config/services.yaml` file:

``` yaml
services:
    App\EventListener\InteractiveLoginListener:
        arguments: ['@ibexa.api.service.user']
        tags:
            - { name: kernel.event_subscriber } 
```

Do not mix `MVCEvents::INTERACTIVE_LOGIN` event (specific to [[= product_name =]]) and `SecurityEvents::INTERACTIVE_LOGIN` event (fired by Symfony security component).

``` php
<?php

namespace App\EventListener;

use Ibexa\Contracts\Core\Repository\UserService;
use eIbexa\Core\MVC\Symfony\Event\InteractiveLoginEvent;
use Ibexa\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InteractiveLoginListener implements EventSubscriberInterface
{
    /**
     * @var \Ibexa\Contracts\Core\Repository\UserService
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
