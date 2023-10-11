# URL management

## External URL validation

Every link that is input into a RichText or URL Field is stored in the URL table.
You can view and edit published URLs in the Link manager without having to modify the Content items.
This means that you don't have to edit and re-publish your content if you just want to change a link.

The Link manager contains all the necessary information about each address including its status (valid or invalid)
and the time it was last checked (when the system attempted to validate the URL).
By default, all URLs are valid.

You can use the `ezplatform:check-urls` command to check all the addresses stored in the URL table.
It validates the links by accessing them one by one.
If a broken link is found, its status is set to "invalid". The last checked field is always updated.

The following protocols are currently supported:

- `http`
- `https`
- `mailto`

### Enable automatic URL validation

To enable automatic URL validation, you need to set up cron to run the `ezplatform:check-urls` command periodically.

For example, to check links every week, add the following script:

```
echo '0 0 * * 0 cd [path-to-ezplatform]; php bin/console ezplatform:check-urls --quiet --env=prod' > ezp_cron.txt
```

Next, append the new cron to user's crontab without destroying existing crons. Assuming the web server user data is www-data:

```
crontab -u www-data -l|cat - ezp_cron.txt | crontab -u www-data -
```

Finally, remove the temporary file:

```
rm ezp_cron.txt
```

### Configuration

Configuration of external URLs validation is SiteAccess-aware and is stored under `ezpublish.system.<SITEACCESS>.url_checker`.
Example configuration (in `/app/config/ezplatform.yml`):

```yml
ezpublish:
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

#### http/https protocol

| Option             | Description                                                         | Default value |
|--------------------|---------------------------------------------------------------------|---------------|
| enabled            | Enables the validation                                              | true          |
| timeout            | Maximum time the request is allowed to take (in seconds)            | 10            |
| connection_timeout | Timeout for the connect phase (in seconds)                          | 5             |
| batch_size         | Maximum number of asynchronous requests                             | 10            |
| ignore_certificate | Verify the peer's SSL certificate / certificate's name against host | false         |

#### mailto protocol

| Option             | Description                                                         | Default value |
|--------------------|---------------------------------------------------------------------|---------------|
| enabled            | Enables the validation                                              | true          |

## Custom protocol support

It's possible to extend external URLs validation with a custom protocol.
You need to provide a service implementing the `\eZ\Bundle\EzPublishCoreBundle\URLChecker\URLHandlerInterface` interface:

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

and register it with an `ezpublish.url_handler` tag. For instance:

```yaml
app.url_checker.handler.custom:
    class: 'AppBundle\URLChecker\Handler\CustomHandler'
    ...
    tags:
        - { name: ezpublish.url_handler, scheme: custom }
```

The `scheme` attribute is mandatory and has to correspond to the name of the protocol, for instance `ftp`.

## URL aliases

URL aliases are not SiteAccess-aware. When creating an alias, you can select a SiteAccess to base it on.
If the SiteAccess root path (configured in `content.tree_root.location_id`) is different than the default,
the prefix path that results from the configured content root is prepended to the final alias path.

!!! note

    Make sure that you correctly define languages used by the site in the configuration 
    (under the `ezplatform.system.<scope>.languages` key). 
    Otherwise, redirections for the renamed Content with translations in multiple
    languages may fail to work properly.

!!! warning "Known limitations"

    The [Legacy storage engine](../api/field_type_storage.md#legacy-storage-engine) does not archive URL aliases, which initially 
    had the same name in multiple languages. 
    For more information, see [the Jira ticket](https://issues.ibexa.co/browse/EZP-31818). 

## URL alias patterns

You can configure how eZ Platform generates URL aliases. The configuration is available under `ezpublish.url_alias.slug_converter`, for example:

``` yaml
ezpublish:
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

`transformation` indicates which pattern will be used by default.
The `transformation_groups` key contains the available patterns for URL generation.
There are three types of `separator` available: `dash`, `underscore` and `space`.

A transformation group consists of an array of commands (see [all available commands](https://github.com/ezsystems/ezpublish-kernel/tree/v7.5.5/eZ/Publish/Core/Persistence/Tests/TransformationProcessor/_fixtures/transformations)) and a [`cleanupMethod`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/Core/Persistence/Legacy/Content/UrlAlias/SlugConverter.php#L288).

You can make use of pre-defined transformation groups.
You can also add your own, with your own set of commands.
To add commands to an existing group, provide the group name and list the commands you want to add.

## Regenerating URL aliases

You can use the `ezplatform:urls:regenerate-aliases` command to regenerate all URL aliases.
After the command is applied, old aliases will redirect to the new ones.

Use it when:

- you change URL alias configuration and want to regenerate old aliases
- you encounter database corruption
- you have content that for whatever reason does not have a URL alias

Before applying the command, back up your database and make sure it is not modified while the command is running.

``` bash
bin/console ezplatform:urls:regenerate-aliases
```

You can also extend the command by the following parameters:

- `--iteration-count` — to define how many Locations should be processed at once to reduce memory usage
- `--location-id` — to regenerate URLs for specific Locations only, e.g. `ezplatform:urls:regenerate-aliases --location-id=1 --location-id=2`

## URL wildcards

Using the public PHP API you can set up global URL wildcards for redirections.

For example, a URL wildcard called `pictures/*/*` can use `media/images/{1}/{2}` as destination.
In this case, accessing `<yourdomain>/pictures/home/photo/` will load `<yourdomain>/media/images/home/photo/`.

URL wildcards can be created with the public PHP API with the help of the `URLWildcardService`:

``` php
$source = 'pictures/*/*';
$destination = 'media/images/{1}/{2}';
$redirect = true;

$urlWildcardService = $repository->getURLWildcardService();
$repository->sudo(function ($repository) use ($urlWildcardService, $source, $destination, $redirect) {
    $urlWildcardService->create($source, $destination, $redirect);
});
```

If `$redirect` is set to `true`, the redirection will change the URL address.
If it is `false`, the old URL address will be used, with the new content.

URL wildcards must be enabled in configuration with:

``` yaml
ezpublish:
    url_wildcards:
        enabled: true
```
