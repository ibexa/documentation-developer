# Bundles

## Dealing with bundles

eZ Platform is based on the Symfony 3 framework and applies a similar way of organizing the app. Like in Symfony, where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html), your eZ Platform application is going to be a collection of bundles.

### What is a bundle?

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation.

### How to use bundles?

All the bundles containing built-in eZ Platform functionalities are installed automatically
By default, a clean eZ Platform installation also contains an AppBundle where you can place your custom code.

You can see a list of other available community-developed bundles on <https://ezplatform.com/Bundles>.
Refer to their respective pages for instructions on how to install them.

To learn more about organizing your eZ Platform project, see [Best Practices](best_practices.md).

### How to create bundles?

You can generate a new bundle using a `generate:bundle` command. See [Symfony documentation on generating bundles](http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html).

#### How to remove a bundle?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the [How to Remove a Bundle](http://symfony.com/doc/current/bundles/remove.html) instruction in Symfony doc.

## Built-in bundles

Some of the key built-in bundles are:

#### eZ Platform kernel

[ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel) contains the core of the whole
eZ Platform application.

##### EzPublishCoreBundle

EzPublishCoreBundle is contained in [ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel).

To get an overview of EzPublishCoreBundle's configuration, run the following command-line script:

``` bash
php bin/console config:dump-reference ezpublish
```

#### PlatformUIBundle

[PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle) provides the main editing and back-end interface for eZ Platform.

#### ezplatform-solr-search-engine

[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)
is the [Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform.

#### Repository Forms

[Repository Forms](http://github.com/ezsystems/repository-forms) is a bundle which provides form-based interaction for the Repository Value objects.

It is currently used by:

- `ezsystems/platform-ui-bundle` for most management interfaces: Sections, Content Types, Roles, Policies, etc.
- `ezsystems/ezpublish-kernel` for user registration and user generated content

!!! enterprise

    #### StudioUIBundle

    [StudioUIBundle](https://github.com/ezsystems/StudioUIBundle) contains the Studio editing interface
    provided in eZ Platform Enterprise Edition.

    #### Landing Page Field Type Bundle

    [EzLandingPageFieldTypeBundle](https://github.com/ezsystems/EzLandingPageFieldTypeBundle) provides
    the Landing Page that is at the heart of StudioUI.

!!! tip

    You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/master/composer.json).
