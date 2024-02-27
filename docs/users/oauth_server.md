---
description: Other applications can authenticate users through Ibexa DXP user repository thanks to OAuth 2 protocol.
---

# OAuth Server

Your Ibexa DXP can be used as an OAuth 2 server (combining an Authorization Server and a Resource Server).
Client applications (such as mobile apps) are able to authenticate a user then access to this user's resources.

TODO: https://www.oauth.com/oauth2-servers/definitions/

## Server installation

Ibexa DXP Oauth Server package is `ibexa/oauth2-server` and is not part of the default installation.
It can be installed with the following command:

```bash
composer require ibexa/oauth2-server
```

Then, add the following pair of bundle lines to `config/bundles.php` array, like at the end of it:

```php
<?php

return [
    // A lot of bundles…
    Ibexa\Bundle\OAuth2Server\IbexaOAuth2ServerBundle::class => ['all' => true],
    League\Bundle\OAuth2ServerBundle\LeagueOAuth2ServerBundle::class => ['all' => true],
];
```

Add the tables needed by the bundle:

=== "MySQL"

    TODO: add user, password, and db name to the command

    ```bash
    mysql -e 'SET FOREIGN_KEY_CHECKS=0;'
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/oauth2-server/src/bundle/Resources/config/schema.yaml | mysql
    mysql -e 'SET FOREIGN_KEY_CHECKS=1;'
    ```

=== "PostgreSQL"

    TODO

## Authorization Server configuration

### Keys

You need private and public keys.
You can look at https://oauth2.thephpleague.com/installation/#generating-public-and-private-keys

TODO: security reco about using a passphrase or not?

You also need an encryption key
You can look at https://oauth2.thephpleague.com/installation/#generating-encryption-keys


Set the following environment variables:

```
OAUTH2_PUBLIC_KEY_PATH=/somewhere/safe/key.public
OAUTH2_PRIVATE_KEY_PATH=/somewhere/safe/key.private
OAUTH2_PRIVATE_KEY_PASSPHRASE=some_passphrase_or_empty
OAUTH2_ENCRYPTION_KEY=1234567890123456789012345678901234567890
```

### Service, routes, and security configurations

Uncomment whole service configuration file `config/packages/ibexa_oauth2_server.yaml`.
Tweak the values if you like.

Uncomment whole routes configuration file `config/routes/ibexa_oauth2_server.yaml`

Uncomment the three following lines about `access_control` from `config/packages/security.yaml`:

```yaml
security:
    #…

    # Uncomment authorize access control if you wish to use product as an OAuth2 Server
    access_control:
        - { path: ^/authorize/jwks$, roles: ~ }
        - { path: ^/authorize, roles: IS_AUTHENTICATED_REMEMBERED }
```

Uncomment the three following lines about `oauth2_token` from `config/packages/security.yaml`:

```yaml
security:
    #…
    firewall:
        #…

        # Uncomment oauth2_token firewall if you wish to use product as an OAuth2 Server.
        # Use oauth2 guard any other (for example ibexa_front) firewall you wish to be
        # exposed as OAuth2-available resource. Example:
        #    guard:
        #        authenticators:
        #            - Ibexa\OAuth2Server\Security\Guard\OAuth2Authenticator
        oauth2_token:
            pattern: ^/token$
            security: false
```

## Resource Server configuration

To allow resource routes to be accessible through OAuth authorization,
you must define a firewall using the `Ibexa\OAuth2Server\Security\Guard\OAuth2Authenticator`.

The following firewall example allows the REST API to be accessed as an OAuth resource.
TODO: Location in the file? Before `main`? Before `ibexa_front`? Upper?

```yaml
    #…
    firewall:
        #…

        ibexa_rest_oauth:
            pattern: ^/api/ibexa/v2
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            anonymous: ~
            guard:
                authenticators:
                    - Ibexa\OAuth2Server\Security\Guard\OAuth2Authenticator
                entry_point: Ibexa\OAuth2Server\Security\Guard\OAuth2Authenticator
            stateless: true
```

TODO: Can it break same-domain Back Office like with [HTTP basic authentication](rest_api_authentication.md#configuration)?

In the `security.yaml`'s comments, you can find instructions to make the whole installation accessible through OAuth
by uncommenting `ibexa_oauth2_front`, and commenting `ibexa_front`.

## Client

### Add a client

TODO: https://github.com/thephpleague/oauth2-server-bundle/blob/master/docs/basic-setup.md

### Information needed by the client

Your OAuth client will need the following information to be able to use your Oauth server:

TODO

TODO: For example, if the client is another Ibexa DXP: like oauth_authentication.md but with an Ibexa DXP as the server. What about resource owner and server?
