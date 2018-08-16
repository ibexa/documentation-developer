# Quickstart

This page explains how to quickly install and set up eZ Platform for development.

## Basic requirements

The recommended setup for using eZ Platform is:

- Linux operating system (Debian, Ubuntu or RHEL / CentOS)
- PHP 7.2
    - with following packages: `php-cli`, `php-fpm`, `php-mysql`, `php-xml`, `php-mbstring`, `php-intl`, `php-curl`, `php-gd`
- MySQL

For more details see [Full requirements](requirements_and_system_configuration.md).

## Installation

To install eZ Platform you need [Composer](https://getcomposer.org/) and git on your system.

``` bash
composer create-project --keep-vcs ezsystems/ezplatform .
composer ezplatform-install
```

For more details see [Install using Composer](install_using_composer.md).

See [Install manually](install_manually.md) to install eZ Platform on a different OS.

!!! tip "Demo site"

    You can alternatively install an example demo site:

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform-demo .
    ```

    The demo site is only a showcase. **Do not use it as a basis for development**.

## Run eZ Platform

To run eZ Platform on the built-in PHP server (for development only):

``` bash
php bin/console server:run
```

The command will output the address of the development server.
Add `/admin` to access the Back Office. The default Administrator login is `admin` with password `publish`.

## Project structure

eZ Platform is a Symfony app and follows the project structure used by Symfony.

For more details see [Structuring a bundle](../guide/bundles.md#structuring-a-bundle).

## First steps

See [First steps](first_steps.md) for common first tasks on a clean eZ Platform installation.
