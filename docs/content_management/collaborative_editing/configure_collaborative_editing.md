---
description: Configure the Collaborative editing feature.
month_change: true
---

# Collaborative editing

Collaborative editing feature is available in [[= product_name =]] starting with version v5.0.2 or higher, regardless of its edition.

## Install Real-time editing feature package

If you have an arrangements with [[= product_name_base =]] to use Real-time editing feature, you need to install following package:

``` bash
composer require ibexa/fieldtype-richtext-rte
```

This command instals also `ibexa/ckeditor-premium` package and adds the new real-time editing functionality to the Rich Text field type.
It also modifies the permission system to account for the new functionality.

## Configure Collaborative editing

Before you can start Collaborative editing feature, you must enable it by following these instructions.

### Configuration

You can configure Collaborative editing per [Repository](repository_configuration.md).

Under `ibexa.repositories.<repository_name>.collaboration` [configuration key](configuration.md#configuration-files), indicate the settings for collaboration:

``` yaml
ibexa:
    repositories:
        <repository_name>:
            collaboration:
                participants:
                    allowed_types:
                        - internal
                        - external
                    auto_invite: <value>
                session:
                    public_link_enabled: <value>
```

The following setiings are available:

- participants:
    - `allowed_types` - defines allowed user types, values: `internal`, `external`, you can set one, both, or none of the values
    - `auto_invite` - determines whether invitations should be sent automatically when inviting someone to a session, default value: `true`, available values: `true`, `false`
- session:
    - `public_link_enabled` - determines whether the public link is available, default value: `false`, available values: `true`, `false`

### Add tables to the database

First, add the tables to the database:
Create the `ibexa_share.sql` file that contains the following code:

=== "MySQL"

    ``` sql
    [[= include_file('code_samples/collaboration/config/mysql/ibexa_share.sql', 0, None, '    ') =]]
    ```

=== "PostgreSQL"

    ``` sql
    [[= include_file('code_samples/collaboration/config/postgresql/ibexa_share.sql', 0, None, '    ') =]]
    ```

Then, run the following command, where `<database_name>` is the same name that you defined when you [installed](install_ibexa_dxp.md#change-installation-parameters) [[= product_name =]]:

=== "MySQL"

    ``` sql
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    ```

=== "PostgreSQL"

    ``` sql
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | postgresql -u <username> -p <password> <database_name>
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | postgresql -u <username> -p <password> <database_name>
    ```

### Modify the bundles file

Then, if not using Symfony Flex, add the following code to the `config/bundles.php` file:

``` php
<?php

return [
    // A lot of bundles…
    Ibexa\Bundle\Collaboration\IbexaCollaborationBundle::class => ['all' => true],
    Ibexa\Bundle\Share\IbexaShareBundle::class => ['all' => true],
    Ibexa\Bundle\FieldTypeRichTextRTE\IbexaFieldTypeRichTextRTEBundle::class => ['all' => true],
    Ibexa\Bundle\CkeditorPremium\IbexaCkeditorPremiumBundle::class => [‘all’ => true],
];
```

### Add migration file and execute migration

Last step is to add migration file and execute migration with the following commands:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/collaboration/src/bundle/Resources/migrations/2025_08_26_10_14_shareable_user.yaml 
php bin/console ibexa:migrations:migrate --file=2025_08_26_10_14_shareable_user.yaml
```

### Security configurations

After an installation process is finished, go to `config/packages/security.yaml` and make following changes:

- uncomment following lines with `shared` user provider under the `providers` key:

```yaml
security:
    providers:
        # ...
        shared:
            id: Ibexa\Collaboration\Security\User\ShareableLinkUserProvider
```

- uncomment following lines under the `ibexa_shareable_link` key:

```yaml
security:
    # ...
    ibexa_shareable_link:
        request_matcher: Ibexa\Collaboration\Security\RequestMatcher\ShareableLinkRequestMatcher
        pattern: ^/
        provider: shared
        stateless: true
        user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
        guard:
            authenticator: Ibexa\Collaboration\Security\Authenticator\ShareableLinkAuthenticator
```

You can now restart you application and start working with the Collaborative editing feature.