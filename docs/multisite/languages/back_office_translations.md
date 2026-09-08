---
description: The language of the back office is selected automatically based on browser language, or you can choose it manually in user settings.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Additional back office translations are added to a SiteAccess-scoped user
    preferences key. Confirm how that per-SiteAccess list is set once SiteAccess
    configuration moves to a UI.

    Links to the deleted contribute_translations.md page were removed; check that the
    surrounding text still reads correctly.
---

# Back office translations

## Enabling back office languages

All translations are available as a part of [[= product_name =]].
To enable back office translations, use the following configuration:

``` yaml
ibexa:
    ui:
        translations:
            enabled: true
```

Now you can reload your [[= product_name =]] back office.
If your browser language is set to French, the back office is displayed in French.

!!! tip "Checking browser language"

    To make sure that a language is set in your browser, check if it's sent as an accepted language in the `Accept-Language` header.

!!! tip

    You can also manually add the necessary .xliff files to an existing project.

    Add the language to an array under `ibexa.system.<siteaccess>.user_preferences.additional_translations`, for example:

    `ibexa.system.<siteaccess>.user_preferences.additional_translations: ['pl_PL', 'fr_FR']`

### Selecting back office language

Once you have language packages enabled, you can switch the language of the back office in the **User Settings** menu.

Otherwise, the language is selected based on the browser language.
If you don't have a language defined in the browser, the language is selected based on `parameters.locale_fallback` in `config/packages/ibexa.yaml`.
