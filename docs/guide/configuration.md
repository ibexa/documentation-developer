# Configuration

eZ Platform configuration is delivered using a number of dedicated configuration files.
It contains everything from selecting the content Repository to SiteAccesses to language settings.

### Configuration format

The recommended configuration format is YAML. It is used by default in the kernel (and in examples throughout the documentation).
However, you can also use XML or PHP formats for configuration.

### Configuration files

Main configuration files are located in the `app/config` folder.

- `parameters.yml` contains infrastructure-related configuration. It is created based on the default settings defined in `parameters.yml.dist`.
- `config.yml` contains configuration stemming from Symfony and covers settings such as search engine or cache configuration.
- `ezplatform.yml` contains general configuration that is specific for eZ Platform, like for example SiteAccess settings.
- `security.yml` is the place for security-related settings.
- `routing.yml` defines routes that will be used throughout the application.

Configuration can be made environment-specific using separate files for each environment. These files contain additional settings and point to the general (not environment-specific) configuration that is applied in other cases.

Here you can read more about [how configuration is handled in Symfony](http://symfony.com/doc/current/best_practices/configuration.html).

### Configuration handling

!!! note

    Configuration is tightly related to the service container.
    To fully understand it, you need to be familiar with [Symfony's service container](service_container.md) and [its configuration](http://symfony.com/doc/current/book/service_container.html#service-parameters).

Basic configuration handling in eZ Platform is similar to what is commonly possible with Symfony.
You can define key/value pairs in [your configuration files](https://symfony.com/doc/current/service_container/import.html),
under the main `parameters` key (see for example [parameters.yml](https://github.com/ezsystems/ezplatform/blob/master/app/config/parameters.yml.dist#L2)).

Internally and by convention, keys follow a **dot syntax**, where the different segments follow your configuration hierarchy. Keys are usually prefixed by a *namespace* corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

For configuration that is meant to be exposed to an end-user (or end-developer),
it's usually a good idea to also [implement semantic configuration](http://symfony.com/doc/current/components/config/definition.html).

Note that you can also [implement SiteAccess-aware semantic configuration](../cookbook/exposing_siteaccess_aware_configuration_for_your_bundle.md).

#### Example

``` yaml
parameters:
    myapp.parameter.name: someValue
    myapp.boolean.param: true
    myapp.some.hash:
        foo: bar
        an_array: [apple, banana, pear]
```

``` php
// Usage inside a controller
$myParameter = $this->container->getParameter( 'myapp.parameter.name' );
```

## Dynamic configuration with the ConfigResolver

In eZ Platform it is fairly common to have different settings depending on the current SiteAccess (e.g. languages, [view provider](content_rendering.md#configuring-views-the-viewprovider) configuration).

#### ConfigResolver Usage

Dynamic configuration is handled by a **config resolver**. It consists in a service object mainly exposing `hasParameter()` and `getParameter()` methods. The idea is to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

In order to work with the config resolver, your dynamic settings must comply internally with the following name format: `<namespace>.<scope>.parameter.name`.

The following configuration is an example of internal usage inside the code of eZ Platform:

``` yaml
# Namespace + scope example
parameters:
    # Some internal configuration
    ezsettings.default.content.default_ttl: 60
    ezsettings.ezdemo_site.content.default_ttl: 3600
 
    # Here "myapp" is the namespace, followed by the SiteAccess name as the parameter scope
    # Parameter "foo" will have a different value in ezdemo_site and ezdemo_site_admin
    myapp.ezdemo_site.foo: bar
    myapp.ezdemo_site_admin.foo: another value
    # Defining a default value, for other SiteAccesses
    myapp.default.foo: Default value
 
    # Defining a global setting, used for all SiteAccesses
    #myapp.global.some.setting: This is a global value
```

``` php
// Inside a controller, assuming SiteAccess being "ezdemo_site"
/** @var $configResolver \eZ\Publish\Core\MVC\ConfigResolverInterface **/
$configResolver = $this->getConfigResolver();
 
// ezsettings is the default namespace, so no need to specify it
// The following will resolve ezsettings.<siteaccessName>.content.default_ttl
// In the case of ezdemo_site, will return 3600.
// Otherwise it will return the value for ezsettings.default.content.default_ttl (60)
$locationViewSetting = $configResolver->getParameter( 'content.default_ttl' );
 
$fooSetting = $configResolver->getParameter( 'foo', 'myapp' );
// $fooSetting's value will be 'bar'
 
// Force scope
$fooSettingAdmin = $configResolver->getParameter( 'foo', 'myapp', 'ezdemo_site_admin' );
// $fooSetting's value will be 'another value'
 
// Note that the same applies for hasParameter()
```

Both `getParameter()` and `hasParameter()` can take 3 different arguments:

1. `$paramName` (the name of the parameter you need)
2. `$namespace` (your application namespace, `myapp` in the previous example. If null, the default namespace will be used, which is `ezsettings` by default)
3. `$scope` (a SiteAccess name. If null, the current SiteAccess will be used)

#### Inject the ConfigResolver in your services

Instead of injecting the whole ConfigResolver service, you may directly [inject your SiteAccess-aware settings (aka dynamic settings) into your own services](#dynamic-settings-injection).

You can use the ConfigResolver in your own services whenever needed. To do this, just inject the `ezpublish.config.resolver service`:

``` yaml
parameters:
    my_service.class: My\Cool\Service
 
services:
    my_service:
        class: %my_service.class%
        arguments: [@ezpublish.config.resolver]
```

``` php
<?php
namespace My\Cool;
 
use eZ\Publish\Core\MVC\ConfigResolverInterface;
 
class Service
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;
 
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
        $myParam = $this->configResolver->getParameter( 'foo', 'myapp' );
    }
 
    // ...
}
```

### Dynamic Settings Injection

When implementing a service needing SiteAccess-aware settings (e.g. language settings), you can inject these dynamic settings explicitly from their service definition (yml, xml, annotation, etc.).

#### Syntax

Static container parameters follow the `%<parameter_name>%` syntax in Symfony.

Dynamic parameters have the following: `$<parameter_name>[; <namespace>[; <scope>]]$`, default namespace being `ezsettings`, and default scope being the current SiteAccess.

For more information, see [ConfigResolver](#dynamic-configuration-with-the-configresolver).

#### DynamicSettingParser

The *DynamicSettingParser* service that can be used for adding support of the dynamic settings syntax.
This service has `ezpublish.config.dynamic_setting.parser` for ID and implements` eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\DynamicSettingParserInterface`.

#### Limitations

- It is not possible to use dynamic settings in your semantic configuration (e.g. `config.yml` or `ezplatform.yml`) as they are meant primarily for parameter injection in services.
- It is not possible to define an array of options having dynamic settings. They will not be parsed. Workaround is to use separate arguments/setters.
- Injecting dynamic settings in request listeners is **not recommended**, as it won't be resolved with the correct scope (request listeners are *instantiated before SiteAccess match*). Workaround is to inject the ConfigResolver instead, and resolve the setting in your `onKernelRequest` method (or equivalent).

#### Examples

##### Injecting an eZ parameter

Defining a simple service needing a `languages` parameter (that is, prioritized languages).

!!! note

    Internally, the `languages` parameter is defined as `ezsettings.<siteaccess_name>.languages`, `ezsettings` being eZ internal namespace.

##### Using setter injection (preferred)

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        calls:
            - [setLanguages, ["$languages$"]]
```

``` php
namespace Acme\TestBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function setLanguages( array $languages = null )
    {
        $this->languages = $languages;
    }
}
```

!!! caution

    Ensure you always add `null` as a default value, especially if the argument is type-hinted.

##### Using constructor injection

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        arguments: ["$languages$"]
```

``` php
namespace Acme\TestBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function __construct( array $languages )
    {
        $this->languages = $languages;
    }
}
```

!!! tip

    Setter injection for dynamic settings should always be preferred, as it makes it possible to update your services that depend on them when ConfigResolver is updating its scope (e.g. when previewing content in a given SiteAccess). **However, only one dynamic setting should be injected by setter**.

    **Constructor injection will make your service be reset in that case.**

##### Injecting third party parameters

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass
    # "acme" is our parameter namespace.
    # Null is the default value.
    acme.default.some_parameter: ~
    acme.ezdemo_site.some_parameter: foo
    acme.ezdemo_site_admin.some_parameter: bar
 
services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        # The following argument will automatically resolve to the right value, depending on the current SiteAccess.
        # We specify "acme" as the namespace we want to use for parameter resolving.
        calls:
            - [setSomeParameter, ["$some_parameter;acme$"]]
```

``` php
namespace Acme\TestBundle;
class MyServiceClass
{
    private $myParameter;
    public function setSomeParameter( $myParameter = null )
    {
        // Will be "foo" for ezdemo_site, "bar" for ezdemo_site_admin, or null if another SiteAccess.
        $this->myParameter = $myParameter;
    }
}
```

## Content Repository configuration

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

## Back Office configuration

### Default page

You can define the default page that will be shown after user login.
This overrides Symfony's `default_target_path`, and enables you to configure redirection per SiteAccess.

``` yaml
ezpublish:
    system:
        ezdemo_site:
            default_page: "/Getting-Started"

        ezdemo_site_admin:
            # For admin, redirect to dashboard after login.
            default_page: "/content/dashboard"
```

This setting **does not change Symfony behavior** regarding redirection after login. If set, it will only substitute the value set for `default_target_path`. It is therefore still possible to specify a custom target path using a dedicated form parameter.

**Order of precedence is not modified.**

### Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ezpublish.system.<SiteAccess>.subtree_operations.copy_subtree.limit`
in `parameters.yml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.

You can copy subtree from CLI using the command: `bin/console ezplatform:copy-subtree <sourceLocationId> <targetLocationId>`.

### Pagination limits

Default pagination limits for different sections of the Back Office are defined in the following settings:

``` yaml
ezsettings.default.pagination.search_limit: 10
ezsettings.default.pagination.trash_limit: 10
ezsettings.default.pagination.section_limit: 10
ezsettings.default.pagination.language_limit: 10
ezsettings.default.pagination.role_limit: 10
ezsettings.default.pagination.content_type_group_limit: 10
ezsettings.default.pagination.content_type_limit: 10
ezsettings.default.pagination.role_assignment_limit: 10
ezsettings.default.pagination.policy_limit: 10
ezsettings.default.pagination.version_draft_limit: 5
ezsettings.default.subitems_module.limit: 10
```

### Default Locations

#### Default Location IDs for Content structure, Media and Users in the menu

``` yaml
# System Location IDs
ezsettings.default.location_ids.content_structure: 2
ezsettings.default.location_ids.media: 43
ezsettings.default.location_ids.users: 5
```

#### Default starting Location ID for the Universal Discovery Widget

``` yaml
# Universal Discovery Widget Module
ezsettings.default.universal_discovery_widget_module.default_location_id: 1
```

### Notification timeout

To define the timeout for hiding Back-Office notification bars, use the following configuration,
per notification type:

``` yaml
ezpublish:
    system:
        admin:
            notifications:
                error:
                    timeout: 0
                warning:
                    timeout: 0
                success:
                    timeout: 5000
                info:
                    timeout: 0
```

The values shown above are the defaults (in milliseconds). `0` means the notification does not hide automatically.

### Location for Form-uploaded files

You can use Forms to enable the user to upload files.
The default Location for files uploaded in this way is `/Media/Files/Form Uploads`.
You can change it with the following configuration:

``` yaml
ezpublish:
    system:
        default:
            form_builder:
                upload_location_id: 54
```

This applies only if no specific Location is defined in the Form itself.

## Other configuration

The configuration related to other specific topics is described in:

- [View provider](content_rendering.md#configuring-views-the-viewprovider)
- [Multisite](multisite.md#configuring-multisite)
- [SiteAccess](siteaccess.md#configuring-siteaccesses)
- [Image variations](images.md#configuring-image-variations)
- [Multi-file upload](file_management.md#multi-file-upload)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Authentication](security.md#symfony-authentication)
- [Sessions](sessions.md#configuration)
- [Persistence cache](persistence_cache.md#configuration)
