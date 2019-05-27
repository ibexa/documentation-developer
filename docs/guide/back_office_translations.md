# Back Office translations

## Back Office languages

### Installing new UI translations

If you want to install a new language in your project, install the corresponding package.

For example, if you want to translate your application into French, run:

`composer require ezplatform-i18n/ezplatform-i18n-fr_fr`

and then clear the cache.

Now you can reload your eZ Platform back end which will be translated in French (if your browser is configured to `fr_FR`.)

!!! tip

    If you do not want to add a bundle with Back Office translation, you can manually add the necessary xliff files.
    Add the language to an array under `ezpublish.system.<siteaccess>.user_preferences.additional_translations`, for example:

    `ezpublish.system.<siteaccess>.user_preferences.additional_translations: ['pl_PL', 'fr_FR']`

    Then, run `composer run post-update-cmd` and clear the cache.

##### Contributing Back Office translations

To learn how to contribute to a translation, see [Contributing translations](../community_resources/translations.md).

### Choosing language of the Back Office

Once you have language packages installed, you can switch the language of the Back Office
in the User Settings menu.

Otherwise, the language will be selected based on the browser language.
If you do not have a language defined in the browser, the language will be selected
based on `parameters.locale_fallback` in `default_parameters.yml`
