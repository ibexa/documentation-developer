!!! caution "Temporary need of Composer `conflict`"

    To go through this update, [map the conflicting packages](https://getcomposer.org/doc/04-schema.md#conflict) in your `composer.json` file as following:
    ```json
    "conflict": {
        "jms/serializer": ">=3.30.0",
        "gedmo/doctrine-extensions": ">=3.12.0"
    },
    ```
    These entries can be removed after fully upgrading to v4.6 LTS.
