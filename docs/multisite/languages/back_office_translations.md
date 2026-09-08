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

## Custom string translations

When you extend the back office you often need to provide labels for new elements.
It's good practice to provide your labels in translations files, instead of literally, so they can be reused and translated into other languages.

To provide label strings, make use of the `Symfony\Component\Translation\TranslatorInterface` and its `trans()` method.

The method takes the message `id`, an array of parameters, and the string's domain as arguments.

The strings are provided in .xliff files.
The file should be stored in your project's or your bundle's `Resources/translations` folder.

File name corresponds to the selected domain and the language, for example, `custom_extension.en.xliff`.

``` xml
<?xml version="1.0" encoding="utf-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" xmlns:jms="urn:jms:translation" version="1.2">
    <file source-language="en" target-language="en" datatype="plaintext" original="not.available">
        <header>
            <tool tool-id="JMSTranslationBundle" tool-name="JMSTranslationBundle" tool-version="1.1.0-DEV"/>
            <note>The source node in most cases contains the sample message as written by the developer. If it looks like a dot-delimitted string such as "form.label.firstname", then the developer has not provided a default message.</note>
        </header>
        <body>
            <trans-unit id="1ea2690f8ebd8fc946f92cf94ac56b8b93e46afe" resname="custom.extension.description">
                <source>My custom label</source>
                <target state="new">My custom label</target>
                <note>key: custom.extension.description</note>
            </trans-unit>
        </body>
    </file>
</xliff>
```

To provide a translation into another language, add it in the `<target>` tag.
For example, in `custom_extension.de.xliff`:

``` xml
<trans-unit id="1ea2690f8ebd8fc946f92cf94ac56b8b93e46afe" resname="custom.extension.description">
    <source>My custom label</source>
    <target state="new">Meine benutzerdefinierte Bezeichnung</target>
    <note>key: custom.extension.description</note>
</trans-unit>
```

The language to display is then selected automatically based on [user preferences or browser setup](#selecting-back-office-language).
