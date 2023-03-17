!!! caution "Clear the persistence cache"

    Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the Page blocks, block attributes, validators or views configuration.

    To clear the persistence cache run `./bin/console cache:pool:clear [cache-pool]` command.
    The default cache-pool is named `cache.tagaware.filesystem`. The default cache-pool when running redis is `cache.redis`. If you have customized the [persistence cache configuration](../../infrastructure_and_maintenance/cache/persistence_cache#what-is-cached), the name of your cache pool might be different.

    In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`.
    In dev mode, the Symfony cache will be rebuilt automatically.