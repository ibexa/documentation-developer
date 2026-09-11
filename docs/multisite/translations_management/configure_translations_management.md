---
description: Configure translation providers, language pairs, and more for translations management.
month_change: true
---

# Configure translations management

[[= product_name =]]'s language management tools allow editors to smoothly work with content item and product translation.
By using automatic translations, editors can quickly translate fields of content items and products into another languages.

By using the [side-by-side editing interface](#side-by-side-translation-view), editors can compare source and target values, provide content item and product translations in a single view, and reject or approve translations.

!!! note "Translation limitations"

    The following limitations apply to automatic translation:
    
    - Content types that contain the `ibexa_form` or `ibexa_landing_page` fields don't support the side-by-side translation view and open in the single-language editor instead.
    - For `ibexa_landing_page` fields, translatable attributes of block content are sent to the translation provider, while layout, zones, and non-translatable block attributes are preserved. 
    - The value of `ibexa_form` field type is not translated.

    Also, [product attributes](products.md#product-attributes) remain non-translatable and are inactive in the side-by-side translation view.


## Define language pairs

Language pair definitions decide which provider handles each source-to-target language combination by default.
For example, you can decide that English to French translations should use DeepL.
When an editor [opens the translation modal]([[= user_doc =]]/content_management/translate_content/#add-new-translation) and selects a matching language combination, the provider that you chose is pre-selected in the dropdown.
The editor can override the pre-selection.

The list of languages available when creating a language pair is determined by what each provider supports.
You can only select the languages that are present in a provider's [supported list](#advanced-translation-provider-options) for that provider's pairs.

You [manage language pairs in the back office]([[= user_doc =]]/content_management/translate_content/#manage-translation-services-and-language-pairs).

## Side-by-side translation view

The [side-by-side translation view]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view) is a two-column content editing interface where the source column is read-only and the target column is an editable form.

Content types that contain the `ibexa_landing_page` or `ibexa_form` fields can't be opened in the side-by-side translation view.
Editors can open them in the standard single-language editor.


For a description of the side-by-side view and its functions from the editor's perspective, see [User Documentation]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view).

### User settings

The Translations management package adds preferences that editors can configure under their [user settings]([[= user_doc =]]/getting_started/get_started/#user-settings).
Each editor can configure them independently, and they don't affect other users.

For example, editors can choose whether the target language column appears on the left or right in the side-by-side translation view.
By default, the target is on the right, and each editor can override this default.
