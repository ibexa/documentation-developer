---
description: OAuth2 allows you to securely connect to external services, among others enabling login via external services.
---

# OAuth authentication

You can use OAuth2 authentication to securely connect to external services.

[[= product_name =]] uses an integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle)
to provide OAuth2 authentication.

To enable OAuth2, you need to:

- [enable and configure an OAuth2 provider](#oauth2-provider-configuration)
- [add a guard authentication to your firewall configuration](#firewall-configuration)
- [select one of the existing resource owner mappers, or implement your own one](#resource-owner-mappers)

## OAuth2 provider configuration

To configure the OAuth2 provider, add it under the `oauth2` key in SiteAccess-aware configuration, for example:

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/packages/oauth.yaml') =]]
```

Details of the configuration depend on the OAuth2 provider that you want to use.
For sample configurations for different providers,
see [`knpuniversity/oauth2-client-bundle` configuration](https://github.com/knpuniversity/oauth2-client-bundle#configuration).

## Firewall configuration

Firewall configuration is located in `config/packages/security.yaml` under `security.firewalls`.
The `guard.authenticators` setting specifies the [Guard authenticators]([[= symfony_doc =]]/security/guard_authentication.html) to use.

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/packages/security.yaml', 20, 36) =]]
```

## Resource owner mappers

Resource owner mappers map the data received from the OAuth2 provider to user information in the Repository.

Resource owner mappers must implement the `Ibexa\Contracts\OAuth2Client\ResourceOwner\ResourceOwnerMapper` interface.
There are four existing implementations of `ResourceOwnerMapper`:

- `ResourceOwnerToExistingUserMapper` is the base class that is extended by the following mappers:
    - `ResourceOwnerIdToUserMapper` does not create a new user, but loads a user (resource owner) based on their identifier.
    - `ResourceOwnerEmailToUserMapper` does not create a new user, but loads a user (resource owner) based on their email.
- `ResourceOwnerToExistingOrNewUserMapper` checks if the user exists and loads them if they do.
If they do not, the mapper creates a new user in the Repository.

To use `ResourceOwnerToExistingOrNewUserMapper` you need to extend it in your custom mapper.

See [Adding login through external service](add_login_through_external_service.md) for an example of creating a mapper
that extends `ResourceOwnerToExistingOrNewUserMapper`.

!!! tip "OAuth User Content Type"

    When you implement your own mapper for external login,
    it is good practice to create a special User Content Type for users registered in this way.
    
    This is because users who register through an external service do not have a separate password in the system.
    Instead, they log in by their external service's password.
    
    To avoid issues with password restrictions in the built-in User Content Type,
    create a special Content Type (for example, "OAuth User"), without restrictions on the password.
    
    This new Content Type must also contain the User (`ezuser`) Field.
