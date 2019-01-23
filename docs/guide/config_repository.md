# Content Repository configuration

The default storage engine for the Repository is called Legacy storage engine.

You can define several Repositories within a single application. However, you can only use one per site.

### Configuration examples

#### Using default values

``` yaml
# ezplatform.yml
ezpublish:
    repositories:
        # Defining Repository with alias "main"
        # Default storage engine is used, with default connection
        # Equals to:
        # main: { storage: { engine: legacy, connection: <defaultConnectionName> } }
        main: ~

    system:
        # All members of my_siteaccess_group will use "main" Repository
        # No need to set "repository", it will take the first defined Repository by default
        my_siteaccess_group:
            # ...
```

If no Repository is specified for a SiteAccess or SiteAccess group, the first Repository defined under `ezpublish.repositories` will be used.

#### All explicit

``` yaml
# ezplatform.yml
doctrine:
    dbal:
        default_connection: my_connection_name
        connections:
            my_connection_name:
                driver:   pdo_mysql
                host:     localhost
                port:     3306
                dbname:   my_database
                user:     my_user
                password: my_password
                charset:  UTF8MB4

            another_connection_name:
                # ...

ezpublish:
    repositories:
        first_repository: { storage: { engine: legacy, connection: my_connection_name, config: {} } }
        second_repository: { storage: { engine: legacy, connection: another_connection_name, config: {} } }

    # ...

    system:
        my_first_siteaccess:
            repository: first_repository

            # ...

        my_second_siteaccess:
            repository: second_repository
```

#### Legacy storage engine

Legacy storage engine uses [Doctrine DBAL](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/) (Database Abstraction Layer). Database settings are supplied by [DoctrineBundle](https://github.com/doctrine/DoctrineBundle). As such, you can refer to [DoctrineBundle's documentation](https://github.com/doctrine/DoctrineBundle/blob/master/Resources/doc/configuration.rst#doctrine-dbal-configuration).

### Field groups configuration

Field groups, used in content and Content Type editing, can be configured from the `repositories` section. Values entered there are field group *identifiers*:

``` yaml
repositories:
    default:
        fields_groups:
            list: [content, features, metadata]
            default: content
```

These identifiers can be given human-readable values and translated. Those values are used when editing Content Types. The translation domain is `ezplatform_fields_groups`.
This file will define English names for field groups:

``` yaml
# app/Resources/translations/ezplatform_fields_groups.en.yml
content: Content
metadata: Metadata
user_data: User data
```

### Limit of archived Content item versions

`default_version_archive_limit` controls the number of archived versions per Content item that will be stored in the Repository, by default set to 5. This setting is configured in the following way (typically in `ezplatform.yml`):

``` yaml
ezpublish:
    repositories:
        default:
            options:
                default_version_archive_limit: 10
```

This limit is enforced on publishing a new version and only covers archived versions, not drafts.

!!! tip

    Don't set `default_version_archive_limit` too high, with Legacy storage engine you'll get performance degradation if you store too many versions. Default value of 5 is in general the recommended value, but the less content you have overall, the more you can increase this to, for instance, 25 or even 50.

#### Removing old versions

You can use the `ezplatform:content:cleanup-versions` command to remove old content versions.

The command takes the following optional parameters:

- `status` or `t` - status of versions to remove: `draft`, `archived` or `all`
- `keep` or `k` - number of versions to keep
- `user` or `u` - the User that the command will be performed as. The User must have the `content/remove`, `content/read` and `content/versionread` Policies. By default the `administrator` user is applied.

`ezplatform:content:cleanup-versions --status <status name> --keep <number of versions> --user <user name>`

For example, the following command removes archived versions as user `admin`, but leaves the 5 most recent versions:

`ezplatform:content:cleanup-versions --status archived --keep 5 --user administrator`

### User identifiers

`ezplatform_default_settings.yml` contains two settings that indicate which Content Types are treated like users and user groups:

``` yaml
# User identifier
ezsettings.default.user_content_type_identifier: ['user']

# User Group identifier
ezsettings.default.user_group_content_type_identifier: ['user_group']
```

You can override these settings if you have other Content Types that should be treated as users/user groups in the Back Office.
When viewing such Content in the Back Office you will be able to see e.g. the assigned Policies.
