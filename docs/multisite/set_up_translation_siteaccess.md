---
description: Set up SiteAccesses to hold different language versions of a site.
---

# Set up translation SiteAccess

One of common uses for multisite installations is serving different language versions of a website.
To do this, set up multiple SiteAccesses, each corresponding to one language.
Proper configuration means avoiding duplicate content that could affect SEO.

## Add a language

First, add a new language for the whole installation.

!!! tip

    For more details, see [Languages](languages.md).

1. In the Back Office **Admin** section, click the **Languages** tab.
1. Click **Create a new language** and provide the language name and code (examples below use French with `fre-FR`).
1. After creating the new language, refresh the assets by running:

```bash
yarn encore <prod|dev>
```

## Configure SiteAccesses

Next, configure a new SiteAccess to match the newly-configured language.

The most typical setup for a site with translated content is to map the base of the domain to one language
and use the first segment of the URI to match to translations.

For example:

- `www.mysite.com` for English site
- `www.mysite.com/fr` for French site

To achieve this you need to create a new SiteAccess in the `config/packages/ibexa.yaml` file.
Add the `fr` SiteAccess to list of all SiteAccesses and it to the common `site_group`.
This group is used for sharing settings such as API keys, cache locations and so on.

``` yaml
siteaccess:
    list: [site, fr]
    groups:
        site_group: [site, fr]
```

Under the `system` key, add the new SiteAccess.
Indicate that they are meant for translations under `site_group.translation_siteaccesses`:

``` yaml
    system:
        site_group:
            # ...
            translation_siteaccesses: [fr]
        fr:
            languages: [fre-FR, eng-GB]
        site:
            languages: [eng-GB]
```

With this configuration, the main English site displays content in English and ignores French content.
The French site displays content in French, but also in English, if it does not exist in French.

Clear the cache by running: `php bin/console cache:clear`.

## Set permissions

By default, the Anonymous user Role does not have permissions for new SiteAccesses.
As a next step, allow Anonymous users to read content on the new SiteAccesses:

1. In the Back Office **Admin** section, click the **Roles** tab.
1. Click the **Anonymous** role.
1. Edit the **Limitations** of the module `user`, select both SiteAccesses and click **Update**.
1. Clear the cache by running: `php bin/console cache:clear`.

You can now start translating content.
When you reload the site, access a translated Content item through both SiteAccesses to see the difference,
for example: `<yourdomain>/<article-name>` and `<yourdomain>/fr/<article-name>`.
