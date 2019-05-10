# FAQ

This page contains answers for most common questions and tips around support and maintenance,
as well as references to important parts of the documentation and tools useful for developers in their daily work.

#### What information should I specify when creating a Customer Support ticket?

When reporting a problem to Customer Support the most important information is the version of eZ Platform which is used in the project.
The best way to specify it is to provide the list of currently installed packages by running:

``` bash
composer show ezsystems/*
```

Besides that, all the configuration from the `app/config` directory may be helpful.

You should also list the steps to reproduce the issue,
or at least provide a clear description of the circumstances under which the problem occurred.

If you stumble upon a database-related problem, providing corresponding logs is also an important step.

Additionally, mention recent changes, performed migrations or external scripts/code customizations
related to the code which generates the problem.

#### What are the recommended ways to increase my project's performance?

The most important clues around increasing overall performance of your eZ Platform-based project can be found in [the Performance documentation page](../guide/performance.md).

#### How can I translate my Back Office?

The language of the Back Office is based on the browser language.
In order to change it you should install the proper package for your language (see [language packages list](https://github.com/ezplatform-i18n)).
Once you have language packages installed, you can switch the language of the Back Office in the User Settings menu.

If you do not have a language defined in the browser, it will be selected based on the `parameters.locale_fallback` parameter located in `default_parameters.yml`.

To read more about language managing in eZ Platform, see the following doc pages:

- [Back Office languages](https://doc.ezplatform.com/en/latest/guide/internationalization/#back-office-languages)
- [Setting up multi-language SiteAccesses and corresponding translations](https://doc.ezplatform.com/en/latest/cookbook/setting_up_multi_language_siteaccesses/)

#### How can I contribute code to eZ Platform?

First, create an issue in our [issue tracker](https://jira.ez.no/browse/EZP) and refer to it in commits and pull request headers.
For example: `EZP-20104: ContentController should return error status when content is not found`.
Then, you can fork our repository and create your own branch from the version of the package which you want to contribute to.

Now introduce your changes, either by modifying existing files or creating new ones.
Once you are done with your edits, add your files to the staging area,
then commit with a short, clear description and push changes to your fork.
Finally, go to the project's page on GitHub and you should see a `Compare and pull request` button.
Click it, write a description and select `Create pull request`.
Start the pull request's name with the issue number.
Now you can wait for your changes to be reviewed and eventually tested and merged into the product.

Here you can find more details regarding the contribution procedure
(provided resources apply to different repositories, but the whole process is more or less the same):

- [Contributing through git](https://doc.ezplatform.com/en/latest/community_resources/documentation/#contributing-through-git)
- [Contributing in ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel#contributing)

!!! tip

    To deal with patches for packages which are not yet released, you can use [composer-patches](https://github.com/cweagans/composer-patches).

#### How to clear the cache properly?

Clearing cache is covered by our [documentation](../guide/devops/#cache-clearing), it applies to file and content (HTTP/persistence) cache.

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
    It results in significant performance drop on first request, so it shouldn't be called on a production environment.
    Besides, it could lead to issues with file ownership after running `cache:clear` as a root.

#### Where should I place my configuration files?

In order to avoid merge conflicts on important configuration settings during upgrades,
moving as much as possible of your configuration to your own files can be a good idea.

There are two basic approaches to achieving that goal:

1. All project-specific parameters should be kept in separate files,
e.g. configuration for Landing Page Blocks could be placed in `landing_page_blocks.yml` which should be imported in `app/config/config.yml`:

    ```yaml
    imports:
        - { resource: landing_page_blocks.yml }
    ```

2. The same configuration could be moved to your bundle e.g. `AppBundle/Resources/config/landing_page_blocks.yml`.

In case of doubts follow suggestions from [Configuration documentation](../guide/configuration.md)
and [Symfony best practices](https://symfony.com/doc/3.4/best_practices/configuration.html).

#### How could I implement authentication in an eZ Platform-based project?

The best approach is to use Symfony authentication.
Check [development security](../guide/security.md) page for more detailed instructions.
