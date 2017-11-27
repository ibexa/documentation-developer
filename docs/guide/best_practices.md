# Best Practices

## Structuring a project

eZ Platform comes with default settings that will let you get started in a few minutes.

### The AppBundle

Most projects can use the provided `AppBundle`, in the `src` folder. It is enabled by default. The project's PHP code (controllers, event listeners, etc.) can be placed there. 

Reusable libraries should be packaged so that they can easily be managed using Composer.

### Templates

Project templates should go into `app/Resources/views`.

They can then be referenced in code without any prefix, for example `app/Resources/views/content/full.html.twig` can be referenced in Twig templates or PHP as `content/full.html.twig`.

### Assets

Project assets should go into the `web` folder.

They can be referenced as relative to the root, for example `web/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `web/assets` path.

### Configuration

Configuration may go into `app/config`. However, service definitions from `AppBundle` should go into `src/AppBundle/Resources/config`.

### Project example

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial) for the [eZ Enteprise Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md)

### Versioning a project

The recommended method is to version the whole ezplatform repository. Per installation configuration should use `parameters.yml`.

## Configuration

eZ Platform configuration is delivered using a number of dedicated configuration files. This config covers everything from selecting the content repository to SiteAccesses to language settings.

### Configuration format

Config files can have different formats. The recommended one is YAML, which is used by default in the kernel (and in examples throughout the documentation). However, you can also have configuration in XML or PHP formats.

Basic configuration handling in eZ Platform is similar to the usual Symfony config. To use it, you define key/value pairs in your configuration files. Internally and by convention, keys follow a dot syntax where the different segments follow your configuration hierarchy. Keys are usually prefixed by a namespace corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

### Configuration files

Main configuration files are located in the `app/config` folder.

- `parameters.yml` contains infrastructure-related configuration. It is created based on the default settings defined in `parameters.yml.dist`.
- `config.yml` contains configuration stemming from Symfony and covers settings such as search engine or cache configuration.
- `ezplatform.yml` contains general configuration that is specific for eZ Platform, like for example SiteAccess settings.
- `security.yml` is the place for security-related settings.
- `routing.yml` defines routes that will be used throughout the application.

Configuration can be made environment-specific using separate files for each environment. These files will contain additional settings and point to the general (not environment-specific) configuration that will be applied in other cases.

Here you can read more about [how configuration is handled in Symfony](http://symfony.com/doc/current/best_practices/configuration.html).

### Configuration handling

!!! note

    Configuration is tightly related to the service container.
    To fully understand the following content, you need to be familiar with [Symfony's service container](service_container.md) and [its configuration](http://symfony.com/doc/current/book/service_container.html#service-parameters).

Basic configuration handling in eZ Platform is similar to what is commonly possible with Symfony.
You can define key/value pairs in [your configuration files](http://symfony.com/doc/current/book/service_container.html#importing-other-container-configuration-resources),
under the main `parameters` key (see for example [parameters.yml](https://github.com/ezsystems/ezplatform/blob/master/app/config/parameters.yml.dist#L2)).

Internally and by convention, keys follow a **dot syntax**, where the different segments follow your configuration hierarchy. Keys are usually prefixed by a *namespace* corresponding to your application. Values can be anything, including arrays and deep hashes.

eZ Platform core configuration is prefixed by `ezsettings` namespace, while *internal* configuration (not to be used directly) is prefixed by `ezpublish` namespace.

For configuration that is meant to be exposed to an end-user (or end-developer),
it's usually a good idea to also [implement semantic configuration](http://symfony.com/doc/current/components/config/definition.html).

Note that it is also possible to [implement SiteAccess-aware semantic configuration](../cookbook/exposing_siteaccess_aware_configuration_for_your_bundle.md).

#### Example

``` yaml
# Configuration
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

### Specific configuration

The configuration of specific aspects of eZ Platform is described precisely in the respective topics in the [Guide to eZ Platform](introduction.md).

- [View provider](content_rendering.md#configuring-views-the-viewprovider)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Content repository](repository.md#content-repository-configuration)
- [Authentication](security.md#configuration)
- [Sessions](sessions.md#configuration)

!!! enterprise

    ## eZ Enterprise Configuration

    ### Landing Page layout templates

    Layout templates can be configured and adapted in any way you like, like all other templates in eZ Platform. However, for a Landing Page layout to work the zone **must have** the `data-studio-zone` attribute, and the zone container **requires** the `data-studio-zones-container` attribute to allow dropping Content into zones.

    #### Clear cache if there is an issue loading layouts

    If the new layout is not available when creating a new Landing Page, you may need to clear the cache (using `php app/console cache:clear`) and/or reload the app.

    ### Using Forms

    #### Avoiding possible inconsistency in forms

    When creating a form using Form Fields each field is reflected with a unique ID in the database. This unique ID is tied with this field, regardless of changes made in Form Builder afterwards. 
    This means that editing a field in a form that is already published may lead to possible inconsistency of data provided by viewers. 
    For example: If you decide to gather a wider range of information from viewers, using a form that consist of many Form Fields is the best idea. However, after some time, it may seem reasonable to re-use one of the fields by changing its name and to collect information that requires the same field type. Let's say the field **Name** is renamed to **Full Name** in order to make it more clear for viewers and collect more accurate data. What happens here is that all entries from field's old version and all entries from updated field are now saved under the same unique ID. 

Best practice is to remove the old field and create a new one with a new unique ID if there is a risk of inconsistency.

## Various configuration settings

### Default page

You can define the default page that will be shown after user login.
This overrides Symfony's `default_target_path`, and enables you to configure redirection per SiteAccess.

``` yaml
# ezplatform.yml
ezpublish:
    system:
        ezdemo_site:
            default_page: "/Getting-Started"

        ezdemo_site_admin:
            # For admin, redirect to dashboard after login.
            default_page: "/content/dashboard"
```

This setting **does not change Symfony behavior** regarding redirection after login. If set, it will only substitute the value set for `default_target_path`. It is therefore still possible to specify a custom target path using a dedicated form parameter.

**Order of precedence is not modified.**

### Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ezsystems.platformui.application_config.copy_subtree.limit`
in `parameters.yml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.
