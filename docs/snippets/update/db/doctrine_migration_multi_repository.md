If your project uses [multiple repositories](repository_configuration.md#defining-custom-connection) with separate databases, run the command once for each repository, using the `--siteaccess` option with any SiteAccess that belongs to that repository:

```bash
php bin/console ibexa:doctrine:migrations:migrate --siteaccess=<siteaccess_of_that_repository>
```

Running the command more than once is safe.
It has no effect if you apply it to a SiteAccess whose repository has already been migrated.
