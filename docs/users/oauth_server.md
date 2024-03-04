---
description: Other applications can authenticate Ibexa DXP users through OAuth2 protocol then access to their resources on the platform.
---

# OAuth Server

Your Ibexa DXP can be used as an OAuth2 server (combining an Authorization Server and a Resource Server).
Client applications (such as mobile apps) are able to authenticate a user then access to this user's resources.

![OAuth2 Server](img/oauth2-server.png)

## Server installation

[[= product_name =]] Oauth2 server package is `ibexa/oauth2-server` and is not part of the default installation.
It can be installed with the following command:

```bash
composer require ibexa/oauth2-server --with-all-dependencies
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
    mysql -u <username> -p <password> <database_name> -e 'SET FOREIGN_KEY_CHECKS=0;'
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/oauth2-server/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    mysql -u <username> -p <password> <database_name> -e 'SET FOREIGN_KEY_CHECKS=1;'
    ```

=== "PostgreSQL"

    php bin/console ibexa:doctrine:schema:dump-sql --force-platform=postgres vendor/ibexa/oauth2-server/src/bundle/Resources/config/schema.yaml | psql <database_name>

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

## Client

### Add a client

You need the client redirect URIs to create it.
You also need to agree on an identifier and a secret with the client.
There is only one `default` scope.

TODO: [scope](https://oauth.net/2/scope/)

Use `league:oauth2-server:create-client` command to create a client.
For example:

```bash
php bin/console league:oauth2-server:create-client 'Example OAuth2 Client' example-oauth2-client 9876543210987654321098765432109876543210 --scope=default \
  --redirect-uri=https://example.com/oauth2-callback
```

`--redirect-uri` can be used multiple time.

Redirect URIs can be added after the creation with `league:oauth2-server:update-client` command.
For example:

```bash
php bin/console league:oauth2-server:update-client example-oauth2-client \
  --add-redirect-uri=https://example.com/another-oauth2-callback
```

There is also commands to list all the configured clients (`league:oauth2-server:list-clients`),
or to delete a client (`league:oauth2-server:delete-client`).

- In a terminal, see `bin/console list league:oauth2-server` for a list of all the commands to maintain your clients.
  Use `bin/console help <command>` to usage detail for each of them. 
- See [package's online documentation](https://github.com/thephpleague/oauth2-server-bundle/blob/master/docs/basic-setup.md).

!!! note

    The `ìdentifier` and the `secret` will be needed by the client settings.

### Information needed by the client

Your OAuth2 client will need the following information to be able to use your Oauth server:

- The URL of the Ibexa DXP used as an oauth server TODO: Is it always a domain root?
- The client identifier
- The client secret
- The scope (`default`)

TODO: For example, if the client is another Ibexa DXP: like oauth_authentication.md but with an Ibexa DXP as the server. What about resource owner and server?

TODO: something about https://doc.ibexa.co/en/latest/users/oauth_authentication/
TODO: and https://doc.ibexa.co/en/latest/users/add_login_through_external_service/#configure-oauth2-client