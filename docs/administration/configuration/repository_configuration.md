---
description: Configure Repository connections, archive limits, Field groups and other settings.
---

# Repository configuration

You can define several Repositories within a single application. However, you can only use one per site.

## Repository connection

### Using default values

To use the default Repository connection, you do not need to specify its details:

``` yaml
ibexa:
    repositories:
        # Defining Repository with alias "main"
        # Default storage engine is used, with default connection
        # Equals to:
        # main: { storage: { engine: legacy, connection: <defaultConnectionName> } }
        main: ~
```

!!! note "Legacy storage engine"

    Legacy storage engine is the default storage engine for the Repository.

    It uses [Doctrine DBAL](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/) (Database Abstraction Layer).
    Database settings are supplied by [DoctrineBundle](https://github.com/doctrine/DoctrineBundle).
    As such, you can refer to [DoctrineBundle's documentation](https://github.com/doctrine/DoctrineBundle/blob/master/Resources/doc/configuration.rst#doctrine-dbal-configuration).

If no Repository is specified for a SiteAccess or SiteAccess group,
the first Repository defined under `ibexa.repositories` will be used:

``` yaml
ibexa:
    repositories:
        main: ~
    system:
        # All members of site_group will use "main" Repository
        # No need to set "repository", it will take the first defined Repository by default
        site_group:
            # ...
```

#### Multisite URI matching with multi-Repository setup

You can use only one Repository (database) per domain.
This does not prohibit using [different Repositories](persistence_cache.md#multi-repository-setup) on different subdomains.
However, when using URI matching for multisite setup, all SiteAccesses sharing domain also need to share Repository.
For example:

- `ibexa.co` domain can use `ibexa_repo`
- `doc.ibexa.co` domain can use `doc_repo`

But the following configuration would be invalid:

- `ibexa.co` domain can use `ibexa_repo`
- `ibexa.co/doc` **cannot** use `doc_repo`, as it is under the same domain.

Invalid configuration causes problems for different parts of the system,
for example back-end UI, REST interface and other non-SiteAccess-aware Symfony routes
such as `/_fos_user_context_hash` used by [HTTP cache](http_cache.md).

### Entity manager

If you use the [Doctrine entity manager](https://www.doctrine-project.org/projects/doctrine-orm/en/2.10/tutorials/getting-started.html#obtaining-the-entitymanager),
you are unable to connect different SiteAccesses to different databases.

To have this possibility, you need to use the SiteAccess-aware entity manager: `ibexa.doctrine.orm.entity_manager`.

To inject your entities into the SiteAccess-aware entity manager, use the following configuration:

``` yaml
ibexa:
    orm:
        entity_mappings:
            IbexaCoreBundle:
                is_bundle: true
                type: annotation
                dir: Entity
                prefix: Ibexa\Bundle\Core\Entity
```

Refer to [DoctrineBundle documentation](https://symfony.com/doc/3.4/reference/configuration/doctrine.html)
for more information.

!!! note

    In contrast with DoctrineBundle, when using the SiteAccess-aware entity manager you need to explicitly set all options:
    `dir` (it still accepts relative path in case of bundles), `prefix`, `type`, and `is_bundle`.

### Defining custom connection

You can also explicitly define a custom Repository connection:

``` yaml
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

            my_second_connection_name:
                driver:   pdo_mysql
                url: '%env(resolve:SECOND_DATABASE_URL)%'
                charset:  UTF8MB4

            another_connection_name:
                # ...

ibexa:
    repositories:
        first_repository: 
            storage: 
                engine: legacy
                connection: my_connection_name
                config: {}
            # Configuring search is required when using Legacy search engine
            search:
                connection: my_connection_name
        second_repository:
            storage:
                engine: legacy
                connection: my_second_connection_name
                config: {}
            search:
                connection: my_second_connection_name
        another_repository:
            storage: 
                engine: legacy
                connection: another_connection_name
                config: {}
            search:
                connection: another_connection_name

    # ...

    system:
        my_first_siteaccess:
            repository: first_repository

        my_second_siteaccess:
            repository: second_repository
```

```
# .env.local

SECOND_DATABASE_URL=otherdb://otheruser:otherpasswd@otherhost:otherport/otherdbname?otherdbserversion
```

## Field groups configuration

Field groups, used in content and Content Type editing, can be configured under the `repositories` key.
Values entered there are Field group *identifiers*:

``` yaml
repositories:
    default:
        fields_groups:
            list: [content, features, metadata]
            default: content
```

These identifiers can be given human-readable values and can be translated. Those values are used when editing Content Types.
The translation domain is `ezplatform_fields_groups`.
This example in `translations/ezplatform_fields_groups.en.yaml` defines English names for Field groups:

``` yaml
content: Content
metadata: Metadata
user_data: User data
```

## Limit of archived content versions

`default_version_archive_limit` controls the number of archived versions per Content item that are stored in the Repository.
By default it is set to 5. This setting is configured in the following way (typically in `ibexa.yaml`):

``` yaml
ibexa:
    repositories:
        default:
            options:
                default_version_archive_limit: 10
```

This limit is enforced on publishing a new version and only covers archived versions, not drafts.

!!! tip

    Don't set `default_version_archive_limit` too high.
    In Legacy storage engine you will see performance degradation if you store too many versions.
    The default value of 5 is the recommended value, but the less content you have overall,
    the more you can increase this to, for instance, 25 or even 50.

### Removing versions on publication

With `remove_archived_versions_on_publish` setting, you can control whether versions that exceed the limit are deleted when you publish a new version.

``` yaml
ibexa:
    repositories:
        default:
            options:
                remove_archived_versions_on_publish: true
```

`remove_archived_versions_on_publish` is set to `true` by default.
Set it to `false` if you have multiple older versions of content and need to avoid performance drops when publishing.

When you set the value to `false`, run [`ibexa:content:cleanup-versions`](#removing-old-versions) periodically
to make sure that Content item versions that exceed the limit are removed.

### Removing old versions

You can use the `ibexa:content:cleanup-versions` command to remove old content versions.

The command takes the following optional parameters:

- `status` or `t` - status of versions to remove: `draft`, `archived` or `all`
- `keep` or `k` - number of versions to keep
- `user` or `u` - the User that the command will be performed as. The User must have the `content/remove`, `content/read` and `content/versionread` Policies. By default the `administrator` user is applied.
- `excluded-content-types` - exclude versions of one or multiple Content Types from the cleanup procedure; separate multiple Content Types identifiers with the comma.

`ibexa:content:cleanup-versions --status <status name> --keep <number of versions> --user <user name> --excluded-content-types article,blog_post`

For example, the following command removes archived versions as user `admin`, but leaves the 5 most recent versions:

`ibexa:content:cleanup-versions --status archived --keep 5 --user administrator`

## User identifiers

`ibexa_default_settings.yaml` contains two settings that indicate which Content Types are treated like users and user groups:

``` yaml
ibexa:
    system:
        default:
            user_content_type_identifier: [user]
            user_group_content_type_identifier: [user_group]
```

You can override these settings if you have other Content Types that should be treated as users/user groups in the Back Office.
When viewing such Content in the Back Office you will be able to see e.g. the assigned Policies.

## Top-level Locations

You can change the default path for top-level Locations such as Content or Media in the Back Office, e.g.:

```yaml
ibexa:
    system:
        <siteaccess>:
            subtree_paths:
                content: '/1/18/'
                media: '/1/57/'
```

## Content Scheduler snapshots

Content Scheduler snapshots speed up the rendering of Content Scheduler blocks and reduce the space used in the database.
By default, five snapshots are stored, but you can modify this number with the following configuration,
depending on the complexity of the Content Scheduler blocks:

``` yaml
parameters:
    ibexa.field_type.page.block.schedule.snapshots.amount: 10
```

## Repository-aware configuration

In your custom development, you can create Repository-aware configuration settings.

This enables you to use different settings for different Repositories.

!!! tip "SiteAccess-aware configuration"

    If you need to use different settings per SiteAccess, not per Repository,
    see [SiteAccess-aware configuration](siteaccess_aware_configuration.md).

To do this, create a parser that implements `Ibexa\Bundle\Core\DependencyInjection\Configuration\RepositoryConfigParserInterface`:

``` php
use Ibexa\Bundle\Core\DependencyInjection\Configuration\RepositoryConfigParserInterface;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

final class CustomRepositoryConfigParser implements RepositoryConfigParserInterface
{
    public function addSemanticConfig(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder
            ->arrayNode('acme')
                ->children()
                    ->scalarNode('my_setting')
                        ->isRequired()
                        ->defaultValue(120)
                    ->end()
                ->end()
            ->end();
    }
}
```

You need to register this configuration extension in the following way:

``` php
final class AcmeFeatureBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        // ...

        /** @var Ibexa\Bundle\Core\DependencyInjection\IbexaCoreExtension $kernel */
        $kernel = $container->getExtension('ibexa');
        $kernel->addRepositoryConfigParser(new CustomRepositoryConfigParser());
    }
}
```

To access the configuration settings, use the `Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider::getRepositoryConfig` method:

``` php
$acmeConfig = $repositoryConfigProvider->getRepositoryConfig()['acme'];
```
