# Step 4 - Register the Field Type as a service

To complete the implementation, you must register the Field Type with Symfony by creating a service for it.

Services are by default declared by bundles in `Resources/config/services.yml`.

## Using a dedicated file for the Field Type services

In order to be closer to the kernel best practices, you will declare the Field Type services in a custom `fieldtypes.yml` file.

All you have to do is instruct the bundle to load this file in addition to `services.yml`.
This is done in the extension definition file, `DependencyInjection/EzSystemsTweetFieldTypeExtension.php`, in the `load()` method.

Inside this file, find this line:

``` php
$loader->load('services.yml');
```

This is where the bundle tells Symfony that when parameters are loaded, `services.yml` should be loaded from `Resources/config/` (defined above).
Add a new line either before or after this one:

``` php
$loader->load('fieldtypes.yml');
```

Like most API components, Field Types use the [Symfony service tag mechanism](http://symfony.com/doc/2.8/service_container/tags.html).

A service can be assigned one or several tags, with specific parameters. When the dependency injection container is compiled into a PHP file, tags are read by `CompilerPass` implementations that add extra handling for tagged services. Each service tagged as `ezpublish.fieldType` is added to a [registry](http://martinfowler.com/eaaCatalog/registry.html) using the alias argument as its unique identifier (`ezstring`, `ezxmltext`, etc.). Each Field Type must also inherit from the abstract `ezpublish.fieldType` service. This ensures that the initialization steps shared by all Field Types are executed.

Now you can create a YAML file dedicated to the bundle: `Resources/config/fieldtypes.yml`

``` php
services:
    ezsystems.tweetbundle.fieldtype.eztweet:
        parent: ezpublish.fieldType
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\Type
        tags:
            - {name: ezpublish.fieldType, alias: eztweet}
            - {name: ezpublish.fieldType.nameable, alias: eztweet}
        arguments: ['@ezsystems.tweetbundle.twitter.client']
```

Namespacing the Field Type with your vendor and bundle name limits the risk of naming conflicts.
