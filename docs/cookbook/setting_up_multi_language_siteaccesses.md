# Setting up multi-language SiteAccesses and corresponding translations

## Description

Combining translated content with multiple SiteAccesses successfully can be a little tricky to get your head around when you are new to eZ Platform.

To successfully achieve this for the most typical setups you will need to do all 3 following items:

1. Register your translations in the database via the eZ Platform admin.
1. Create at least two SiteAccesses to deliver the right translated content at the right time in `ezplatform.yml`.
1. Set the correct permissions for the anonymous user to read each SiteAccess.

Without these 3 steps, your SiteAccess configuration will either not work or you will be left with duplicate content from an SEO perspective.

## 1. Create your new translation

Here is the full guide on [Internationalization](../guide/internationalization.md).

1. Log into your eZ Platform admin.
1. Navigate to the Admin Panel -> Languages tab.
1. Click "Create a new language" and follow the on-screen prompts to register your new language (e.g. `fre-FR`).
1. After saving the new language, refresh the eZ Platform admin assets: `php app/console assetic:dump`.

That's it! Reload the admin and you can now start translating content.

## 2. Creating the new SiteAccesses

Here is the full guide on [SiteAccess](../guide/siteaccess.md).

The most typical setup for a site with translated content is to map the base of the domain to one language and use the first segment of the URI to match to another. For example:
- www.mysite.com to match to English
- www.mysite.com/fr to match to French

To achieve this you will need to create at least two new SiteAccesses in your `ezplatform.yml` file.

The first bit of this working example lists the new SiteAccesses `en` and `fr` and adds them both to a common group `site_group` (this group will be used for shared settings such as API keys, cache locations, etc.).

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

In the second section of the SiteAccess block declare what matches to which SiteAccess. In the example below you have two matches, the first is a simple host match: when the host is `www.mysite.com` the match is `en`. When the host and URI both match, you hit the `fr` SiteAccess, i.e., when the URI is `/fr` and the host is `www.mysite.com`. For a full list of available matchers see [SiteAccess Matching.](../guide/siteaccess.md#siteaccess-matching)

```
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

    For dynamic URLs you can replace `www.mysite.com` with `'%site_domain%'` and then enter `site_domain` as a new entry in the `parameters.yml` at the same level as the database settings.

Further down the `ezplatform.yml` is the system section which comes with the default group named `site_group` (the same one we added to earlier). Add our new `translation_siteaccesses`. After the `site_group` we register the SiteAccess languages:

```
    system:
        site_group:
            api_keys: { google_maps: "yourapikey" }
            cache_pool_name: '%cache_pool%'
            var_dir: var/site
            translation_siteaccesses: [fr, en]
        fr:
            languages: [fre-FR, eng-GB]
        en:
            languages: [eng-GB]
        default:
            content:
                ... tpl override common to both the en and fr siteaccess
```

That's it! `ezplatform.yml` with SiteAccesses should now be configured. Clear to cache to complete the job:

```
php app/console cache:clear
```

## 3. Setting the permissions for the new `fr` and `en` SiteAccesses

We now allow the user role Anonymous to read content on the new SiteAccesses:

1. Log in to the eZ Platform admin.
1. Navigate to Admin Panel -> Roles.
1. Click the role `Anonymous`.
1. Edit the limitations of the module `user`.
1. You should be able to see 3 SiteAccesses in a multi-select, select them all and press save.
1. Clear the cache once more and you should now be able to reload your site in the `en` and `fr` SiteAccess.

## 4. Remove the SiteAccess `site` and set the default to `en`

eZ Platform ships with a premade SiteAccess named `site`. As you have now successfully introduced 2 new SiteAccesses, you can remove the `site` SiteAccess as it is no longer required. It was not possible to remove `site` before, as you first needed to give the appropriate permissions to the new SiteAccesses (`en` and `fr`), without which your site would not have loaded correctly.

In `ezplatform.yml` set the `default_siteaccess` to `en`, this will act as the [fallback](../guide/siteaccess/#use-case-multilanguage-sites) should none of the matches have been hit. Last but not least, remove `site` from the `list` and `groups` section:

```
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

```
php app/console cache:clear
```

## Conclusion

If you followed all 4 steps you should now be able to load your eZ Platform site in the `en` and `fr` SiteAccess displaying English and French content.
