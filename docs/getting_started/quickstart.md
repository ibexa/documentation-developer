# Quickstart

This page explains how to quickly install and set up eZ Platform for development.

## Prerequisites

To quickly install eZ Platform, you need a Linux machine with PHP and MySQL installed.

For more details see [Full requirements](requirements.md).

## Installation

To install eZ Platform you need [Composer](https://getcomposer.org/) and git on your system.
You also need to create a database.

``` bash
composer create-project --keep-vcs ezsystems/ezplatform . ^1
php app/console ezplatform:install clean
```

For more details see [Install eZ Platform](install_ez_platform.md).

## Run eZ Platform

To run eZ Platform on the built-in PHP server:

``` bash
php app/console server:run
```

The command will output the address of the development server.
Add `/ez` to access the Back Office. The default Administrator login is `admin` with password `publish`.

## Project structure

eZ Platform is a Symfony app and follows the project structure used by Symfony.

For more details see [Structuring a bundle](../guide/bundles.md#structuring-a-bundle).

## First steps

See [First steps](first_steps.md) for common first tasks on a clean eZ Platform installation.
