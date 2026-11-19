!!! tip "Apply migrations one by one"

    Instead of applying all pending migrations at once, you can go through them one at a time.
    To preview only the next pending migration, run:

    ```bash
    php bin/console ibexa:doctrine:migrations:migrate next --dry-run
    ```

    Then, to apply it, run the same command without the `--dry-run` option:

    ```bash
    php bin/console ibexa:doctrine:migrations:migrate next
    ```

    Repeat these steps until no pending migrations remain.
    To check which migrations are still pending, run `php bin/console ibexa:doctrine:migrations:status`.
