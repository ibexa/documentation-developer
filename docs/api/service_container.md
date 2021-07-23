# Service container

The service container is a special object that facilitates dependency resolution.
It is based on the [dependency injection design pattern](http://en.wikipedia.org/wiki/Dependency_injection).

Dependency injection injects all needed objects and configuration into your business logic objects (known as services).
It avoids the massive use of singletons, global variables or complicated factories and makes code much more readable and testable.

The main issue with this pattern is how to resolve the dependencies for your services.
This is where the service container comes into play. The role of a service container is to build and maintain your services and their dependencies.
Each time you need a service, you may ask the service container for it.
It either builds the service with the configuration you provided, or gives you an existing instance if it is already available.

[[= product_name =]] uses the [Symfony service container](http://symfony.com/doc/current/service_container.html).

!!! tip

    To learn more about the service container, see the documentation for the [Symfony DependencyInjection component](http://symfony.com/doc/current/components/dependency_injection.html).

## Service tags

Service tags used by the Symfony service container are a way to dedicate services to a specific purpose. They are usually used for extension points.

For example, if you want to register a [Twig extension](https://symfony.com/doc/current/templating/twig_extension.html) to add custom filters,
create the PHP class and declare it as a service in the service container configuration with the `twig.extension` tag.
(See the [Symfony cookbook entry](http://symfony.com/doc/5.0/templating/twig_extension.html) for a full example).

[[= product_name =]] exposes several features this way, for example, Field Types.

!!! tip

    For a list of all service tags exposed by Symfony, see its [reference documentation](http://symfony.com/doc/5.0/reference/dic_tags.html).
