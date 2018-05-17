# Service container

A service container (aka Dependency Injection Container, DIC) is a special object that facilitates dependency resolution.
It is based on the [dependency injection design pattern](http://en.wikipedia.org/wiki/Dependency_injection).

Dependency injection proposes to inject all needed objects and configuration into your business logic objects (known as **services**).
It avoids the massive use of singletons, global variables or complicated factories and makes your code much more readable and testable.

The main issue with this pattern is how to resolve the dependencies for your services.
This is where the service container comes into play. The role of a service container is to build and maintain your services and their dependencies.
Each time you need a service, you may ask the service container for it.
It will either build the service with the configuration you provided, or give you an existing instance if it is already available.

eZ Platform uses the [Symfony service container](http://symfony.com/doc/2.8/service_container.html).

!!! tip

    To learn more about the service container, see:

    - [Full documentation of the Dependency Injection Component](http://symfony.com/doc/2.8/components/dependency_injection.html)
    - [Base service tags](http://symfony.com/doc/2.8/reference/dic_tags.html)

## Service tags

eZ Platform exposes several features also via service tags (see the [list of core service tags](service_tags.md)).

