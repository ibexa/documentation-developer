---
description: Install translations management configure translation providers, language pairs, and more.
edition: lts-update
month_change: true
---

# Configure translations management

`ibexa/translations-management` extends [[= product_name =]]'s built-in language management tools that editors use for content item and product translation.
It introduces a plugin that handles automatic translations through the translation provider system by connecting to REST APIs and AI services, a [side-by-side editing interface](#side-by-side-translation-view) where editors can compare source and target, provide content item and product translations in a single view, and reject or approve translations, and multiple extension points that you can use to [customize different areas of the translation workflow](extend_translations_management.md).

!!! note "Automatic translation limitations"

    Content types that contain the `ibexa_form` or `ibexa_landing_page` fields do not support the side-by-side translation view and open in the single-language editor instead.
    When a content type that uses `ibexa_landing_page` is automatically translated, only the page's title and description are translated.
    When a content type that uses `ibexa_form` is automatically translated, only the forms's title is translated.
    
    Also, [product attributes](products.md#product-attributes) are not translatable.

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
    [[= include_file('code_samples/translations_management/install/schema.mysql.sql', 0, None, '    ') =]]
    ```

=== "PostgreSQL"

    ```sql
    [[= include_file('code_samples/translations_management/install/schema.postgresql.sql', 0, None, '    ') =]]
    ```

The script creates the required data structures, but doesn't add any data to the database.

#### Add action configurations

Import and run the AI Action Configuration migrations to complete the setup:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_06_15_00_auto_translate_openai_action_configuration.yaml
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_11_10_00_auto_translate_gemini_action_configuration.yaml
php bin/console ibexa:migrations:import vendor/ibexa/translations-management/src/bundle/Resources/migrations/2026_05_12_08_30_auto_translate_anthropic_action_configuration.yaml
php bin/console ibexa:migrations:migrate
```

## Configure translation providers

Translation providers are the services that perform the actual text translation.
    If you fail to configure them, the automatic translation feature is disabled in the editor's UI, and a message is displayed that prompts the user to contact the administrator

The Translations management package comes with two types of translation services:

- REST API-based providers call a translation service such as Google Translate or DeepL directly by using an API key.
- AI-based providers send translation requests through the [AI Actions](configure_ai_actions.md) framework, relying on the same model selection and policy controls as other AI features in [[= product_name =]].

!!! note "Prerequisites for the default translation providers"

    Before you can configure translation providers, you must fulfill the following prerequisites:

    - For the REST API-based translation providers, add API keys that you obtain from the machine translation services to the `.env` file in the root directory of your project.

    - For the AI-based translation providers, [install and configure](configure_ai_actions.md) the `ibexa/connector-ai` package and their corresponding connectors.

Out of the box, Translations management can support the following translation providers:

| Provider | Type |
|---|---|---|
| Google Translate | REST API |
| DeepL | REST API |
| OpenAI | AI Actions |
| Anthropic (Claude) | AI Actions |
| Google Gemini | AI Actions |

**Built-in AI providers**

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

## User settings

The Translations management package adds preferences that editors can configure under their [user settings]([[= user_doc =]]/getting_started/get_started/#user-settings).
Each editor can configure them independently, and they do not affect other users.

For example, editors can choose whether the target language column appears on the left or right in the side-by-side view.
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

## Side-by-side translation view

The [side-by-side translation view]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view) is a two-column content editing interface where the source column is read-only and the target column is an editable form.

Content types that contain the `ibexa_landing_page` or `ibexa_form` fields can't be opened in the side-by-side translation view.
Editors can open them in the standard single-language editor.

You can exclude the support for additional content types if needed.
To do it, [define custom exclusion rules](extend_translations_management.md#define-custom-exclusion-rules).

### Architecture

The side-by-side view consists of three forms placed in a single Twig template:

- `view.sourcePreviewForm` — the source language content, rendered as read-only fields
- `view.form` — the target language content, rendered as editable fields
- `view.copyAllForm` — the **Copy all from source** action

To assemble the view, `SideBySideEditContextBuilder` performs the following actions:

1. Resolves source and target languages
2. Loads the correct content version
3. Groups fields by their content type field groups

!!! note "Meta fields"

    The builder excludes the fields that are marked marked as `meta: true` or belong to a field group that is listed in `admin_ui_forms.content_edit.meta_field_groups_list`, and does not render them.

To resolve the column order, `SideBySideTargetLanguagePositionResolver` reads the user setting and falls back to `source_left_target_right` when the setting is not made.
The Twig template applies `order-xl-*` classes for responsive column placement.

### Side-by-side view behavior

Editors have multiple ways to arrive at the side-by-side translation view, for example:

- From the **Create a new translation** modal, by clicking the **Open side-by-side** action.
    This submits the modal to the `ibexa.translations_management.side_by_side_create` route, which creates a new draft and redirects to `side_by_side_view` with the resolved `versionNo`.

- From the **Versions** tab, by clicking the **Edit side-by-side** action next to a draft whose source and target languages differ.
    This doesn't create a new draft, and the existing version number is used.

!!! tip "Routes"

    The Translations management package registers internal back office routes.
    To list them with their current paths, run:

    ``` bash
    php bin/console debug:router | grep translations_management
    ```

### Side-by-side view functions

The side-by-side translation view has several functions, including:

- Copy all from source

When an editor clicks the **Copy all from source** action, all translatable field values are copied from the source to target column.
It's a single server-side operation handled by `SideBySideFieldCopyService::copyAllFields()` after which the view is reloaded.

- Draft conflict warning

When an user opens the translation modal and selects a target language which already has a draft translation, a warning appears in the modal.
The warning is shown or hidden dynamically by `add.translation.modal.warning.js` when the user changes the target language selection.

For a description of the side-by-side view and its functions from the user's perspective, see [Translate content](([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view).

## Translate content items with CLI

For the purposes of batch processing, automation and other scripted actions, the Translations management package exposes a command that translates content items by using any of the configured providers:

``` bash
php bin/console ibexa:translations:auto-translate-content \
    --content-id=42 \
    --provider=deepl \
    --from=eng-GB \
    --to=fre-FR
```

!!! tip "Command alias"

    You can use `ibexa:translations:translate-content` as an alias.

The command uses the same provider configuration and field value transformers as the UI, so the results are the same if an editor triggered the translation manually.

### CLI command options

| Option | Required | Description |
|---|---|---|
| `--content-id` | Yes | ID of the content item to translate |
| `--provider` | Yes | Identifier of the translation provider to use |
| `--from` | Yes | Source language code |
| `--to` | Yes | Target language code |
| `--user-id` | No | Repository user ID to run the translation (default: `14`, which is the Administrator user) |
| `--draft-only` | No | Create a translated draft without publishing it |

## Translation review

When a draft translation of a content item or product is created by going through the automatic translation process, the system creates a review status record and marks the draft `for_review`.
This way editors and reviewers can check whether automatically translated drafts have been checked before publishing.

Automatically translated drafts can have one of the following two states:
- `for_review` - The draft was machine-translated and is awaiting review.
- `translated` - The translation has been accepted by a reviewer.

The `ibexa_auto_translation_review` workflow has two transitions:

| Transition | From | To |
|---|---|---|
| `approved` | `for_review` | `translated` |
| `rejected` | `for_review` | `for_review` |

When the editor rejects the translation, the status doesn't change, but the system records that the draft translation requires corrections.
A draft translation in `translated` state can't be rejected.

!!! note

    This workflow is separate from the [editorial workflow](workflow.md).
    Accepting or rejecting draft translations does not trigger editorial workflow transitions or notifications.
