# URL management

You can manage external URL addresses and URL wildcards in the Back Office, **Admin** tab, the **URL Management** node.
Configure URL aliases to have human-readable URL addresses throughout your system.

## Link manager

When developing a site, users can enter links to external websites in either RichText or URL fields.
Each such link is then displayed in the URL table. You can view and update all external links that exist within the site, without having to modify and re-publish the individual Content items.

The Link manager tab contains all the information about each link, including its status (valid or invalid) and the time the system last attempted to validate the URL address.
Click an entry in the list to display its details and check which Content items use this link.
Edit the entry to update the URL address in all the occurrences throughout the website.

!!! note

    When you edit the details of an entry to update the URL address, the status automatically changes to valid.


## External URL validation

You can validate all the addresses from the URL table by executing the `ezplatform:check-urls` command.
It validates the links by accessing them one by one and updates the value in the Last checked field.
If a broken link is found, its status is set to "invalid".

The following protocols are currently supported:

- `http`
- `https`
- `mailto`

### Enabling automatic URL validation

To enable automatic URL validation, set up cron to run the `ezplatform:check-urls` command periodically.

For example, to check links every week, add the following script:

```
echo '0 0 * * 0 cd [path-to-ezplatform]; php bin/console ezplatform:check-urls --quiet --env=prod' > ezp_cron.txt
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

The configuration of external URLs validation is SiteAccess-aware and is stored in the `config/packages/ezplatform.yaml` file, under the `ezplatform.system.<SITEACCESS>.url_checker` key, for example:

```yaml
ezplatform:
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

For more information about ezPlatform configuration, see [Configuration](configuration.md).

### Custom protocol support

You can extend the external URL address validation with a custom protocol.
To do this, you must provide a service that implements the `\eZ\Bundle\EzPublishCoreBundle\URLChecker\URLHandlerInterface` interface:

```php
<?php

namespace eZ\Bundle\EzPublishCoreBundle\URLChecker;

interface URLHandlerInterface
{
    /**
     * Validates given list of URLs.
     *
     * @param \eZ\Publish\API\Repository\Values\URL\URL[] $urls
     */
    public function validate(array $urls);

    /**
     * Set handler options.
     *
     * @param array|null $options
     */
    public function setOptions(array $options = null);
}
```

Then you must register the service with an `ezpublish.url_handler` tag, like in the following example:

```yaml
app.url_checker.handler.custom:
    class: 'App\URLChecker\Handler\CustomHandler'
    ...
    tags:
        - { name: ezpublish.url_handler, scheme: custom }
```

The `scheme` attribute is mandatory and has to correspond to the name of the protocol, for instance, `ftp`.

## URL aliases

You can define URL aliases for individual Content items, for example, when you reorganize the content, and want to provide users with continuity.
For each URL alias definition the history of changes is preserved, so that users who have bookmarked the URL addresses of content items can still find he information they desire.

URL aliases are not SiteAccess-aware. When creating an alias, you can select a SiteAccess to base it on.
If the SiteAccess root path (configured in `content.tree_root.location_id`) is different than the default,
the prefix path that results from the configured content root is prepended to the final alias path.

### URL alias pattern configuration

You can configure how [[= product_name =]] generates URL aliases.
The configuration is stored in the `config/packages/ezplatform.yaml` file, under the `ezplatform.url_alias.slug_converter` key, for example:

``` yaml
ezplatform:
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

A transformation group consists of an array of commands (see [all available commands](https://github.com/ezsystems/ezplatform-kernel/tree/v1.0.0/eZ/Publish/Core/Persistence/Tests/TransformationProcessor/_fixtures/transformations)) and a [`cleanupMethod`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Persistence/Legacy/Content/UrlAlias/SlugConverter.php#L288).

You can make use of pre-defined transformation groups.
You can also add your own, with your own set of commands.
To add commands to an existing group, provide the group name and list the commands that you want to add.

### Regenerating URL aliases

You can use the `ezplatform:urls:regenerate-aliases` command to regenerate all URL aliases.
After the command is applied, old aliases redirect to the new ones.

Use it when:

- you change URL alias configuration and want to regenerate old aliases
- you encounter database corruption
- you have content that does not have a URL alias

!!! caution

    Before you apply the command, back up your database and make sure it is not modified while the command is running.


Execute the following command to regenerate aliases:

``` bash
bin/console ezplatform:urls:regenerate-aliases
```

You can also extend the command with the following parameters:

- `--iteration-count` — Defines how many Locations are processed at once to reduce memory usage
- `--location-id` — Regenerates URL addresses for specific Locations only, e.g. `ezplatform:urls:regenerate-aliases --location-id=1 --location-id=2`

## URL wildcards

With wildcards, you can change the URL address for many Content items at the same time, by replacing a portion of the destination's URL address.
For example, you might want to shorten the path, or make the path meaningful.

For each URL wildcard definition you set the wildcard pattern and its destination.
Also, you can decide whether the user sees the content at the address that uses wildcards (Direct type), or is redirected to the original URL address of the destination (Forward type).

For example, a URL wildcard called `pictures/*/*` can use `media/images/{1}/{2}` as destination.
In this case, accessing `<yourdomain>/pictures/home/photo/` loads `<yourdomain>/media/images/home/photo/`.

You can configure URL wildcards either in the Back Office, or with the Public API.

Before you configure URL wildcards, you must enable the feature in configuration in the `config/packages/ezplatform.yaml` file:

``` yaml
ezplatform:
    url_wildcards:
        enabled: true
```

### Configuring URL wildcards in the Back Office

The URL wildcards tab contains all the information about each URL wildcard. You can delete or modify existing entries, or create new ones.

!!! note

    To be able to modify wildcard support settings in the user interface, you must have the `content/urltranslator` Policy. For more information about permissions, see [Permissions](permissions.md).


### Configuring URL wildcards with the Public API

You can create URL wildcards with the Public API by using the `URLWildcardService` service:

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
If it is `false`, the old URL address is be used, with the new content.
