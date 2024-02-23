---
description: Other applications can authenticate users through Ibexa DXP user repository thanks to OAuth 2 protocol.
---

# OAuth Server

Your Ibexa DXP can be used as an OAuth 2 server which other applications can use to authenticate users.
So, users connect to several applications using the same credentials.

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

## Server configuration

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

### Service, routes and security configuration

Uncomment whole service configuration file `config/packages/ibexa_oauth2_server.yaml`.
Tweak the values if you like.

Uncomment whole routes configuration file `config/routes/ibexa_oauth2_server.yaml`

Uncomment the two following lines from `config/packages/security.yaml`:

```yaml
    ## Uncomment authorize access control if you wish to use product as an OAuth2 Server
    access_control:
        - { path: ^/authorize/jwks$, roles: ~ }
        - { path: ^/authorize, roles: IS_AUTHENTICATED_REMEMBERED }
```

## Client

### Add a client

TODO: https://github.com/thephpleague/oauth2-server-bundle/blob/master/docs/basic-setup.md

### Information needed by the client

Your OAuth client will need the following information to be able to use your Oauth server:

TODO

TODO: For example, if the client is another Ibexa DXP: like oauth_authentication.md but with an Ibexa DXP as the server. What about resource owner and server?
