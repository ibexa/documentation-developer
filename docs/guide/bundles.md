# Bundles

## Introduction

eZ CMS is based on the Symfony2 framework and follows its organization of the app. Like in Symfony, where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html), your eZ application is going to be a collection of bundles.

### What is a bundle?

A bundle in Symfony (and eZ) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ CMS functionalities are provided through separate bundles included in the installation.

### How to use bundles?

By default, a clean eZ Platform installation contains an AppBundle where you can place your code.

To learn more about organizing your eZ project, see [Best Practices](best_practices.md).

You can see a list of available community-developed bundles on <https://ezplatform.com/Bundles>.

### How to create bundles?

You can generate a new bundle using a `generate:bundle` command. See [Symfony documentation on generating bundles](http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html).

In addition to [Symfony Bundles](http://symfony.com/doc/bundles/), eZ provides a set of bundles out of the box and some optional ones.

#### How to remove a bundle?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the [How to Remove a Bundle](http://symfony.com/doc/current/bundles/remove.html) instruction in Symfony doc.

## Configuration

### EzPublishCoreBundle Configuration

To get an overview of EzPublishCoreBundle's configuration, run the following command-line script:

``` bash
php app/console config:dump-reference ezpublish
```

### Default page

Default page is the default page to show or redirect to.

If set, it will be used for default redirection after user login, overriding Symfony's `default_target_path`, giving the opportunity to configure it by SiteAccess.

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

This setting **does not change anything to Symfony behavior** regarding redirection after login. If set, it will only substitute the value set for `default_target_path`. It is therefore still possible to specify a custom target path using a dedicated form parameter.

**Order of precedence is not modified.**
