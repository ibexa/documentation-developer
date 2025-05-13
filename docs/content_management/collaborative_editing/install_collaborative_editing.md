---
description: Install the Collaborative editing LTS update.
month_change: false
---

# Install Collaborative editing

Collaborative editing feature is available as an LTS update to [[= product_name =]] starting with version v5.0 or higher, regardless of its edition.
To use this feature you must first install the packages and configure them.

## Install packages

Run the following commands to install the packages:

``` bash
composer require ibexa/collaboration
composer require ibexa/share
composer require ibexa/fieldtype-richtext-rte
```

This command adds the new real-time editing functionality to the Rich Text field type.
It also modifies the permission system to account for the new functionality.

## Configure Collaborative editing

Once the packages are installed, before you can start Collaborative editing feature, you must enable it by following these instructions.

### Add tables to the database

To add the tables to the database, run the following command:

``` bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
```

### Modify the bundles file

Then, in the `config/bundles.php` file, add the following code:

``` php
    <?php

return [
    // A lot of bundles…
    Ibexa\Bundle\Collaboration\IbexaCollaborationBundle::class => ['all' => true],
    Ibexa\Bundle\Share\IbexaShareBundle::class => ['all' => true],
    Ibexa\Bundle\FieldTypeRichTextRTE\IbexaFieldTypeRichTextRTEBundle::class => ['all' => true],
];
```

You can now restart you application and start [working with the Collaborative editing feature]([[= user_doc =]]/content_management/collaborative_editing/work_with_collaborative_editing/).