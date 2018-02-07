# Register the Field Type as a service

To complete the implementation, you must register your Field Type with Symfony by creating a service for it.

Services are by default declared by bundles in `Resources/config/services.yml`.

##### Using a dedicated file for the Field Type services

In order to be closer to the kernel best practices, you could declare your Field Type services in a custom `fieldtypes.yml` file.

All you have to do is instruct the bundle to actually load this file in addition to `services.yml` (or instead of `services.yml`!). This is done in the extension definition file, `DependencyInjection/EzSystemsTweetFieldTypeExtension.php`, in the `load()` method.

Inside this file, find this line:

``` php
$loader->load('services.yml');
```

This is where your bundle tells Symfony that when parameters are loaded, `services.yml` should be loaded from `Resources/config/` (defined above). Add a new line either before or after this one with:

``` php
$loader->load('fieldtypes.yml');
```

Like most API components, Field Types use the [Symfony 2 service tag mechanism](http://symfony.com/doc/current/service_container/tags.html).

The principle is quite simple: a service can be assigned one or several tags, with specific parameters. When the dependency injection container is compiled into a PHP file, tags are read by `CompilerPass` implementations that add extra handling for tagged services. Each service tagged as `ezpublish.fieldType` is added to a [registry](http://martinfowler.com/eaaCatalog/registry.html) using the alias argument as its unique identifier (`ezstring`, `ezxmltext`, etc.). Each Field Type must also inherit from the abstract `ezpublish.fieldType` service. This ensures that the initialization steps shared by all Field Types are executed.

Here is the service definition for your Tweet type:

``` php
// **Resources/config/services.yml**

services:
    ezsystems.tweetbundle.twitter.client:
        class: EzSystems\TweetFieldTypeBundle\Twitter\TwitterClient
```

You take care of namespacing your Field Type with your vendor and bundle name to limit the risk of naming conflicts.

And you can create a YAML file dedicated to the Bundle

``` php
// **Resources/config/fieldtypes.yml**

services:
    ezsystems.tweetbundle.fieldtype.eztweet:
        parent: ezpublish.fieldType
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\Type
        tags:
            - {name: ezpublish.fieldType, alias: eztweet}
            - {name: ezpublish.fieldType.nameable, alias: eztweet}
        arguments: ['@ezsystems.tweetbundle.twitter.client']
```

------------------------------------------------------------------------

⬅ Previous: [Implement the Tweet\\Type class](3_implement_the_tweet_type_class.md)

Next: [Implement the Legacy Storage Engine Converter](5_implement_the_legacy_storage_engine_converter.md) ➡
