# Sessions

Sessions are handled by the Symfony framework, specifically API and underlying session handlers provided by the HttpFoundation component.
It is further enhanced in eZ Platform with support for SiteAccess-aware session cookie configuration.

!!! note

    Use of Memcached (or experimentally PDO) as session handler is a requirement in a cluster setup,
    for details [see below](#cluster-setup). For an overview of the clustering feature see [Clustering](clustering.md).

## Configuration

Symfony offers the possibility to change many session options at application level
(i.e. in Symfony [`framework` configuration](http://symfony.com/doc/master/reference/configuration/framework.html)).
These options include:

- `cookie_domain`
- `cookie_path`
- `cookie_lifetime`
- `cookie_secure`
- `cookie_httponly`

However, in eZ Platform you can set up several sites within one Symfony application,
so you can also define session configuration per SiteAccess and SiteAccess group level.

### Session options per SiteAccess

All site-related session configuration can be defined per SiteAccess and SiteAccess group (in `ezplatform.yml`):

``` yaml
ezpublish:
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

In Symfony, a session handler is configured using `framework.session.handler_id`.
Symfony can be configured to use custom handlers, or just fall back to what is configured in PHP by setting it to null (`~`).

### Default configuration

eZ Platform uses the same default configuration as recent versions of Symfony standard distribution.
This makes sure you can configure sessions purely in PHP by default, and allows Debian/Ubuntu session file cleanup cronjob to work as intended.

``` yaml
# Default config.yml session configuration
framework:
    session:
        # handler_id set to null will use default session handler from php.ini
        handler_id:  ~
```

### Recommendations for production setup

#### Single-server setup

For a single server, the default handler is preferred.

#### Cluster setup

For a [cluster](clustering.md) setup you need to configure sessions to use a back end that is shared between web servers and supports locking.
The only options out of the box supporting this in Symfony are the native PHP Memcached session save handler
provided by the `php-memcached` extension, and Symfony session handler for PDO (database).

##### Storing sessions in Memcached using `php-memcached`

To set up eZ Platform using Memcached you need to [configure the session save handler settings in `php.ini`](http://php.net/manual/en/memcached.sessions.php),
and optionally tweak [`php-memcached` session settings](http://fr2.php.net/manual/en/memcached.configuration.php).

##### Storing sessions in Redis using pecl package

To set up eZ Platform using the [Redis pecl package](https://pecl.php.net/package/redis)
you need to [configure the session save handler settings in `php.ini`](https://github.com/phpredis/phpredis#php-session-handler).

##### Alternative storing sessions in database using PDO

For setups where database is preferred for storing sessions, you may use Symfony's PdoSessionHandler,
although it is not currently recommended from performance perspective.

Below is a configuration example for eZ Platform. Refer to the [Symfony Cookbook](http://symfony.com/doc/current/cookbook/configuration/pdo_session_storage.html) for full documentation.

``` yaml
framework:
    session:
        # ...
        handler_id: session.handler.pdo

parameters:
    pdo.db_options:
        db_table:    session
        db_id_col:   session_id
        db_data_col: session_value
        db_time_col: session_time

services:
    pdo:
        class: PDO
        arguments:
            dsn:      "mysql:dbname=<mysql_database>"
            user:     <mysql_user>
            password: <mysql_password>

    session.handler.pdo:
        class:     Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler
        arguments: ["@pdo", "%pdo.db_options%"]
```
