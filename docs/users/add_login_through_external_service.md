---
description: Allow users to log in to Ibexa DXP through external services by using OAuth2.
---

# Add login through external service

To add an option to log in to the system through an external service, you can use [OAuth2](oauth_authentication.md) to authorize your users.

The example below shows how to add a **Log in with Google** option to the Back Office.

## Configure OAuth2 client

Configure the OAuth2 client in `config/packages/knpu_oauth2_client.yaml`:

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/packages/knpu_oauth2_client.yaml') =]]
```

## Enable OAuth authentication

Enable OAuth2 authentication through Google for the `site` SiteAccess:

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/packages/oauth.yaml') =]]
```

## Configure firewall

Add the `Ibexa\Bundle\OAuth2Client\Security\Authenticator\OAuth2Authenticator` guard authenticator
to your firewall configuration in `config/packages/security.yaml`
and ensure that the `ibexa.oauth2.connect` route is accessible by an anonymous user:

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/packages/security.yaml', 20, 36) =]]
```

## Implement a resource owner mapper

Create a resource owner mapper for Google login in `src/OAuth/GoogleResourceOwnerMapper.php`.
The mapper extends [`ResourceOwnerToExistingOrNewUserMapper`](oauth_authentication.md#resource-owner-mappers),
which enables it to create a new user in the Repository if the user does not exist yet.

The mapper loads a user (line 50) or creates a new one (line 60),
based on the information from `resourceOwner`, that is the OAuth provider.

The new user name is set with a `google:` prefix (lines 18, 105), to avoid conflicts with users registered in a regular way.

``` php hl_lines="18 50 60 105"
[[= include_file('code_samples/user_management/oauth_google/src/OAuth/GoogleResourceOwnerMapper.php') =]]
```

Configure the service by using the `ibexa.oauth2_client.resource_owner_mapper` tag:

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/services.yaml', 33, 36) =]]
```

## Add template

To add a **Log in with Google** button to your Back Office login form, create the following template file
in `templates/themes/admin/account/login/oauth2_login.html.twig`:

``` html+twig
[[= include_file('code_samples/user_management/oauth_google/templates/themes/admin/account/login/oauth2_login.html.twig') =]]
```

Finally, add the template to the login form by using the `login-form-after` [component](custom_components.md):

``` yaml
[[= include_file('code_samples/user_management/oauth_google/config/services.yaml', 37, 43) =]]
```

![Log in to the Back Office with Google](log_in_via_google.png)
