---
description: Install translations management configure translation providers, language pairs, and more.
edition: lts-update
month_change: true
---

# Configure translations management

`ibexa/translations-management` extends [[= product_name =]]'s built-in language management tools that editors use for content translation.
It introduces a plugin that handles the translation provider system by connecting to REST APIs and AI services, a [side-by-side editing interface](#side-by-side-translation-view) where editors can compare source and target languages and provide translations in a single view, and multiple extension points that you can use to [customize different areas of the translation workflow](extend_translations_management.md).

The package is standalone and does not require the `ibexa/automated-translation` add-on package to run.

## Install package

The Translations management LTS Update is optional.
To enable it, run the following command:

```bash
composer require ibexa/translations-management
```

After installation, run the [[= product_name_base =]] data migrations to complete the setup:

```bash
php bin/console ibexa:migrations:import --from-bundle=IbexaTranslationsManagementBundle
php bin/console ibexa:migrations:migrate
```

This copies the migration files into the project's migrations directory and adds the default action configurations in the database.

## Configure translation providers

Translation providers are the services that perform the actual text translation.
The Translations management package comes with two types of translation providers:

- REST API-based providers call a translation service such as Google Translate or DeepL directly by using an API key.
- AI-based providers send translation requests through the [AI Actions](configure_ai_actions.md) framework, relying on the same model selection and policy controls as other AI features in [[= product_name =]].

Out of the box, Translations management can support the following translation providers:

| Provider | Type | Configuration |
|---|---|---|
| Google Translate | REST API | API key |
| DeepL | REST API | API key |
| OpenAI | AI Actions | Action Configuration identifier |
| Anthropic (Claude) | AI Actions | Action Configuration identifier |
| Google Gemini | AI Actions | Action Configuration identifier |

!!! note "Prerequisites for the default translation providers"

    Before you can configure translation providers, you must fulfill the following prerequisites:

    - For the REST API-based translation providers, add API keys that you obtain from the machine translation services to the `.env` file in the root directory of your project.

    - For the AI-based translation providers, [install and configure](configure_ai_actions.md) the `ibexa/connector-ai` package and their corresponding connectors.

**Built-in AI providers**

When you install the Translations management package, the installation process automatically creates AI [Action Configurations](extend_ai_actions.md#action-configurations) for OpenAI (`auto_translate_openai`), Google Gemini (`auto_translate_gemini`), and Anthropic Claude (`auto_translate_anthropic`).

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

!!! caution "AI policies required"

    AI-based providers require that AI policies are assigned to user roles.
    If an editor can't see AI providers in the translation provider dropdown, check if the appropriate AI policies are granted in their role definition.

If you fail to configure the providers, the Translations management feature disables itself in the editor's UI.
The **Use automatic translation** checkbox is disabled, and a message is displayed that prompts the user to contact the administrator

This state is controlled by `TranslationProviderFormFieldsConfigurator::isAutomaticTranslationDisabled()`, which returns `true` when the provider registry is empty.

### Advanced translation provider options

In addition to their required authentication keys, all providers support two optional ones:

- `supportedLanguageCodes` - overrides the default list of language codes this provider accepts
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

The configurations are persisted by `SettingService` and stored in the `ibexa_setting` database table under group `translations_management` with identifier `language_pairs`.

You can manage language pairs in [[= product_name_base =]]'s back office or programmatically.

### Manage language pairs in UI

To manage language pairs in the back office, go to **Admin** -> **Languages** -> **Language pairs** tab.
Here you can create, edit and delete language pairs.

To add a language pair, click **+ Add language pair**.
Then, pick a source language and one or more target languages from their respective drop-down lists.
Finally, from the **Translation service** list, pick a translation provider and click **Save and close**

![Creating a language pair](translations_management_language_pairs.png "Creating a language pair")

This adds as many language pairs as you picked target languages.

!!! note

    The **Add language pair** action is disabled if no translation providers are [configured](#configure-translation-providers).

    If a language pair already exists and is associated with a translation provider, you can't create another language pair with a different provider.
    Edit the existing language pair instead. 

## User settings

The Translations management package adds preferences that editors can configure under their [user settings](getting_started/get_started/#browsing).
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
However, they can still be automatically translated through the standard translation flow and the CLI command, and editors can open them in the standard single-language editor.
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

The `ibexa_auto_translation_review` [workflow](workflow.md) has two transitions:

| Transition | From | To |
|---|---|---|
| `approved` | `for_review` | `translated` |
| `rejected` | `for_review` | `for_review` (stays, event logged) |

When the editor rejects the translation, the status doesn't change, but the system records that the draft translation requires corrections.
A draft translation in `translated` state can't be rejected.

!!! note

    This workflow is separate from the [editorial workflow](workflow_management/editorial_workflow.md).
    Accepting or rejecting draft translations does not trigger editorial workflow transitions or notifications.


### Database tables

The review feature uses two tables to the database:

- `ibexa_auto_translation` — One row for each draft translation created automatically. Stores the current review status.

| Field | Type | Description |
|---|---|---|
| `id` | integer | ID of the translation draft |
| `provider_identifier` | string | Identifier of the translation provider used |
| `content_id` | integer | ID of the translated content item |
| `version_no` | integer | Version number of the draft |
| `source_language_id` | bigint | ID of the source language |
| `target_language_id` | bigint | ID of the target language |
| `review_status` | string | Current status. Possible values: `for_review` or `translated` |
| `created_at` | datetime | When the draft translation was created |
| `updated_at` | datetime | When the status was last changed |

A constraint prevents the creation of duplicate review records for the same draft translation.

- `ibexa_auto_translation_review_log` — An audit log, wit one for each status operation.

| Field | Type | Description |
|---|---|---|
| `id` | integer | ID of the operation |
| `auto_translation_id` | integer (nullable) | An `id` of the translation draft from the `ibexa_auto_translation` table, `SET NULL` on delete |
| `user_id` | integer | ID of the user who performed the operation |
| `status` | string | Status at the time of the operation |
| `operation` | string | `created`, `approved`, or `rejected` |
| `created_at` | datetime | When the operation was performed |

When an automatically translated draft is deleted, its `ibexa_auto_translation` row is removed, the review log rows remain, but their `auto_translation_id` is set to `null`.
