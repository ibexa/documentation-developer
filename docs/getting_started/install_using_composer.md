# Installation Using Composer

## Get Composer

If you don't have it already, install Composer, the command-line package manager for PHP. You need a copy of git installed on your machine. The following command uses PHP to download and run the Composer installer:

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

For further information about Composer usage see the [Using Composer](about_composer.md) section.

## Install eZ Platform

The commands below assume you have Composer installed globally, a copy of git on your system, and your **MySQL/MariaDB server already set up with a database**. Once you've got all the required PHP extensions installed, you can get eZ Platform up and running with the following commands:

``` bash
composer create-project --keep-vcs ezsystems/ezplatform ezplatform ^1
cd ezplatform
```

During the installation process you will be asked to input things like database host name, login, password and so on.
They will be placed in `<ezplatform>/app/config/parameters.yml`.

Next you will receive instructions on how to install data into the database, and how to run a simplified dev server using the `server:run` command.

For a more complete and better performing setup using Apache or nginx, read up on how to [install eZ Platform manually](install_manually.md).

!!! tip

    To install eZ Platform for production only, use the `--no-dev` option for your `composer create-project`:

    `composer create-project --no-dev --keep-vcs ezsystems/ezplatform ezplatform`

    In such a case always set `SYMFONY_ENV="prod"`, otherwise Symfony will default to `dev` and complain about missing GeneratorBundle.

### Installing another distribution

eZ Platform exists in different distributions.
You select the distribution by when performing the `ezplatform:install` command, by using the correct installation type.
It depends on the meta-repository you are using.

!!! caution "Demo installation"

    The Demo is intended for learning and inspiration. Do not use it as a basis for actual projects.

#### eZ Platform installation types

| Type | Repository |
|------|----------------|
| `clean` | [ezplatform](https://github.com/ezsystems/ezplatform) |
| `platform-demo` | [ezplatform-demo](https://github.com/ezsystems/ezplatform-demo) |

#### eZ Platform Enterprise Edition installation types

| Type | Repository |
|------|----------------|
| `studio-clean` | [ezplatform-ee](https://github.com/ezsystems/ezplatform-ee) |
| `platform-ee-demo`  | [ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo) |

!!! enterprise "eZ Platform Enterprise Edition"

    To install the Enterprise Edition you need an eZ Enterprise subscription and have to [set up Composer for that](about_composer.md#prerequisite-to-using-composer-with-ez-enterprise-software).

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform-ee
    cd ezplatform-ee
    php app/console ezplatform:install studio-clean
    ```

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based publisher, see [the manual installation guide](install_manually.md#enable-date-based-publisher_1).

### Installing another version

The instructions above show how to install the latest stable version, however with Composer you can specify the exact version and stability level you want to install.

Versions [can be expressed in many ways in Composer](https://getcomposer.org/doc/articles/versions.md), but the ones we recommend are:

-   Exact git tag: `v1.3.1`
-   Tilde for locking down the minor version: `~1.3.0`
    -   Equals: 1.3.\* 
-   Caret for allowing all versions within a major: `^1.3.0`
    -   Equals: 1.\* &lt;= 1.3.0

The above concerns stable releases, but [Composer lets you specify stability in many ways](https://getcomposer.org/doc/articles/versions.md#stability), mainly:

-   Exact git tag: `v1.4.0-beta1`
-   Stability flag on a given version: `1.4.0@beta`
    -   Equals: versions of 1.4.0 in stability order of: beta, rc, stable
    -   This can also be combined with tilde and caret to match ranges of unstable releases
-   Stability flag while omitting version: `@alpha` equals latest available alpha release

Example:

``` bash
composer create-project --keep-vcs ezsystems/ezplatform ezplatform @beta
cd ezplatform
php app/console ezplatform:install
```
