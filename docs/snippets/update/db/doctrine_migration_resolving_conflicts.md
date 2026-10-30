!!! note "Resolving conflicts with customizations"

    If a migration fails because you already modified the affected table yourself, for example, as part of a customization, check the error, compare with the SQL file generated during the dry run, and resolve the issue.
    Then, try running `ibexa:doctrine:migrations:migrate` again.
    Most migrations check the current state of the schema and record themselves as executed when it matches, without making any changes.

    If the migration still fails, check what it does, and make sure your schema reflects the same end result.
    Then, mark that migration as executed without actually running it.

    ```bash
    php bin/console ibexa:doctrine:migrations:version --add 'Ibexa\Bundle\Taxonomy\Migration\AddTaxonomyEntriesRootIndexesMigration'
    ```
