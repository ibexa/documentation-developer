---
description: You can create multiple language versions (translations) of content and serve different language versions of your site with the help of SiteAccesses.
---

# Languages

## Language versions

[[= product_name =]] offers the ability to create multiple language versions (translations) of a Content item.
Translations are created per version of the item, so each version of the content can have a different set of translations.

A version always has at least one translation which by default is the *initial/main* translation. Further versions can be added, but only for languages that have previously been [added to the global translation list](#adding-available-languages), that is a list of all languages available in the system. The maximum number of languages in the system is 62.

Different translations of the same Content item can be edited separately. This means that different users can work on translations into different languages at the same time.

Each version, including a draft, contains all the existing translations.
However, even if work on a draft takes time and other translations are updated in the meantime,
publishing the draft will not overwrite later modifications.

### Adding available languages

The multilanguage system operates based on a global translation list that contains all languages available in the installation. Languages can be [added to this list from the Admin Panel](https://doc.ibexa.co/projects/userguide/en/latest/translating_content/) in the Back Office. After adding a language be sure to dump all assets to the file system:

```
yarn encore <environment>
# OR php bin/console ibexa:encore:compile
```

**The new language must then be added to the [SiteAccess](multisite.md) configuration**. Once this is done, any user with proper permissions can create Content item versions in these languages in the user interface.

### Translatable and untranslatable Fields

Language versions consist of translated values of the Content item's Fields. In the Content Type definition every Field is set to be Translatable or not.

[[= product_name =]] does not decide by itself which Fields can be translated and which cannot. For some Field values the need for a translation can be obvious, for example for the body of an article. In other cases, for instance images without text, integer numbers or e-mail addresses, translation is usually unnecessary. Despite that, [[= product_name =]] gives you the possibility to mark any Field as translatable regardless of its Field Type. It is only your decision to exclude the translation possibility for those Fields where it makes no sense.

When a Field is not flagged as Translatable, its value will be copied from the initial/main translation when a new language version is created. This copied value cannot be modified. When a Field is Translatable, you will have to enter its value in a new language version manually.

For example, let's say that you need to store information about marathon contestants and their results. You build a "contestant" Content Type using the following Fields: name, photo, age, nationality, finish time. Allowing the translation of anything other than nationality would be pointless, since the values stored by the other Fields are the same regardless of the language used to describe the contestant. In other words, the name, photo, age and finish time would be the same in, for example, both English and Norwegian.

### Access control

You can control whether a User or User Group is able to translate content or not. You do this by adding a [Language Limitation](limitation_reference.md#language-limitation) to Policies that allow creating or editing content. This Limitation enables you to define which Role can work with which languages in the system. (For more information of the permissions system, see [Permissions](permissions.md).)

In addition, you can also control the access to the global translation list by using the Content/Translations Policy. This Policy allows users to add and remove languages from the global translation list.

## Using SiteAccesses for handling translations

If you want to have completely separate versions of the website, each with content in its own language,
you can [use SiteAccesses](#using-siteaccesses-for-handling-translations).
Depending on the URI used to access the website, a different site will open, with a language set in configuration settings.
All Content items will then be displayed in this language.

For details, see [Multi-language SiteAccesses](set_up_translation_siteaccess.md).

### Explicit translation SiteAccesses

Configuration is not mandatory, but can help to distinguish which SiteAccesses can be considered translation SiteAccesses.

``` yaml
ibexa:
    siteaccess:
        default_siteaccess: eng
        list:
            - site
            - eng
            - fre
            - site_admin

        groups:
            frontend_group:
                - site
                - eng
                - fre

    # ...

    system:
        # Specifying which SiteAccesses are used for translation
        frontend_group:
            translation_siteaccesses: [fre, eng]
        eng:
            languages: [eng-GB]
        fre:
            languages: [fre-FR, eng-GB]
        site:
            languages: [eng-GB]
```

!!! note

    The top prioritized language is always used the SiteAccess language reference (e.g. `fre-FR` for `fre` SiteAccess in the example above).

If several translation SiteAccesses share the same language reference, **the first declared SiteAccess always applies**.

#### Custom locale configuration

If you need to use a custom locale, you can configure it in `ibexa.yaml`, adding it to the *conversion map*:

``` yaml
ibexa:
    # Locale conversion map between eZ Publish format (e.g. fre-FR) to POSIX (e.g. fr_FR).
    # The key is the eZ Publish locale. Check locale.yaml in IbexaCore to see natively supported locales.
    locale_conversion:
        eng-DE: en_DE
```

A locale *conversion map* example [can be found in `ibexa/core`, in `locale.yaml`](https://github.com/ibexa/core/blob/main/src/bundle/Core/Resources/config/locale.yml).

### More complex translation setup

There are some cases where your SiteAccesses share settings (Repository, content settings, etc.), but you don't want all of them to share the same `translation_siteaccesses` setting. This can be for example the case when you use separate SiteAccesses for mobile versions of a website.

The solution is defining new groups:

``` yaml
ibexa:
    siteaccess:
        default_siteaccess: eng
        list:
            - site
            - eng
            - fre
            - mobile_eng
            - mobile_fre
            - site_admin

        groups:
            # This group can be used for common front settings
            common_group:
                - site
                - eng
                - fre
                - mobile_eng
                - mobile_fre

            frontend_group:
                - site
                - eng
                - fre

            mobile_group:
                - mobile_eng
                - mobile_fre

    # ...

    system:
        # Translation SiteAccesses for regular frontend
        frontend_group:
            translation_siteaccesses: [fre, eng]

        # Translation SiteAccesses for mobile frontend
        mobile_group:
            translation_siteaccesses: [mobile_fre, mobile_eng]

        eng:
            languages: [eng-GB]
        fre:
            languages: [fre-FR, eng-GB]
        site:
            languages: [eng-GB]

        mobile_eng:
            languages: [eng-GB]
        mobile_fre:
            languages: [fre-FR, eng-GB]
```

### Using implicit *related SiteAccesses*

If the `translation_siteaccesses` setting is not provided, implicit *related SiteAccesses* will be used instead. SiteAccesses are considered *related* if they share:

- The same Repository
- The same root `location_id` (see [Multisite](multisite.md))

### Fallback languages and missing translations

When setting up SiteAccesses with different language versions, you can specify a list of preset languages for each SiteAccess. When this SiteAccess is used, the system will go through this list. If a Content item is unavailable in the first (prioritized) language, it will attempt to use the next language in the list, and so on. Thanks to this you can have a fallback in case of a lacking translation.

You can also assign a Default content availability flag to Content Types (available in the Admin Panel). When this flag is assigned, Content items of this type will be available even when they do not have a language version in any of the languages configured for the current SiteAccess.

Note that if a language is not provided in the list of prioritized languages and it is not the Content item's first language, the URL alias for this content in this language will not be generated.
