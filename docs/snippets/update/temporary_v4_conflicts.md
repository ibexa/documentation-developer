!!! caution "Temporary Composer conflicts needed"

    To go through this update add the following conflicts in your `composer.json` file:
    ```json
    "conflict": {
        "jms/serializer": ">=3.30.0",
        "gedmo/doctrine-extensions": ">=3.12.0"
    },
    ```
    These entries can be removed after fully upgrading to v4.6 LTS.
