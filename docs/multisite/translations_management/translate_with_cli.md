---
description: Use CLI command to translate content items.
edition: lts-update
month_change: true
---

# Translate content items with CLI

For the purposes of batch processing, automation and other scripted actions, the [Translations management](translations_management_guide.md) package exposes a command that automatically translates content items or products by using any of the configured providers:

``` bash
php bin/console ibexa:translations:auto-translate-content \
    --content-id=42 \
    --provider=deepl \
    --from=eng-GB \
    --to=fre-FR
```

!!! tip "Command alias"

    You can use `ibexa:translations:translate-content` as an alias.

The command uses the same provider configuration and field value transformers as the UI.
Therefore, depending on the specific command options used, the result can be the same as if an editor [triggered the automated translation manually]([[= user_doc =]]/content_management/translate_content/#add-new-translation).

With the default settings, the most important difference is that a translation generated with a CLI command is instantly published, while a manual one requires that a human publishes it.

### CLI command options

| Option | Required | Description |
|---|---|---|
| `--content-id` | Yes | ID of the content item or product to translate |
| `--provider` | Yes | Identifier of the translation provider to use |
| `--from` | Yes | Source language code |
| `--to` | Yes | Target language code |
| `--user-id` | No | Repository user ID to run the translation (default: `14`, which is the Administrator user) |
| `--draft-only` | No | Create a translated draft without publishing it |
