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

Whenever a user is matched, Symfony initiates a `SecurityEvents::INTERACTIVE_LOGIN` event.
Every service listening to this event receives an `InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

Then, it's up to a listener to retrieve an Ibexa user from the repository.

This Ibexa user can be

- embedded into `Ibexa\Core\MVC\Symfony\Security\User` while forgetting about the original user
- wrapped into `Ibexa\Core\MVC\Symfony\Security\UserWrapped` with the original user if needed

Finally, this user is assigned back into the event's token for the rest of the request.

### User mapping example

The following example uses the [memory user provider]([[= symfony_doc =]]/security/user_providers.html#memory-user-provider),
maps memory user to Ibexa repository user,
and [chains]([[= symfony_doc =]]/security/user_providers.html#chain-user-provider) with the Ibexa user provider to be able to use both:

Create as `src/EventSubscriber/InteractiveLoginSubscriber.php` subscribing to the `SecurityEvents::INTERACTIVE_LOGIN` event
and mapping when needed an in-memory authenticated user to an Ibexa user:

``` php
[[= include_file('code_samples/user_management/in_memory/src/EventSubscriber/InteractiveLoginSubscriber.php') =]]
```

In `config/packages/security.yaml`,
add the `memory` and `chain` user providers,
store some in-memory users with their passwords in plain text and a basic role,
set a `plaintext` password encoder for the `memory` provider's `InMemoryUser`,
and configure the firewall to use the `chain` provider:

``` yaml hl_lines="4 9-14 18-20 26"
[[= include_file('code_samples/user_management/in_memory/config/packages/security.yaml') =]]
```

In the `config/services.yaml` file, declare the subscriber as a service to pass your user map
(it's automatically tagged `kernel.event_subscriber` as implementing the `EventSubscriberInterface`, the config resolver and user service injections are auto-wired):

``` yaml
[[= include_file('code_samples/user_management/in_memory/config/services.yaml') =]]
```

From the back office, create the mapped users.
For the example, a new user with the login `generic_customer` and a random password for the mapping to work,
this account can be in the **Customers** or the **Anonymous users** group.

You can now log in with a in-memory user.
In the Symfony debug toolbar, you should see the in-memory user as this example uses `UserWrapped`.
