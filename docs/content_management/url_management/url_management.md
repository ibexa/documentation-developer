---
description: Manage URL aliases and wildcards, and validate external URLs.
---

# URL management

You can manage external URL addresses and URL wildcards in the back office, **Admin** tab, the **URL Management** node.
Configure URL aliases to have human-readable URL addresses throughout your system.

## Link manager

When developing a site, users can enter links to external websites in either RichText or URL fields.
Each such link is then displayed in the URL table. You can view and update all external links that exist within the site, without having to modify and re-publish the individual content items.

The **Link manager** tab contains all the information about each link, including its status (valid or invalid) and the time the system last attempted to validate the URL address.
Click an entry in the list to display its details and check which content items use this link.
Edit the entry to update the URL address in all the occurrences throughout the website.

!!! note

    When you edit the details of an entry to update the URL address, the status automatically changes to valid.


## External URL validation

You can validate all the addresses from the URL table by executing the `ibexa:check-urls` command.
It validates the links by accessing them one by one and updates the value in the Last checked field.
If a broken link is found, its status is set to "invalid".

The following protocols are currently supported:

- `http`
- `https`
- `mailto`

### Enabling automatic URL validation

To enable automatic URL validation, set up cron to run the `ibexa:check-urls` command periodically.

For example, to check links every week, add the following script:

```
echo '0 0 * * 0 cd [path-to-ibexa]; php bin/console ibexa:check-urls --quiet --env=prod' > ezp_cron.txt
```

Next, append the new cron to user's crontab without destroying existing crons.
Assuming that the web server user data is www-data:

```
crontab -u www-data -l|cat - ezp_cron.txt | crontab -u www-data -
```

Finally, remove the temporary file:

```
rm ezp_cron.txt
```

### Configuration

