---
description: An Ibexa DXP project follows Symfony's directory structure to organize files in the project.
---

# Project organization

[[= product_name =]] is a Symfony application and follows the project structure used by Symfony.

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial/tree/v3-master) for the [Beginner tutorial](page_and_form_tutorial.md).

## PHP code

The project's PHP code (controllers, event listeners, etc.) should be placed in the `src` folder.

Reusable libraries should be packaged so that they can easily be managed using Composer.

## Templates

Project templates should go into the `templates` folder.

They can then be referenced in code without any prefix, for example `templates/full/article.html.twig` can be referenced in Twig templates or PHP as `full/article.html.twig`.

## Assets

Project assets should go into the `assets` folder.

They can be referenced as relative to the root, for example `assets/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `assets` path.

??? note "Removing `assets` manually"

    If you ever remove the `assets` folder manually, you need to dump translations before performing
    the `yarn encore <dev|prod>` command:
    
    ```
    php bin/console bazinga:js-translation:dump assets --merge-domains
    ```

## Configuration

You project's configuration is placed in the respective files in `config/packages`.
See [Configuration](configuration.md) for more information.

### Importing configuration from a bundle

If you are keeping some of your code in a bundle, dealing with core bundle semantic configuration can be tedious
if you maintain it in the main `config/packages/ibexa.yaml` configuration file.

You can import configuration from a bundle by following the Symfony tutorial [How to Import Configuration Files/Resources]([[= symfony_doc =]]/service_container/import.html).

## Versioning a project

The recommended method is to version the whole project repository.
