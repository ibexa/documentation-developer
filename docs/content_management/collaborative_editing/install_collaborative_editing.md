---
description: Install the Collaborative editing LTS update.
editions:
    - lts-update
month_change: true
---

# Install Collaborative editing

Collaborative editing feature is available as an LTS update to [[= product_name =]] starting with version v5.0 or higher, regardless of its edition.
To use this feature you must first install the packages and configure them.

## Install packages

Run the following commands to install the packages:

``` bash
composer require ibexa/collaboration
composer require ibexa/share
```

If you have an arrangements with [[= product_name_base =]] to use Real-time editing feature, you also need to install following package:

``` bash
composer require ibexa/fieldtype-richtext-rte
```

This command instals also `ibexa/ckeditor-premium` package and adds the new real-time editing functionality to the Rich Text field type.
It also modifies the permission system to account for the new functionality.

## Configure Collaborative editing

Once the packages are installed, before you can start Collaborative editing feature, you must enable it by following these instructions.

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

To add the tables to the database, run the following commands:

``` bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/collaboration/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/share/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
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
];
```

### Add migration file and execute migration

Last step is to add migration file and execute migration with the following commands:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/collaboration/src/bundle/Resources/migrations/2025_08_26_10_14_shareable_user.yaml 
php bin/console ibexa:migrations:migrate --file=2025_08_26_10_14_shareable_user.yaml
```

You can now restart you application and start [working with the Collaborative editing feature]([[= user_doc =]]/content_management/collaborative_editing/work_with_collaborative_editing/).

### Security configurations

After an installation process is finished, go to `config/packages/security.yaml` and make following changes:

- uncomment following lines with `shared` user provider under the `providers` key:

```yaml
providers:
        shared:
            id: Ibexa\Collaboration\Security\User\ShareableLinkUserProvider
```

- uncomment following lines under the `ibexa_shareable_link` key:

```yaml
ibexa_shareable_link:
        request_matcher: Ibexa\Collaboration\Security\RequestMatcher\ShareableLinkRequestMatcher
        pattern: ^/
        provider: shared
        stateless: true
        user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
        guard:
            authenticator: Ibexa\Collaboration\Security\Authenticator\ShareableLinkAuthenticator
```