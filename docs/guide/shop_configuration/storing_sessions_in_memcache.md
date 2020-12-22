# Storing sessions in Memcache [[% include 'snippets/commerce_badge.md' %]]

You can configure storing sessions in Memcache, preferably using stash.
This way you don't mix session stash cache with other stash caches, such as SPI, translation, and navigation.

You can also configure a cache server for the failover session.

## Step 1. Configure Memcache servers

Add a new stash service to stash configuration in `ezpublish_env.yml`:

``` yaml
session:
    drivers: [ Memcache ]
    inMemory: true
    registerDoctrineAdapter: false
    registerSessionHandler: true
    Memcache:
        prefix_key: harmony_
        retry_timeout: 1
        servers:
            -
                server: 127.0.0.1
                port: 11211
            -
                server: 127.0.0.1
                port: 11212
```

## Step 2. Configure session handler

Configure the session handler in `config_env.yml`:

``` yaml
session:
    handler_id: stash.adapter.session.session_cache
```
