---
description: Ibexa DXP uses Symfony to handle user sessions, with support for SiteAccess-aware session cookie configuration.
---

# Sessions

Sessions are handled by the Symfony framework, specifically API and underlying session handlers provided by the HttpFoundation component.
It's further enhanced in [[= product_name =]] with support for SiteAccess-aware session cookie configuration.

!!! note

    Use of Memcached, Redis (or experimentally PDO) as session handler is a requirement in a cluster setup, for details [see below](#cluster-setup). For an overview of the clustering feature see [Clustering](clustering.md).

## Configuration

Symfony offers the possibility to change many session options at application level (for example, in Symfony [`framework` configuration]([[= symfony_doc =]]/reference/configuration/framework.html#session)).
These options include:

- `cookie_domain`
- `cookie_path`
- `cookie_lifetime`
- `cookie_secure`
- `cookie_httponly`

However, in [[= product_name =]] you can set up several sites within one Symfony application, so you can also define session configuration per SiteAccess and SiteAccess group level.

### Session options per SiteAccess

All site-related session configuration can be defined per SiteAccess and SiteAccess group under the `ibexa.system.<scope>.session` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        my_siteaccess:
            session:
                # Default session name is eZSESSID{siteaccess_hash}
                # (unique session name per SiteAccess)
                name: my_session_name
                # These are optional. 
                # If not defined they will fall back to Symfony framework configuration, 
                # which itself falls back to default php.ini settings
                cookie_domain: mydomain.com
                cookie_path: /foo
                cookie_lifetime: 86400
                cookie_secure: false
                cookie_httponly: true
```

## Session handlers

In Symfony, a session handler is configured with `framework.session.handler_id`.
Symfony can be configured to use custom handlers, or fall back to what is configured in PHP by setting it to null (`~`).

### Default configuration

[[= product_name =]] adapts Symfony's defaults to make sure its session save path is always taken into account:

``` yaml
# Default session configuration
framework:
    session:
        # handler_id can be set to null (~) like default in Symfony, if it so will use default session handler from php.ini
        # But in order to use %ibexa.session.save_path%, default Ibexa DXP instead sets %ibexa.session.handler_id% to:
        # - session.handler.native_file (default)
        # - Ibexa\Bundle\Core\Session\Handler\NativeSessionHandler (recommended value for Cluster usage, using php-redis session handler )
        handler_id: '%ibexa.session.handler_id%'
```

### Recommendations for production setup

#### Single-server setup

For a single server, the default file handler is preferred.

#### Cluster setup

See [shared sessions in the clustering guide](clustering.md#shared-sessions).

##### Handling sessions with Memcached

To set up [[= product_name =]] using [Memcached](https://pecl.php.net/package/memcached) you need to:

- [Configure the session save handler settings in `php.ini`](https://www.php.net/manual/en/memcached.sessions.php)
- Set `%ibexa.session.handler_id%` to `~` (null) in `config/packages/ibexa.yaml`

Alternatively if you need to configure Memcached servers dynamically:

- Create a Symfony service like this:

```yaml
    app.session.handler.native_memcached:
        class: Ibexa\Bundle\Core\Session\Handler\NativeSessionHandler
        arguments:
         - '%session.save_path%'
         - memcached
```

- Set `%ibexa.session.handler_id%` (or `SESSION_HANDLER_ID` env var) to `app.session.handler.native_memcached`
- Set `%ibexa.session.save_path%` (or `SESSION_SAVE_PATH` env var) to [`save_path` config for Memcached](https://www.php.net/manual/en/memcached.sessions.php)

Optionally tweak [`php-memcached` session settings](https://www.php.net/manual/en/memcached.configuration.php) for things like session locking.

##### Handling sessions with Redis

To set up [[= product_name =]] using the [Redis](https://pecl.php.net/package/redis) you need to:

- [Configure the session save handler settings in `php.ini`](https://github.com/phpredis/phpredis/#php-session-handler)
- Set `%ibexa.session.handler_id%` to `~` _(null)_ in `config/packages/ibexa.yaml`

Alternatively if you have needs to configure Redis servers dynamically:

- Set `%ibexa.session.handler_id%` (or `SESSION_HANDLER_ID` env var) to `Ibexa\Bundle\Core\Session\Handler\NativeSessionHandler`
- Set `%ibexa.session.save_path%` (or `SESSION_SAVE_PATH` env var) to [save_path config for Redis](https://github.com/phpredis/phpredis/#php-session-handler)

!!! note "[[= product_name_cloud =]]"

    For [[= product_name_cloud =]] (and Platform.sh), this is already configured in `config/env/platformsh.php` based on `.platform.yaml` config.

If you're on `php-redis` v4.2.0 and higher, you can optionally tweak [`php-redis` settings](https://github.com/phpredis/phpredis#session-locking) for session locking.

Ideally keep [persistence cache](persistence_cache.md) and session data separated:

- Sessions can't risk getting [randomly evicted](https://redis.io/docs/latest/develop/reference/eviction/#eviction-policies) when you run out of memory for cache.
- You can't completely disable eviction either, as Redis then starts to refuse new entries once full, including new sessions.
    - Either way, you should monitor your Redis instances and make sure you have enough memory set aside for active sessions/cache items.

If you want to make sure sessions survive Redis or server restarts, consider using a [persistent Redis](https://redis.io/docs/latest/operate/oss_and_stack/management/persistence/) instance for sessions.

##### Alternative storing sessions in database by using PDO

For setups where database is preferred for storing sessions, you may use Symfony's PdoSessionHandler, although it's not currently recommended from performance perspective.

Below is a configuration example for [[= product_name =]]. Refer to the [Symfony Cookbook]([[= symfony_doc =]]/session.html#session-database-pdo) for full documentation.

``` yaml
framework:
    session:
        # ...
        handler_id: session.handler.pdo

parameters:
    pdo.db_options:
        db_table: session
        db_id_col: session_id
        db_data_col: session_value
        db_time_col: session_time

services:
    PDO:
        arguments:
            dsn: 'mysql:dbname=<mysql_database>'
            user: <mysql_user>
            password: <mysql_password>

    Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler:
        arguments: ['@pdo', '%pdo.db_options%']
```
