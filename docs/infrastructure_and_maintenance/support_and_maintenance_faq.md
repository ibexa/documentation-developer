---
description: See how you can resolve common issues and report a Customer Support ticket.
---

# Support and maintenance FAQ

This page contains answers to most common questions and tips around support and maintenance, references to important parts of the documentation, and tools for developers in their daily work.

#### What information should I specify when creating a Customer Support ticket?

When reporting a problem to Customer Support the most important information is the version of [[= product_name =]] which is used in the project.
The best way to specify it's to provide the list of currently installed packages by running:

``` bash
composer show ibexa/*
```

Besides that, all the configuration from the `config` directory may be helpful.

You should also list the steps to reproduce the issue, or at least provide a clear description of the circumstances under which the problem occurred.

If you stumble upon a database-related problem, providing corresponding logs is also an important step.

Additionally, mention recent changes, performed migrations or external scripts/code customizations related to the code which generates the problem.

#### What are the recommended ways to increase my project's performance?

The most important clues around increasing overall performance of your [[= product_name =]]-based project can be found in [the Performance documentation page](performance.md).

#### How can I translate my back office?

The language of the back office is based on the browser language.
To change it you should install the proper package for your language (see [language packages list](https://github.com/ezplatform-i18n)).
Once you have language packages installed, you can switch the language of the back office in the **User Settings** menu.

If you don't have a language defined in the browser, it's selected based on the `parameters.locale_fallback` parameter located in `config/packages/ibexa.yaml`.

To read more about language managing in [[= product_name =]], see the following doc pages:

- [Back office languages](back_office_translations.md)
- [Multi-language SiteAccesses and corresponding translations](set_up_translation_siteaccess.md)

#### How can I apply patches to the installation?

The easiest way to apply a patch to your project is by using the Unix [`patch`](https://man7.org/linux/man-pages/man1/patch.1.html) command.
Remember to clear the cache afterwards.

As an alternative to manually applying the patch, you can use [composer-patches](https://github.com/cweagans/composer-patches).
You can apply patches received from the Support, community or the others by using your `composer.json` file.
For checking the versions you're on, refer to your `composer.lock`.
All you need is to specify which package receives patches and give the path/URL to the actual file.
This should be done inside the `extra` section. Packages which should receive patches are removed during `composer update` or `composer require` so they can be re-installed and re-patched.

When updating to the release that already contains specified patches, Composer throws an error alongside a message that they cannot be applied and are skipped ([this is configurable with 1.x](https://github.com/cweagans/composer-patches/tree/1.x#error-handling)).
They can be manually removed from `composer.json` now.

#### How to clear the cache properly?

Clearing cache is covered by our [documentation](devops.md#cache-clearing), it applies to file and content (HTTP/persistence) cache.

Useful commands:

- clearing Symfony cache

```bash
php bin/console cache:clear --env prod
```

- clearing Redis cache

```bash
php bin/console cache:pool:clear cache.redis
```

- clearing Memcached cache

```bash
php bin/console cache:pool:clear cache.memcached
```

- clearing the Symfony cache manually

```bash
rm -rf var/cache/*
```

!!! caution "Clearing cache manually"

    Manual cache clearing should be executed with caution.
    `rm -rf var/cache/*` wipes all the files and unlike `cache:clear` doesn't warm up the cache.
    It results in a significant performance drop on first request, so it shouldn't be called on a production environment.
    Besides, it could lead to issues with file ownership after running `cache:clear` as a root.

#### Where should I place my configuration files?

To avoid merge conflicts on important configuration settings during upgrades, moving as much as possible of your configuration to your own files can be a good idea.

All project-specific parameters should be kept in separate files.
For example, configuration for Page Blocks could be placed in `config/packages/landing_page_blocks.yaml`.
You can also place it in `config/landing_page_blocks.yaml`, which should be imported in `config/ibexa.yaml`:

```yaml
imports:
    - { resource: ../landing_page_blocks.yaml }
```

#### How can I implement authentication in an [[= product_name =]]-based project?

The best approach is to use Symfony authentication.
Check [development security](development_security.md) page for more detailed instructions.
