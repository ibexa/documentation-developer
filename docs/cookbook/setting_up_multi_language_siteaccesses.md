# Setting up multi-language SiteAccesses and corresponding translations

Combining translated content with multiple SiteAccesses successfully can be challenging for new users of eZ Platform.

To achieve this for the most typical setups you need to follow three steps:

1. [Create your translations](#create-a-new-translation) in the database via eZ Platform back office.
1. [Create at least two SiteAccesses](#create-new-siteaccesses) in `ezplatform.yml` to deliver the right translated content at the right time.
1. [Set the correct permissions](#set-permissions-for-the-new-siteaccesses) for the anonymous user to read each SiteAccess.

Without these three steps, your SiteAccess configuration will either not work or you will be left with duplicate content from an SEO perspective.

## Create a new translation

!!! tip

    Here is the full guide on [Internationalization](../guide/internationalization.md).

1. Log in to your eZ Platform back office.
1. Navigate to the Admin Panel -> Languages tab.
1. Click "Create a new language" and follow the on-screen prompts to register your new language (e.g. `fre-FR`).
1. After saving the new language, refresh the eZ Platform back-office assets: `php bin/console assetic:dump` and `yarn encore <prod|dev>` (or `php bin/console ezplatform:encore:compile`).

Reload the back office and you can now start translating content.

## Create new SiteAccesses

!!! tip

    Here is the full guide on [SiteAccesses](../guide/siteaccess.md).

The most typical setup for a site with translated content is to map the base of the domain to one language
and use the first segment of the URI to match to another. For example:
- `www.mysite.com` to match to English
- `www.mysite.com/fr` to match to French

To achieve this you need to create at least two new SiteAccesses in your `ezplatform.yml` file.

The first bit of this working example lists the new SiteAccesses `en` and `fr` and adds them both to a common group `site_group`
(this group will be used for shared settings such as API keys, cache locations, etc.).

``` yaml
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

In the second section of the SiteAccess block declare what matches to which SiteAccess.
In the example below you have two matches, the first is a simple host match: when the host is `www.mysite.com` the match is `en`.
When the host and URI both match, you hit the `fr` SiteAccess, i.e., when the URI is `/fr` and the host is `www.mysite.com`.
For a full list of available matchers see [SiteAccess Matching.](../guide/siteaccess.md#siteaccess-matching)

``` yaml
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

    For dynamic URLs you can replace `www.mysite.com` with `%site_domain%`
    and then enter `site_domain` as a new entry in `services.yml` at the same level as the database settings.

Further down in `ezplatform.yml` is the `system` section which comes with the default group named `site_group` (the same group that you modified earlier).
Add the new `translation_siteaccesses` here. After the `site_group` you register the SiteAccess languages:

``` yaml
    system:
        site_group:
            api_keys: { google_maps: yourapikey }
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

`ezplatform.yml` with SiteAccesses should now be configured. Clear to cache to complete the job:

``` bash
php bin/console cache:clear
```

## Set permissions for the new SiteAccesses

Now allow the Anonymous user Role to read content on the new SiteAccesses:

1. Log in to the eZ Platform back office.
1. Navigate to Admin Panel -> Roles.
1. Click the role `Anonymous`.
1. Edit the limitations of the module `user`.
1. You should be able to see three SiteAccesses in a multi-select, select them all and press save.
1. Clear the cache once more and you should now be able to reload your site in the `en` and `fr` SiteAccess.

## Replace the `site` SiteAccess

eZ Platform ships with a premade SiteAccess named `site`. As you have now successfully introduced two new SiteAccesses,
you can remove the `site` SiteAccess as it is no longer required.
It was not possible to remove `site` before, as you first needed to give the appropriate permissions to the new SiteAccesses (`en` and `fr`),
without which your site would not have loaded correctly.

In `ezplatform.yml` set the `default_siteaccess` to `en`,
this will act as the [fallback](../guide/siteaccess/#multilanguage-sites) should none of the matches have been hit.
Last but not least, remove `site` from the `list` and `groups` section:

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

Clear the cache again:

``` bash
php bin/console cache:clear
```

You should now be able to load your eZ Platform site in the `en` and `fr` SiteAccess displaying English and French content.
