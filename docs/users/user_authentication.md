---
description: Customize user authentication.
month_change: true
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

Create a `src/EventSubscriber/AuthenticationTokenCreatedSubscriber.php` that subscribes to the `AuthenticationTokenCreatedEvent` event and maps an authenticated in-memory user to an [[= product_name_base =]] user when necessary:

``` php
[[= include_file('code_samples/user_management/in_memory/src/EventSubscriber/AuthenticationTokenCreatedSubscriber.php') =]]
```

In `config/packages/security.yaml`, add the `memory` and `chain` user providers, store some in-memory users with their passwords in plain text and a basic role, set a `plaintext` password encoder for the `memory` provider's `InMemoryUser`, and configure the firewall to use the `chain` provider:

``` yaml hl_lines="4 9-14 18-20 26"
[[= include_file('code_samples/user_management/in_memory/config/packages/security.yaml') =]]
```

In the `config/services.yaml` file, declare the subscriber as a service to pass your user map.
Since it implements the `EventSubscriberInterface`, it's automatically tagged as a `kernel.event_subscriber`.
The config resolver and user service injections are auto-wired automatically.

``` yaml
[[= include_file('code_samples/user_management/in_memory/config/services.yaml') =]]
```

You can list the subscribers with the following command to check their order:

``` bash
php bin/console debug:event-dispatcher AuthenticationTokenCreatedEvent
```

Notice that the example subscriber priority is `11` so it's executed before the `Ibexa\Core\MVC\Symfony\Security\Authentication\EventSubscriber\OnAuthenticationTokenCreatedRepositoryUserSubscriber` which set the [[= product_name_base =]] user as the current user.

From the back office, create the mapped users.
For this example, create a new user with the login `generic_customer` and a random password so the mapping works correctly.
This account can belong to either the **Customers** or the **Anonymous users** group.

You can now log in with an in-memory user.
In the Symfony debug toolbar, you should see the in-memory user as this example uses `UserWrapped`.
