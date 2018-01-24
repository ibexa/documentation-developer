# Create the bundle

FieldTypes, like any other eZ Platform extensions, must be provided as Symfony 2 bundles. This chapter covers the creation and organization of this bundle.

Once you have [installed eZ Platform](../../getting_started/install_ez_platform/), including the creation of a database for the tutorial, [configured your server](../../getting_started/requirements_and_system_configuration/), and [started your web server](../../getting_started/starting_ez_platform/#web-server), you need to create a code base for the tutorial.

We will use [the Symfony 2 extension mechanism, bundles,](http://symfony.com/doc/current/bundles.html) to wrap the Fieldtype. You can get started with a bundle using the built-in Symfony 2 bundle generator, following the instructions on this page.
Then you will configure your Bundle to be able to write the code you need to create a Field Type.

The [tutorial's Github repository](https://github.com/ezsystems/TweetFieldTypeBundle) shows you the Bundle in a finished state.

## Generate the bundle

From the eZ Platform root, run the following:

``` bash
php app/console generate:bundle
```

First, you are asked:

``` bash
Are you planning on sharing this bundle across multiple applications? [no]: yes<enter>
```

Type the answer `yes` and submit it with an Enter.

Next you will be asked about the namespace of your bundle.

#### More about naming bundles

See (http://symfony.com/doc/current/bundles/best_practices.html#bundle-name) for more details on bundle naming conventions.

Put **EzSystems/TweetFieldTypeBundle** as Bundle namespace, then the name of the bundle will be hinted from this entry.

``` bash
Bundle namespace: EzSystems/TweetFieldTypeBundle<enter>
```

Next, you must select the bundle name. Choose a preferably unique name for the Field Type: `TweetFieldTypeBundle`. Add the vendor name (in this case, `EzSystems`, but you can of course substitute it with your own) and end the name with `Bundle`:

``` bash
Based on the namespace, we suggest EzSystemsTweetFieldTypeBundle.

Bundle name [EzSystemsTweetFieldTypeBundle]:<enter>
```

You are then asked for the target directory. Begin within the `src` folder, but you could (and should!) version it and have it moved to `vendor` at some point. Again, this is the default, so just hit Enter.

``` bash
Target Directory [src/]:<enter>
```

You must then specify which format the configuration will be generated as. Use yml, since it is what is used in eZ Platform itself. Of course, any other format could be used.

``` bash
Configuration format (annotation, yml, xml, php) [xml]: yml<enter>
```

Our bundle should now be generated. Navigate to `src/EzSystems/TweetFieldTypeBundle` and you should see the following structure:

``` bash
$ ls -l src/EzSystems/TweetFieldTypeBundle
Controller/
DependencyInjection/
EzSystemsTweetFieldTypeBundle.php
Resources/
Tests/
```

If the `generate:bundle` command returns an error about registering the bundle namespace in composer.json, add the following line to your composer.json file within the psr-4 section:

```
"EzSystems\\TweetFieldTypeBundle\\": "src/EzSystems/TweetFieldTypeBundle/"
```

Then execute the following command to regenerate the autoload files:

```
$ composer dump-autoload
```

Feel free to delete the Controller folder, since you won’t use it in this tutorial. It could have been useful, had our Field Type required an interface of its own.
Also, you can safely delete the `Resources/views/Default` folder and `Resources/config/routing.yml` file, as they won't be needed. You should remove the `ez_systems_tweet_field_type` entry from your app/config/routing.yml file as well.

The tests aren't part of the documentation, but you can find them in the repository.

## Structure the bundle

At this point, you have a basic application-specific Symfony 2 bundle. Let’s start by creating the structure for your Field Type.

To make it easier to move around the code, you will to some extent mimic the structure that is used in the kernel of eZ Platform. Native Field Types are located inside `ezpublish-kernel` (in `vendor/ezsystems`), in the `eZ/Publish/Core/FieldType` folder.
Each Field Type has its own subfolder: `TextLine`, `Email`, `Url`, etc.

Clone this GitHub repository to follow this tutorial, it will be useful: (https://github.com/ezsystems/TweetFieldTypeBundle).

You will use a structure quite close to this:

![Bundle structure](img/fieldtype_tutorial_repo.png)

From the tutorial git repository, list the contents of the `eZ/Publish/FieldType` folder:

     eZ
     └── Publish
        └── FieldType
            └── Tweet
                ├── Type.php
                └── Value.php

A Field Type requires two base classes: `Type` and `Value`.

### The Type class

The Type contains the logic of the Field Type: validating data, transforming from various formats, describing the validators, etc.
A Type class must implement `eZ\Publish\SPI\FieldType\FieldType`. It may also extend the `eZ\Publish\Core\FieldType\FieldType` abstract class. It should also implement the `eZ\Publish\SPI\FieldType\Nameable` interface.

### The Value class

The Value is used to represent an instance of our type within a Content item. Each Field will present its data using an instance of the Type’s Value class.
A value class must implement the `eZ\Publish\SPI\FieldType\Value` interface. It may also extend the `eZ\Publish\Core\FieldType\Value` abstract class.

------------------------------------------------------------------------

⬅ Previous: [Creating a Tweet Field Type](creating_a_tweet_field_type.md)

Next: [Implement the `Tweet\Value` class](2_implement_the_tweet_value_class.md) ➡
