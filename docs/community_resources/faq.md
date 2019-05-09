#FAQ

This section contains answers for most common questions, tips around support and maintenance, references to important parts of the documentation and tools useful for developers on their daily basis.

####What information should I specify when creating a Customer Support ticket?

From the Customer Support perspective the most important thing is version of eZ Platform which is used in the project. The best way to specify it is providing the list of currently installed packages by running composer command:
``` bash
composer show ezsystems/*
```

Besides that all the configuration from `app/config` directory might be helpful. It is good to give steps to reproduce the issue, or at least some meaningful description of circumstances under which the problem occurred.

If you stumbled upon some data inconsistency related problem providing database logs should also be important step.

Also, please remember to mention recent changes, performed migrations or external scripts/code customizations related to the code which generates problem.

####What are the recommended ways to increase my project's performance?

The most important clues around increasing overall performance of your eZ Platform based project can be found in dedicated [documentation page](../guide/performance.md).

####How can I translate my admin panel?

The language of the admin panel is based on the browser language. In order to change it you should install proper package for you language, refer to the following [list](https://github.com/ezplatform-i18n). 
Once you have language packages installed, you can switch the language of the Back Office in the User Settings menu.

If you do not have a language defined in the browser, the language will be selected based on `parameters.locale_fallback` parameter located in `default_parameters.yml`.

If you want to read more about languages managing in eZ Platform please see the following doc pages:

- https://doc.ezplatform.com/en/latest/guide/internationalization/#back-office-languages
- https://doc.ezplatform.com/en/latest/cookbook/setting_up_multi_language_siteaccesses/

####How should I proceed with contributions to eZ Platform?

First, create an issue in our [issue tracker](https://jira.ez.no/browse/EZP) and refer to it in commits and pull request headers. For example: `EZP-20104: ContentController should return error status when content is not found`. Then, you can fork our repository and create your own branch from the version of the package which you want to contribute to. 

Now you can introduce whatever changes you wish, either modifying existing files or creating new ones. Once you are done with your edits, add your files to the staging area, then commit with a short, clear description and push changes to your fork. Finally, you can go to the project's page on GitHub and you should see a `Compare and pull request` button. Activate it, write a description and select `Create pull request`. Start the pull request's name with the issue number. Now you can wait for your changes to be reviewed and eventually tested and merged into the product.

Here you can find more details regarding contribution procedure (provided resources apply to different repositories, but the whole process is more or less the same):
- https://doc.ezplatform.com/en/latest/community_resources/documentation/#contributing-through-git
- https://github.com/ezsystems/ezpublish-kernel#contributing

!!! tip
    
    To deal with patches for packages which are not yet released, you can use [composer-patches](https://github.com/cweagans/composer-patches).

####How to clear the cache properly?

Clearing cache is also covered by our [documentation](../guide/devops/#cache-clearing), it applies to file and content (http/persistence) cache.

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

    It should be executed with caution. `rm -rf var/cache/*` wipes all the files and unlike `cache:clear` doesn't warm up the cache. It reflects in significant performance drop on first request thus shouldn't be called on production environment. Besides, it could lead to issues with files ownership after running `cache:clear` as a root.
    
####Where should I place my configuration files?

In order to avoid overriding important configuration settings it is recommended to place them inside your bundle. In case of doubts follow suggestions from [dedicated documentation page](../guide/configuration.md) and [Symfony best practises](https://symfony.com/doc/3.4/best_practices/configuration.html).

####How could I implement authentication in eZ Platform based project?

The best approach is to use Symfony authentication. Check [development security](../guide/security.md) page for more detailed instructions.