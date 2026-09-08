---
description: Customize user authentication.
month_change: false
---

# User authentication

## Authenticate user with multiple user providers

Symfony provides native support for [multiple user providers]([[= symfony_doc =]]/security/user_providers.html).
This makes it easier to integrate any kind of login handlers, including SSO and existing third party bundles (for example, [FR3DLdapBundle](https://github.com/Maks3w/FR3DLdapBundle), [HWIOauthBundle](https://github.com/hwi/HWIOAuthBundle), [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle), or [BeSimpleSsoAuthBundle](https://github.com/BeSimple/BeSimpleSsoAuthBundle)).

However, to be able to use *external* user providers with [[= product_name =]], a valid [[= product_name_base =]] user needs to be injected into the repository.
This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you either want to create and return an [[= product_name_base =]] user, or return an existing user, even a generic one.

Whenever a user is matched and authenticated, Symfony initiates an `AuthenticationTokenCreatedEvent`.
Every service listening to this event receives an object containing the original security token, which holds the matched user, and a [passport]([[= symfony_doc =]]/security/custom_authenticator.html#security-passports).

Then, it's up to a listener to retrieve an [[= product_name_base =]] user from the repository.

This [[= product_name_base =]] user can be:

- embedded into `Ibexa\Core\MVC\Symfony\Security\User` while forgetting about the original user
- wrapped into `Ibexa\Core\MVC\Symfony\Security\UserWrapped` with the original user if needed

Finally, the user is assigned back into the event's token for the rest of the process.

### User mapping example

The following example uses the [memory user provider]([[= symfony_doc =]]/security/user_providers.html#memory-user-provider), maps memory user to [[= product_name_base =]] repository user, and [chains]([[= symfony_doc =]]/security/user_providers.html#chain-user-provider) with the [[= product_name_base =]] user provider to be able to use both.

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
                    # You will then be able to login with username "user" and password "userpass"
                    user:  { password: userpass, roles: [ 'ROLE_USER' ] }
    # The "in memory" provider requires an encoder for Symfony\Component\Security\Core\User\User
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext
```
