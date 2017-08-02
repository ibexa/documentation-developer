# Service Container

## Definition

A service container, (aka **DIC**, *Dependency Injection Container*) is a special object that greatly facilitates dependencies resolution in your application and sits on [Dependency Injection design pattern](http://en.wikipedia.org/wiki/Dependency_injection). Basically, this design pattern proposes to inject all needed objects and configuration into your business logic objects (aka **services**). It avoids the massive use of singletons, global variables or complicated factories and thus makes your code much more readable and testable. It avoids "magic."

The main issue with dependency injection is how to resolve your dependencies for your services. This is where the service container comes into play. The role of a service container is to build and maintain your services and their dependencies. Basically, each time you need a service, you may ask the service container for it, which will either build it with the configuration you provided, or give you an existing instance if it is already available.

## In eZ Platform

eZ Platform uses [Symfony service container](http://symfony.com/doc/master/book/service_container.html).

It is very powerful and highly configurable. We encourage you to read its dedicated documentation as it will help you understand how eZ Platform services are made:

- [Introduction and basic usage](http://symfony.com/doc/master/book/service_container.html)
- [Full documentation of the Dependency Injection Component](http://symfony.com/doc/master/components/dependency_injection/index.html)
- [Cookbook](http://symfony.com/doc/master/cookbook/service_container/index.html)
- [Base service tags](http://symfony.com/doc/master/reference/dic_tags.html)

### Service tags

Service tags in Symfony DIC are a useful way of dedicating services to a specific purpose. They are usually used for extension points.

For instance, if you want to register a [Twig extension](http://twig.sensiolabs.org/doc/advanced.html#creating-extensions) to add custom filters, you will need to create the PHP class and declare it as a service in the DIC configuration with the *twig.extension* tag (see [Symfony cookbook entry](http://symfony.com/doc/master/cookbook/templating/twig_extension.html) for a full example).

eZ Platform exposes several features this way (see the list of core service tags). This is for example the case for Field Types.

You will find all service tags exposed by Symfony in [its reference documentation](http://symfony.com/doc/master/reference/dic_tags.html).

#### Core & API

|Tag name|Usage|
|------|------|
|`router`|Adds a specific router to the chain router|
|`twig.loader`|Registers a template loader for twig|
|`ezpublish.content_view_provider`|Registers a ContentViewProvider for template selection depending on content/Location being viewed|
|`ezpublish.storageEngine`|Registers a storage engine in the Repository factory|
|[`ezpublish.fieldType`](../api/field_type_api_and_best_practices.md#register-field-type)|Registers a Field Type|

#### Legacy

|Tag name|Usage|
|------|------|
|`ezpublish.storageEngine.legacy.converter`|Registers a converter for a Field Type in legacy storage engine|
|`ezpublish.fieldType.externalStorageHandler`|Registers an external storage handler for a Field Type|
|`ezpublish.fieldType.externalStorageHandler.gateway`|Registers an external storage gateway for a Field Type in legacy storage engine|
