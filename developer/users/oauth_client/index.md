# OAuth client

Allow users to log into Ibexa DXP through external OAuth2 authorization servers.

You can use OAuth2 to securely authenticate users with external Authorization Servers.

![OAuth2 Client](https://doc.ibexa.co/en/5.0/users/img/oauth2-client.png)

Ibexa DXP uses an integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle) to provide OAuth2 authentication.

## Configure OAuth2 client

### Configure connection to Authorization Server

Details of the configuration depend on the OAuth2 Authorization Server that you want to use. For sample configurations for different providers, see [`knpuniversity/oauth2-client-bundle` configuration](https://github.com/knpuniversity/oauth2-client-bundle#configuration). Some client types require additional packages. Missing package is indicated in an error message.

For example, the following configuration creates a `google` client for Google OAuth2 Authorization Server to log users in. Two environment variables, `OAUTH_GOOGLE_CLIENT_ID` and `OAUTH_GOOGLE_CLIENT_SECRET`, correspond to [the set-up on Google side](https://support.google.com/cloud/answer/15549257).

```yaml
knpu_oauth2_client:
    clients:
        # Configure your clients as described here: https://github.com/knpuniversity/oauth2-client-bundle#configuration
        google:
            type: google
            client_id: '%env(OAUTH_GOOGLE_CLIENT_ID)%'
            client_secret: '%env(OAUTH_GOOGLE_CLIENT_SECRET)%'
            redirect_route: ibexa.oauth2.check
            redirect_params:
                identifier: google
```

To use the `google` client type, you need to install the following package:

```bash
composer require league/oauth2-google
```

### Enable OAuth2 client

The client needs to be a part of the [SiteAccess scope](../../multisite/multisite_configuration/index.md#scope).

In the following example, the OAuth2 client `google` is enabled for the `admin` SiteAccess:

```yaml
ibexa:
    system:
        admin:
            oauth2:
                enabled: true
                clients: ['google']
```

## Configure firewall

In `config/packages/security.yaml`, enable the `ibexa_oauth2_connect` firewall and replace the `ibexa_front` firewall with the `ibexa_oauth2_front` one.

```yaml
security:
    #…

    firewalls:
        #…

        # Uncomment ibexa_oauth2_connect, ibexa_oauth2_front rules and comment ibexa_front firewall
        # to enable OAuth2 authentication

        ibexa_oauth2_connect:
            pattern: /oauth2/connect/*
            security: false

        ibexa_oauth2_front:
            pattern: ^/
            provider: ibexa
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            custom_authenticators:
              - Ibexa\Bundle\OAuth2Client\Security\Authenticator\OAuth2Authenticator
              - Ibexa\PageBuilder\Security\EditorialMode\FragmentAuthenticator
            entry_point: Ibexa\Bundle\OAuth2Client\Security\Authenticator\OAuth2Authenticator
            context: ibexa
            form_login:
                enable_csrf: true
            logout: ~

        # ibexa_front:
        #     pattern: ^/
        #     provider: ibexa
        #     user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
        #     context: ibexa
        #     form_login:
        #         enable_csrf: true
        #         login_path: login
        #         check_path: login_check
        #     custom_authenticators:
        #         - Ibexa\PageBuilder\Security\EditorialMode\FragmentAuthenticator
        #     entry_point: form_login
        #     logout:
        #         path: logout
```

The `custom_authenticators` setting specifies the [custom authenticators](https://symfony.com/doc/7.4/security/custom_authenticator.html) to be used.

By adding the `Ibexa\Bundle\OAuth2Client\Security\Authenticator\OAuth2Authenticator` authenticator you add a possibility to use OAuth2 on those routes.

## Resource owner mappers

Resource owner mappers map the data received from the OAuth2 authorization server to user information in the repository.

Resource owner mappers must implement the [`Ibexa\Contracts\OAuth2Client\ResourceOwner\ResourceOwnerMapper`](../../../../../ibexa/oauth2-client/src/contracts/ResourceOwner/ResourceOwnerMapper.php) interface.

Four implementations of `ResourceOwnerMapper` are proposed by default:

- `ResourceOwnerToExistingUserMapper` is the base class extended by the following mappers:
  - `ResourceOwnerIdToUserMapper` - loads a user (resource owner) based on the identifier, but doesn't create a new user.
  - `ResourceOwnerEmailToUserMapper` - loads a user (resource owner) based on the email, but doesn't create a new user.
- `ResourceOwnerToExistingOrNewUserMapper` - checks whether the user exists and loads the data if it does. If not, creates a new user in the repository.

To use `ResourceOwnerToExistingOrNewUserMapper`, you need to extend it in your custom mapper.

> **Tip: OAuth user content type**
>
> When you implement your own mapper for external login, it's good practice to create a special user content type for users registered in this way. The users who register through an external service don't have a separate password in the system. Instead, they log in by their external service's password.
>
> To avoid issues with password restrictions in the built-in user content type, create a special content type (for example, "OAuth user"), without restrictions on the password.
>
> This new content type must also contain the user (`ibexa_user`) field.

The following example shows how to create a Resource Owner mapper for the `google` client from previous examples.

Create a resource owner mapper for Google login in `src/OAuth/GoogleResourceOwnerMapper.php`. The mapper extends `ResourceOwnerToExistingOrNewUserMapper`, which enables it to create a new user in the repository if the user doesn't exist yet.

The mapper loads a user (line 40) or creates a new one (line 49), based on the information from `resourceOwner`, that's the OAuth2 authorization server.

The new username is set with a `google:` prefix (lines 20, 91), to avoid conflicts with users registered in a regular way.

```php
<?php

declare(strict_types=1);

namespace App\OAuth;

use Ibexa\Contracts\Core\Repository\LanguageResolver;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\OAuth2Client\Repository\OAuth2UserService;
use Ibexa\OAuth2Client\ResourceOwner\ResourceOwnerToExistingOrNewUserMapper;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class GoogleResourceOwnerMapper extends ResourceOwnerToExistingOrNewUserMapper
{
    private const string PROVIDER_PREFIX = 'google:';

    public function __construct(
        Repository $repository,
        private readonly OAuth2UserService $oauthUserService,
        private readonly LanguageResolver $languageResolver,
        private readonly UserService $userService,
        private readonly ?string $contentTypeIdentifier = null,
        private readonly ?string $parentGroupRemoteId = null
    ) {
        parent::__construct($repository);
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function loadUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): UserInterface {
        return $userProvider->loadUserByIdentifier($this->getUsername($resourceOwner));
    }

    /**
     * @param \League\OAuth2\Client\Provider\GoogleUser $resourceOwner
     */
    protected function createUser(
        ResourceOwnerInterface $resourceOwner,
        UserProviderInterface $userProvider
    ): UserInterface {
        $userCreateStruct = $this->oauthUserService->newOAuth2UserCreateStruct(
            $this->getUsername($resourceOwner),
            $resourceOwner->getEmail(),
            $this->getMainLanguageCode(),
            $this->getOAuth2UserContentType($this->repository)
        );

        $userCreateStruct->setField('first_name', $resourceOwner->getFirstName());
        $userCreateStruct->setField('last_name', $resourceOwner->getLastName());

        $parentGroups = [];
        if ($this->parentGroupRemoteId !== null) {
            $parentGroups[] = $this->userService->loadUserGroupByRemoteId($this->parentGroupRemoteId);
        }

        $this->userService->createUser($userCreateStruct, $parentGroups);

        return $userProvider->loadUserByIdentifier($this->getUsername($resourceOwner));
    }

    private function getOAuth2UserContentType(Repository $repository): ?ContentType
    {
        if ($this->contentTypeIdentifier !== null) {
            $contentTypeService = $repository->getContentTypeService();

            return $contentTypeService->loadContentTypeByIdentifier(
                $this->contentTypeIdentifier
            );
        }

        return null;
    }

    private function getMainLanguageCode(): string
    {
        // Get first prioritized language for current scope
        return $this->languageResolver->getPrioritizedLanguages()[0];
    }

    private function getUsername(GoogleUser $resourceOwner): string
    {
        return self::PROVIDER_PREFIX . $resourceOwner->getId();
    }
}
```

Configure the service by using the `ibexa.oauth2_client.resource_owner_mapper` tag to associate it with the `google` client:

```yaml
services:
    #…

    App\OAuth\GoogleResourceOwnerMapper:
        tags:
            - { name: ibexa.oauth2_client.resource_owner_mapper, identifier: google }
```

## Add login button

After you have activated the OAuth2 client for the `admin` SiteAccess, you need to add a **Log in with Google** to the back office login form.

Create the following template file in `templates/themes/admin/account/login/oauth2_login.html.twig`:

```html+twig
<div class="row mt-4">
    <div class="col">
        <p class="text-center">or</p>
        <div class="btn-group d-flex">
            <a href="{{ ibexa_oauth2_connect_path('google') }}" class="btn btn-primary">
                Log in via Google
            </a>
        </div>
    </div>
</div>
```

For more information about the OAuth connection URL Twig functions, see [`ibexa_oauth2_connect_path`](../../templating/twig_function_reference/url_twig_functions/index.md#ibexa_oauth2_connect_path) and [`ibexa_oauth2_connect_url`](../../templating/twig_function_reference/url_twig_functions/index.md#ibexa_oauth2_connect_url).

Finally, add the template to the login form by using the `admin-ui-login-form-after` [Twig component group](../../templating/components/index.md):

```yaml
services:
    #…

    app.components.oauth2_login:
        parent: Ibexa\TwigComponents\Component\TemplateComponent
        arguments:
            $template: '@@ibexadesign/account/login/oauth2_login.html.twig'
        tags:
            - { name: ibexa.twig.component, group: admin-ui-login-form-after }
```

![Log in to the back office with Google](https://doc.ibexa.co/en/5.0/users/img/log_in_via_google.png)
