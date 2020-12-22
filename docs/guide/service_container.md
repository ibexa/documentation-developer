# Service container

A service container (aka Dependency Injection Container, DIC) is a special object that facilitates dependency resolution.
It is based on the [dependency injection design pattern](http://en.wikipedia.org/wiki/Dependency_injection).

Dependency injection proposes to inject all needed objects and configuration into your business logic objects (known as **services**).
It avoids the massive use of singletons, global variables or complicated factories and makes your code much more readable and testable.

The main issue with this pattern is how to resolve the dependencies for your services.
This is where the service container comes into play. The role of a service container is to build and maintain your services and their dependencies.
Each time you need a service, you may ask the service container for it.
It will either build the service with the configuration you provided, or give you an existing instance if it is already available.

[[= product_name =]] uses the [Symfony service container](http://symfony.com/doc/5.0/service_container.html).

!!! tip

    To learn more about the service container, see:

    - [Full documentation of the Dependency Injection Component](http://symfony.com/doc/5.0/components/dependency_injection.html)
    - [Base service tags](http://symfony.com/doc/5.0/reference/dic_tags.html)

## Service tags

Service tags in Symfony DIC are a useful way of dedicating services to a specific purpose. They are usually used for extension points.

For instance, if you want to register a [Twig extension](http://twig.sensiolabs.org/doc/advanced.html#creating-extensions) to add custom filters,
you need to create the PHP class and declare it as a service in the DIC configuration with the `twig.extension` tag
(see the [Symfony cookbook entry](http://symfony.com/doc/5.0/templating/twig_extension.html) for a full example).

[[= product_name =]] exposes several features this way (see the [list of core service tags](#core-and-api)).
This is for example the case with Field Types.

You will find all service tags exposed by Symfony in [its reference documentation](http://symfony.com/doc/5.0/reference/dic_tags.html).

### Core and API

|Tag name|Usage|
|------|------|
|`router`|Adds a specific router to the chain router|
|`twig.loader`|Registers a template loader for Twig|
|`ezpublish.content_view_provider`|Registers a ContentViewProvider for template selection depending on content/Location being viewed|
|`ezpublish.storageEngine`|Registers a storage engine in the Repository factory|
|[`ezplatform.field_type`](../api/field_type_type_and_value.md#registration)|Registers a Field Type|

### Legacy

|Tag name|Usage|
|------|------|
|`ezplatform.field_type.legacy_storage.converter`|Registers a converter for a Field Type in Legacy storage engine|
|`ezplatform.field_type.external_storage_handler`|Registers an external storage handler for a Field Type|
|`ezplatform.field_type.external_storage_handler.gateway`|Registers an external storage gateway for a Field Type in Legacy storage engine|
