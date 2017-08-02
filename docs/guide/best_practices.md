# Best Practices

## Structuring an eZ Platform Project

Since release 2015.10, eZ Platform is very close to the [standard Symfony distribution](https://github.com/symfony/symfony-standard). It comes with default settings that will let you get started in a few minutes.

### The AppBundle

Most projects can use the provided `AppBundle`, in the `src` folder. It is enabled by default. The project's PHP code (controllers, event listeners, etc.) can be placed there. 

Reusable libraries should be packaged so that they can easily be managed using Composer.

### Templates

Project templates should go into `app/Resources/views`.

They can then be referenced in code without any prefix, for example `app/Resources/views/content/full.html.twig` can be referenced in twig templates or PHP as `content/full.html.twig`.

### Assets

Project assets should go into the `web` folder, and can be referenced as relative to the root, for example `web/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `web/assets` path.

### Configuration

Configuration may go into `app/config`. However, services definitions from `AppBundle` should go into `src/AppBundle/Resources/config`.

### Versioning a project

The recommended method is to version the whole ezplatform repository. Per installation configuration should use `parameters.yml`.

## eZ Platform Configuration

eZ Platform configuration is delivered using a number of dedicated configuration files. This config covers everything from selecting the content repository to siteaccesses to language settings.

### Configuration format

Config files can have different formats. The recommended one is YAML, which is used by default in the kernel (and in examples throughout the documentation). However, you can also have configuration in XML or PHP formats.

Basic configuration handling in eZ Platform is similar to the usual Symfony config. To use it, you define key/value pairs in your configuration files. Internally and by convention, keys follow a dot syntax where the different segments follow your configuration hierarchy. Keys are usually prefixed by a namespace corresponding to your application. Values can be anything, including arrays and deep hashes.

### Configuration files

Main configuration files are located in the `app/config` folder.

If you use the provided `AppBundle`, service definitions from it should go into `src/AppBundle/Resources/config`.

- `parameters.yml` contains infrastructure-related configuration. It is created based on the default settings defined in `parameters.yml.dist`.
- `config.yml` contains configuration stemming from Symfony and covers settings such as search engine or cache configuration.
- `ezplatform.yml` contains general configuration that is specific for eZ Platform, like for example siteaccess settings.
- `security.yml` is the place for security-related settings.
- `routing.yml` defines routes that will be used throughout the application.

Configuration can be made environment-specific using separate files for each environment. These files will contain additional settings and point to the general (not environment-specific) configuration that will be applied in other cases.

Here you can read more about [how configuration is handled in Symfony](http://symfony.com/doc/current/best_practices/configuration.html).

### Specific configuration

The configuration of specific aspects of eZ Platform is described precisely in the respective topics in the [Guide to eZ Platform](guide_to_ez_platform.md).

#### Selected configuration topics:

- [View provider](content_rendering.md#view-provider-configuration)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Content repository](repository.md#content-repository-configuration)
- [Authentication](security.md#configuration)
- [Sessions](sessions.md#configuration)
- [Siteaccess](siteaccess.md#basics)

## eZ Enterprise Configuration

### Configure layout templates to work with a Landing Page

Layout templates can be configured and adapted in any way you like, like all other templates in eZ Platform. However, for a layout to work together with a Landing Page, the zone **must have** the `data-studio-zone` attribute, and the zone container **requires** the `data-studio-zones-container` attribute to allow dropping Content into zones.

#### Clear cache if there is an issue loading layouts

If the new layout is not available when creating a new Landing Page, you may need to clear the cache (using `php app/console cache:clear`) and/or reload the app.

### Using Forms (Enterprise)

#### Avoiding possible inconsistency in forms

When creating a form using Form Fields each field is reflected with a unique ID in the database. This unique ID is tied with this field, regardless of changes made in Form Builder afterwards. 
This means that editing a field in a form that is already published may lead to possible inconsistency of data provided by viewers. 
For example: If you decide to gather a wider range of information from viewers, using a form that consist of many Form Fields is the best idea. However, after some time, it may seem reasonable to re-use one of the fields by changing its name and to collect information that requires the same field type. Let's say the field **Name** is renamed to **Full Name** in order to make it more clear for viewers and collect more accurate data. What happens here is that all entries from field's old version and all entries from updated field are now saved under the same unique ID. 

Best practice is to remove the old field and create a new one with a new unique ID if there is a risk of inconsistency.
