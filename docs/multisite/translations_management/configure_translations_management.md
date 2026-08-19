---
description: Install translations management and configure translation providers, language pairs, and more.
edition: lts-update
month_change: true
---

# Configure translations management

`ibexa/translations-management` extends [[= product_name =]]'s built-in language management tools that editors use for content item and product translation.
It introduces a plugin that handles automatic translations through the translation provider system by connecting to REST APIs and AI services.
By using the new [side-by-side editing interface](#side-by-side-translation-view), editors can compare source and target values, provide content item and product translations in a single view, and reject or approve translations.
Multiple extension points exist that you can use to [customize different areas of the translation workflow](extend_translations_management.md).

!!! note "Translation limitations"

    The following limitations apply to automatic translation:
    
    - Content types that contain the `ibexa_form` or `ibexa_landing_page` fields don't support the side-by-side translation view and open in the single-language editor instead.
    - For `ibexa_landing_page` fields, translatable attributes of block content are sent to the translation provider, while layout, zones, and non-translatable block attributes are preserved. 
    - The value of `ibexa_form` field type is not translated.
    
    Also, [product attributes](products.md#product-attributes) remain non-translatable and are inactive in the side-by-side translation view.

## Install package

To install the Translations management [LTS Update](editions.md#lts-updates), run the following command:

```bash
composer require ibexa/translations-management
```

If you're installing Translations management LTS Update as part of the installation process of a fresh [[= product_name =]] instance, this step copies the migration files into the project's migrations directory, creates the database tables required for the review workflow, and adds the default action configurations in the database.
Otherwise follow the steps below.

### Existing installations

To add the Translations management LTS Update to an existing [[= product_name =]] instance, after installation, you must create database tables and action configurations yourself.

#### Modify database schema

Add the tables needed by the bundle:

=== "MySQL"

    ```sql
    [[= include_code('code_samples/translations_management/install/schema.mysql.sql', indent_level=1) =]]
    ```

=== "PostgreSQL"

    ```sql
    [[= include_code('code_samples/translations_management/install/schema.postgresql.sql', indent_level=1) =]]
    ```

The script creates the required data structures, but doesn't add any data to the database.

#### Add action configurations

To complete the setup, import and run the AI Action Configuration migrations required by the [AI connectors](configure_ai_actions.md) that you use:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_06_15_00_auto_translate_openai_action_configuration.yaml
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_11_10_00_auto_translate_gemini_action_configuration.yaml
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_12_08_30_auto_translate_anthropic_action_configuration.yaml
php bin/console ibexa:migrations:migrate
```

## Configure translation providers

Translation providers are the services that perform the actual text translation.
If you fail to configure them, the automatic translation feature is disabled in the editor's UI, and a message is displayed that prompts the user to contact the administrator.

The Translations management package comes with two types of translation services:

- REST API-based providers call a translation service such as Google Translate or DeepL directly by using an API key.
- AI-based providers send translation requests through the [AI Actions](configure_ai_actions.md) framework, relying on the same model selection and policy controls as other AI features in [[= product_name =]].

!!! note "Prerequisites for the default translation providers"

    Before you can configure translation providers, you must fulfill the following prerequisites:

    - For the REST API-based translation providers, add API keys that you obtain from the machine translation services to the `.env` file in the root directory of your project.
    - For the AI-based translation providers, [configure AI Actions](configure_ai_actions.md) and configure or install and configure their corresponding connectors.

Out of the box, Translations management can support the following translation providers:

| Provider | Type |
|---|---|
| Google Translate | REST API |
| DeepL | REST API |
| OpenAI | AI Actions |
| Anthropic (Claude) | AI Actions |
| Google Gemini | AI Actions |

### Built-in AI providers

If you fulfill the above prerequisites, and you install the Translations management package, the installation process automatically creates AI [Action Configurations](extend_ai_actions.md#action-configurations) for OpenAI (`auto_translate_openai`), Google Gemini (`auto_translate_gemini`), and Anthropic Claude (`auto_translate_anthropic`).

You can use them directly in provider configuration:

| Action Configuration identifier | Handler | Default model |
|---|---|---|
| `auto_translate_openai` | `openai-text-to-text` | `gpt-5` |
| `auto_translate_gemini` | `gemini-text-to-text` | `gemini-pro-latest` |
| `auto_translate_anthropic` | `anthropic-text-to-text` | `claude-sonnet-4-20250514` |

You can then [customize these configurations in the UI]([[= user_doc =]]/ai_actions/work_with_ai_actions/#edit-existing-ai-actions).

### Add YAML configuration

In `config/packages`, create a `translations_management.yaml` file.
You configure the providers in the SiteAccess-aware `translations_management` namespace.

``` yaml
ibexa:
    system:
        default:
            translations_management:
                auto_translate:
                    providers:
                        google:
                            apiKey: '%env(GOOGLE_TRANSLATE_API_KEY)%'
                        deepl:
                            apiKey: '%env(DEEPL_API_KEY)%'
                        openai:
                            actionConfigurationIdentifier: 'auto_translate_openai'
                        anthropic:
                            actionConfigurationIdentifier: 'auto_translate_anthropic'
                        gemini:
                            actionConfigurationIdentifier: 'auto_translate_gemini'
```

The `apiKey` values must reference API key values that you added to the `.env` file.
The `actionConfigurationIdentifier` values must reference existing Action Configurations.
If a value is missing or empty, the provider doesn't appear in the UI as a selectable option.

#### Advanced translation provider options

In addition to their required authentication keys, all providers support two optional ones:

- `supportedLanguageCodes` - overrides the default list of language codes that this provider accepts
- `languageCodesMap` - maps language codes used by [[= product_name =]], for example, `eng-GB`, to the provider-specific codes the API expects

REST API-based providers come with their own language code lists and mappings, therefore both settings are optional.
If configured, they replace the built-in defaults, so use them to restrict available languages or override mappings.

AI-based providers don't provide built-in language code lists or mappings.
If `supportedLanguageCodes` is not configured, all enabled languages are used, converted to POSIX format.
If `languageCodesMap` is not configured, the system automatically tries to match [[= product_name =]] language codes to the one supported by the provider by trying different format variants, for example, `eng-GB`, `en-GB`, or `en`.
If no match is found, an `UnsupportedLanguageException` is thrown at runtime.
Therefore, for AI-based providers, it is recommended that you explicitly configure both options.

``` yaml
ibexa:
    system:
        default:
            translations_management:
                auto_translate:
                    providers:
                        # ...
                        openai:
                            actionConfigurationIdentifier: 'auto_translate_openai'
                            supportedLanguageCodes:
                                - 'eng-GB'
                                - 'ger-DE'
                                - 'fre-FR'
                            languageCodesMap:
                                eng-GB: 'en'
                                ger-DE: 'de'
                                fre-FR: 'fr'
```

The `supportedLanguageCodes` setting controls which languages are available when creating [language pairs](#define-language-pairs) for this provider.

!!! note "Identifier normalization"

    Provider identifiers are normalized from hyphens to underscores during configuration processing.
    Use one format consistently.
    If you mix `my-provider` and `my_provider` for the same provider, it results in an exception.

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

You can exclude the support for additional content types if needed.
To do it, [define custom exclusion rules](extend_translations_management.md#define-custom-exclusion-rules).

!!! note "Meta fields"

    Fields marked with [`meta: true`](content_tab_switcher.md#add-meta-tab) and fields that belong to groups listed in [`admin_ui_forms.content_edit.meta_field_groups_list`](content_tab_switcher.md#configure-field-groups-for-meta-tab) are not rendered in the side-by-side translation view.

For a description of the side-by-side view and its functions from the editor's perspective, see [User Documentation]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view).

### User settings

The Translations management package adds preferences that editors can configure under their [user settings]([[= user_doc =]]/getting_started/get_started/#user-settings).
Each editor can configure them independently, and they do not affect other users.

For example, editors can choose whether the target language column appears on the left or right in the side-by-side translation view.
By default, the target is on the right, and each editor can override this default.

You can change the system-wide default in configuration:

``` yaml
ibexa:
    system:
        default:
            translations_management:
                default_side_by_side_column_order: 'source_left_target_right'
```

The accepted values are `source_left_target_right` (default) and `source_right_target_left`.
