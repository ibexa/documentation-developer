# Installation Using Composer

## Get Composer

If you don't have it already, install Composer, the command-line package manager for PHP. You'll have to have a copy of Git installed on your machine. The following command uses PHP to download and run the Composer installer, and should be entered on your terminal and executed by pressing Return or Enter:

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

For further information about Composer usage see [Using Composer](about_composer.md).

## eZ Platform Installation

The commands below assume you have Composer installed globally, a copy of git on your system, and your **MySQL/MariaDB server *already set up* with a database**. Once you've got all the required PHP extensions installed, you can get eZ Platform up and running with the following commands:

``` bash
composer create-project --keep-vcs ezsystems/ezplatform ezplatform
cd ezplatform
```

1. If you are on PHP 7.1 and higher, this should start installation of eZ Platform v2. The version will show up first like this: `Installing ezsystems/ezplatform (v2.1.0)`.
2. During the installation process you will be asked to input things like database host name, login, password and so on.
3. At the end of the installation process, you will be given further instructions on how to proceed to set up a simplified dev setup using PHP's built-in web server. For a more complete and better performing setup using either Apache or Nginx, read up, for instance, on [how to install manually](install_manually.md) and/or [how to install using Docker](install_using_docker.md).


!!! tip

    To install eZ Platform for production only, use the `--no-dev` option for your `composer create-project`:
    `composer create-project --no-dev --keep-vcs ezsystems/ezplatform ezplatform`

    In such a case always set `SYMFONY_ENV="prod"`, otherwise Symfony will default to dev and complain about missing GeneratorBundle.


!!! note

    For more information about the availables options with Composer commands, see [the Composer documentation](https://getcomposer.org/doc/03-cli.md).


### Installing another distribution

eZ Platform exists in several distributions, listed in [Installation eZ Platform](install_ez_platform.md), some with their own installer as shown in the example below. To install the Enterprise Edition you need an eZ Enterprise subscription and have to [set up Composer for that](about_composer.md).

**eZ Platform Enterprise Edition**

``` bash
composer create-project --keep-vcs ezsystems/ezplatform-ee
cd ezplatform-ee

# Options are listed on php bin/console ezplatform:install -h
php bin/console ezplatform:install studio-clean
```

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based publisher, see [the manual installation guide](install_manually.md#enable-date-based-publisher_1).

### Installing another version

The instructions above show how to install the latest stable version, however with Composer you can specify the version and stability as well if you want to install something else. Using `composer create-project -h` you can see how you can specify another version:

> create-project \[options\] \[--\] \[&lt;package&gt;\] \[&lt;directory&gt;\] \[&lt;version&gt;\]
>
>  
>
> Arguments:
>
>   &lt;package&gt;                            Package name to be installed
>
>   &lt;directory&gt;                            Directory where the files should be created
>
>   &lt;version&gt;                              Version, will default to latest

Versions [can be expressed in many ways in Composer,](https://getcomposer.org/doc/articles/versions.md) but the ones we recommend are:

-   Exact git tag: `v1.3.1`
-   Tilde for locking down the minor version: `~1.3.0`
    -   Equals: 1.3.\* 
-   Caret for allowing all versions within a major: `^1.3.0`
    -   Equals: 1.\* &lt;= 1.3.0

What was described above concerns stable releases, however [Composer lets you specify stability in many ways](https://getcomposer.org/doc/articles/versions.md#stability), mainly:

-   Exact git tag: `v1.4.0-beta1`
-   Stability flag on a given version: `1.4.0@beta`
    -   Equals: versions of 1.4.0 in stability order of: beta, rc, stable
    -   This can also be combined with tilde and caret to match ranges of unstable releases
-   Stability flag while omitting version: '`@alpha` equals latest available alpha release

Example:

``` bash
composer create-project --keep-vcs ezsystems/ezplatform-demo ezplatform @beta
cd ezplatform

php bin/console ezplatform:install demo
```
