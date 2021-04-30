# Multi-language SiteAccesses

To combine translated content with multiple SiteAccesses, perform the following steps:

1. [Create your translations](#create-a-new-translation) in the database by using the Back Office.
1. [Create at least two SiteAccesses](#create-new-siteaccesses) in `ezplatform.yml` to deliver the right translated content at the right time.
1. [Set the correct permissions](#set-permissions-for-the-new-siteaccesses) for an anonymous user to read each SiteAccess.

Without these three steps, your SiteAccess configuration will either not work or you will be left with duplicate content from an SEO perspective.

## Create a new translation

By creating a new translation, you indicate that a Content item has other language versions.
A newly defined translation can then be used according to the SiteAccess configuration.
For more details on language versions, see [Languages](internationalization.md).

1. Log in to the Back Office.
1. In the **Admin** Panel, open the **Languages** tab.
1. Click **Create a new language** and follow the on-screen prompts. For the purpose of this procedure, configure `fre-FR` as a new language.
1. After saving the new language, refresh the assets by running:
 
``` bash
php bin/console assetic:dump
yarn encore <prod|dev>
#OR
php bin/console ezplatform:encore:compile
```

Reload the Back Office.
Now you can now start translating content.

## Create new SiteAccesses

Now you can configure SiteAccess to match it with the newly-configured translation.
For more details, see [SiteAccess](siteaccess.md).

The most typical setup for a site with translated content is to map the base of the domain to one language
and use the first segment of the URI to match to another. 

For example:

- `www.mysite.com` to match to English
- `www.mysite.com/fr` to match to French

To achieve this, you need to create at least two new SiteAccesses in your `ezplatform.yml` file.

The first bit of this working example lists the new SiteAccesses: `en` and `fr` and adds them both to a common `site_group` (line 8).
This group will be used for sharing settings such as API keys, cache locations, etc.

``` yaml hl_lines="8"
siteaccess:
    default_siteaccess: site
    list:
        - site
        - en
        - fr
    groups:
        site_group:
            - site
            - en
            - fr
```

Below, in the second section of the SiteAccess block, you declare what matches to which SiteAccess.
In the example below you have two matches. 
The simplest is ` Map\Host` — when the host is `www.mysite.com`, the match is `en` (lines 11-12).
When the host and URI both match, you hit the `fr` SiteAccess, i.e., when the URI is `/fr` and the host is `www.mysite.com`.
For a full list of available matchers, see [SiteAccess matching](../guide/siteaccess_matching.md).

``` yaml hl_lines="11 12"
siteaccess:
    default_siteaccess: site
        # ...
    match:
        Compound\LogicalAnd:
            frLogicalAndMatch:
                matchers:
                    Map\URI: { fr: true }
                    Map\Host: { www.mysite.com: true }
                match: fr
        Map\Host:
            www.mysite.com: en
```

!!! note

    For dynamic URLs, you can replace `www.mysite.com` with `%site_domain%`
    and then enter `site_domain` as a new entry in `parameters.yml` at the same level as the database settings.

Further down in `ezplatform.yml` is the `system` section which comes with the default group named `site_group` (the same group that you modified earlier).
Add the new `translation_siteaccesses` here. After the `site_group`, you register the SiteAccess languages:

``` yaml
    system:
        site_group:
            cache_pool_name: '%cache_pool%'
            var_dir: var/site
            translation_siteaccesses: [fr, en]
        fr:
            languages: [fre-FR, eng-GB]
        en:
            languages: [eng-GB]
        default:
            content:
                # templates common to both the en and fr SiteAccess
```

The `ezplatform.yml` file with SiteAccesses should now be configured.
Clear to cache by running: `php bin/console cache:clear`.

## Set permissions for the new SiteAccesses

Now allow the Anonymous user Role to read content on the new SiteAccesses:

1. Log in to the Back Office.
1. In the **Admin** Panel, open the **Roles** tab.
1. Click the **Anonymous** role.
1. Edit the limitations of the module `user`.
1. You should be able to see three SiteAccesses in a multi-select. Select them all and click **Save**.
1. Clear the cache by running: `php bin/console cache:clear`. 

You should now be able to reload your site in the `en` and `fr` SiteAccess.

## Replace the `site` SiteAccess

eZ Platform ships with a pre-configured SiteAccess named `site`. As you have now successfully introduced two new SiteAccesses,
you can remove the `site` SiteAccess as it is no longer required.
It was not possible to remove `site` before, as you first needed to give the appropriate permissions to the new SiteAccesses (`en` and `fr`),
without which your site would not have loaded correctly.

In `ezplatform.yml`, set the `default_siteaccess` to `en`.
This will act as the [fallback](siteaccess.md#multilanguage-sites) in case none of the matches have been hit.

Lastly, remove `site` from the `list` and `groups` section.
The final version of the `ezplatform.yml` should look like this:

``` yaml
siteaccess:
    default_siteaccess: en
    list:
        - en
        - fr
    groups:
        site_group:
            - en
            - fr
```

Clear the cache by running: `php bin/console cache:clear`.

Now you should be able to load your eZ Platform site using the `en` and `fr` SiteAccess to display content in English and French.

!!! tip
    
    If you encounter issues when configuring SiteAccess or want to check that system uses the correct value, use the following command:
    
    `bin/console [—-siteaccess=<SA>] ezplatform:debug:config-resolver <param.name>`
