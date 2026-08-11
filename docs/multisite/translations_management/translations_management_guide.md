---
description: Translations management helps managers, developers and localization teams with multilingual content delivery.
edition: lts-update
month_change: true
---

# Translations management product guide

## What is Translations management

Content managers, translators, and proofreaders who work with multilingual content in [[= product_name =]] often face a common set of challenges:

- context is lost when the source text isn't visible alongside the translation
- translating long and complex content items is time-consuming
- quality assurance is slow and error-prone without a direct comparison view
- switching between tools or tabs to cross-reference languages disrupts focus and slows down publishing

The Translations management package addresses these pain points through a side-by-side view, machine translation and the ability to invite reviewers to collaborate on the translation of a content items or products.

The package integrates with the [AI Actions framework](ai_actions.md) to support machine translation providers such as Google Translate and DeepL, and AI powered translation services like OpenAI, Anthropic, and Google Gemini.

Administrators can manage providers and configure default provider-to-language-pair mappings directly in [[= product_name =]]'s user interface, while editors can trigger machine translation from the content editing interface.

!!! note

    Translations management is a standalone set of features.
    Although some views are similar to those delivered by the [Automated translations](automated_translations.md) opt-in package, Translations management does not require the `ibexa/automated-translation` package to run.
    These two packages use different namespaces, service tags, and provider interfaces.

## Availability

Translations management is an [LTS Update](editions.md#lts-updates) available in all [[= product_name =]] editions.

## How it works

Before the translation flow can happen, an administrator sets up the translation providers and assigns language pairs to them.
Then, when an editor opens a content item and requests a new machine translation, the plugin resolves which provider to use.
If no language-pair rule matches, it falls back to the user's manual selection.
The plugin then extracts the translatable fields from the source language version of a content item and sends them to the configured provider's API.
The system writes the translated strings into a target-language draft of the content item, and opens it in a side-by-side view for the editor to review and refine.
The editor can save the result as a draft, share it with a reviewer or publish it.

![Translations management flow](translations_management_flow.png "Translations management flow")

## Capabilities

### Translation provider management

Administrators can manage translation providers and configure translation provider/language combination assignments ([language pairs](configure_translations_management.md#define-language-pairs)).
This allows administrators to define which provider handles which language combination.
Editors see the configured provider pre-selected when creating a new translation, but can override it if needed.

![Creating a language pair](translations_management_language_pairs.png "Creating a language pair")

The package provides integrations with several translation providers, including REST API-based services such as Google Translate and DeepL, and AI-powered services through the [AI Actions](ai_actions.md).

### Side-by-side translation view

Translations management introduces a [side-by-side translation view]([[= user_doc =]]/content_management/translate_content/#side-by-side-translation-view) that displays the read-only source language content next to an editable target language form.
In this view, editors can provide and review translations in context, without having to leave the content editing interface.

![Side-by-side translation view](managing_translations_sxs_view.png "Side-by-side translation view")

Editors can:

- access the side-by-side view when creating a new translation, reviewing an existing one, or editing a draft
- compare source and target content field by field while editing
- copy all content from the source column to the target column with a single action
- provide localized versions of media assets and their alternative text
- use the distraction-free mode for focused editing of individual fields, with AI actions available inline
- choose whether the source column appears on the left or right in user settings

!!! note "Excluded content types"

    Content types that are editable in Page builder or Form builder are excluded from side-by-side editing.

    Products are editable in the side-by-side view, but product attributes are not translatable.

### Command-line translation

The Translations management package exposes a [console command](configure_translations_management.md#translate-content-items-with-cli) for translating content items from the command line.
You can use it for batch processing or automated workflows.

### Translation review

When a draft is created by going through the automatic translation process, it is marked as "For review".
Editors can [accept or reject the translation]([[= user_doc =]]/content_management/translate_content/#review-automatic-translation) directly in the side-by-side view.
Accepted drafts are marked as "Translated".

!!! note "No review for manual translations"

    Draft translations that were created manually don't have a review status.

### Extensibility

Developers can [extend the translations management](extend_translations_management.md) package:

- create custom translation providers
- add support for custom fields
- add custom content type exclusion rules
- tap into the translation lifecycle with [events](translations_management_events.md)