The configuration of external URLs validation is SiteAccess-aware and is stored under the `ibexa.system.<scope>.url_checker` [configuration key](configuration.md#configuration-files), for example:

```yaml
ibexa:
    system:
        default:
            url_checker:
                handlers:
                    http:
                    	enabled: true
                    	batch_size: 64
                    https:
                    	enabled: true
                    	ignore_certificate: false
                    mailto:
                    	enabled: false
```

Available options are protocol-specific.
For details, see the tables below.

#### http/https protocol

| Option             | Description                                                                              |  Default value |
|----------------------|----------------------------------------------------------------------------------------|-----------------------|
| enabled            | Enables link validation.                                                      | true          |
| timeout            | Defines the time that the request is allowed to take (in seconds).                       | 10            |
| connection_timeout | Defines the time that the connect phase is allowed to take (in seconds).                 | 5             |
| batch_size         | Defines a maximum number of asynchronous requests.                                     | 10            |
| ignore_certificate | Decides if the peer's SSL certificate or the certificate name are verified against the host. | false         |

#### mailto protocol

| Option             | Description                                                         | Default value |
|--------------------|---------------------------------------------------------------------|---------------|
| enabled            | Enables link validation.                                            | true          |

For more information about [[= product_name_base =]] configuration, see [Configuration](configuration.md).

### Custom protocol support

You can extend the external URL address validation with a custom protocol.
To do this, you must provide a service that implements the `Ibexa\Bundle\Core\URLChecker\URLHandlerInterface` interface:
s
```php
<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\Core\URLChecker;

interface URLHandlerInterface
{
    /**
     * Validates given list of URLs.
     *
     * @param \Ibexa\Contracts\Core\Repository\Values\URL\URL[] $urls
     */
    public function validate(array $urls);
}
```

Then you must register the service with an `ibexa.url_checker.handler` tag, like in the following example:

```yaml
app.url_checker.handler.custom:
    class: 'App\URLChecker\Handler\CustomHandler'
    ...
    tags:
        - { name: ibexa.url_checker.handler, scheme: custom }
```

The `scheme` attribute is mandatory and has to correspond to the name of the protocol, for instance, `ftp`.

## URL aliases

You can define URL aliases for individual content items, for example, when you reorganize the content, and want to provide users with continuity.
For each URL alias definition the history of changes is preserved, so that users who have bookmarked the URL addresses of content items can still find the information they desire.

!!! note

    Make sure that you correctly define languages used by the site in the configuration (under the `ibexa.system.<scope>.languages` key).
    Otherwise, redirections for the renamed Content with translations in multiple languages may fail to work properly.

!!! caution "Legacy storage engine limitation"

    The [Legacy storage engine](field_type_storage.md#legacy-storage-engine) doesn't archive URL aliases, which initially had the same name in multiple languages.
    For more information, see [the Jira ticket](https://issues.ibexa.co/browse/EZP-31818).

URL aliases aren't SiteAccess-aware. When creating an alias, you can select a SiteAccess to base it on.
If the SiteAccess root path (configured in `content.tree_root.location_id`) is different than the default,
the prefix path that results from the configured content root is prepended to the final alias path.

### URL alias pattern configuration

You can configure how [[= product_name =]] generates URL aliases.
The configuration is stored under the `ibexa.url_alias.slug_converter` [configuration key](configuration.md#configuration-files), for example:

``` yaml
ibexa:
    url_alias:
        slug_converter:
            transformation: example_group
            separator: dash
            transformation_groups:
                example_group:
                    commands:
                        - space_normalize
                        - hyphen_normalize
                        - apostrophe_normalize
                        - doublequote_normalize
                        - your_custom_command
                    cleanup_method: url_cleanup
```

| Option                | Description                                                                                               |
|-----------------------|-----------------------------------------------------------------------------------------------------------|
| `transformation`        | Indicates which pattern is used by default.                                                            |
| `separator`             | Decides what separator is used. There are three types of separator available: dash, underscore and space. |
| `transformation_groups` | Contains the available patterns for URL generation.                                                       |

A transformation group consists of an array of commands (see [all available commands](https://github.com/ibexa/core/tree/4.6/tests/lib/Persistence/TransformationProcessor/_fixtures/transformations)) and a [`cleanupText`](https://github.com/ibexa/core/blob/4.6/src/lib/Persistence/Legacy/Content/UrlAlias/SlugConverter.php#L286).

You can make use of pre-defined transformation groups.
You can also add your own, with your own set of commands.
To add commands to an existing group, provide the group name and list the commands that you want to add.

### Regenerating URL aliases

You can use the `ibexa:urls:regenerate-aliases` command to regenerate all URL aliases.
After the command is applied, old aliases redirect to the new ones.

Use it when:

- you change URL alias configuration and want to regenerate old aliases
- you encounter database corruption
- you have content that doesn't have a URL alias

!!! caution

    Before you apply the command, back up your database and make sure it's not modified while the command is running.


Execute the following command to regenerate aliases:

``` bash
bin/console ibexa:urls:regenerate-aliases
```

You can also extend the command with the following parameters:

- `--iteration-count` — Defines how many locations are processed at once to reduce memory usage
- `--location-id` — Regenerates URL addresses for specific locations only, for example, `ibexa:urls:regenerate-aliases --location-id=1 --location-id=2`

## URL wildcards

With wildcards, you can change the URL address for many content items at the same time, by replacing a portion of the destination's URL address.
For example, you might want to shorten the path, or make the path meaningful.

For each URL wildcard definition you set the wildcard pattern and its destination.
Also, you can decide whether the user sees the content at the address that uses wildcards (Direct type), or is redirected to the original URL address of the destination (Forward type).

For example, a URL wildcard called `pictures/*/*` can use `media/images/{1}/{2}` as destination.
In this case, accessing `<yourdomain>/pictures/home/photo/` loads `<yourdomain>/media/images/home/photo/`.

You can configure URL wildcards either in the back office, or with the public PHP API.

Before you configure URL wildcards, you must enable the feature in configuration:

``` yaml
ibexa:
    url_wildcards:
        enabled: true
```

### Configuring URL wildcards in the back office

The **URL wildcards** tab contains all the information about each URL wildcard. You can delete or modify existing entries, or create new ones.

!!! note

    To be able to modify wildcard support settings in the user interface, you must have the `content/urltranslator` policy.
    For more information about permissions, see [Permissions](permissions.md).


### Configuring URL wildcards with the public PHP API

You can create URL wildcards with the public PHP API by using the `URLWildcardService` service:

``` php
$source = 'pictures/*/*';
$destination = 'media/images/{1}/{2}';
$redirect = true;

$urlWildcardService = $repository->getURLWildcardService();
$repository->sudo(function ($repository) use ($urlWildcardService, $source, $destination, $redirect) {
    $urlWildcardService->create($source, $destination, $redirect);
});
```

If `$redirect` is set to `true`, the redirection changes the URL address.
If it's `false`, the old URL address is be used, with the new content.
