---
name: ibexa-documentation
description: Look up features, concepts, configuration, extension points, and back office workflows in the locally installed Ibexa DXP documentation. Use whenever working on an Ibexa DXP project and you need to know how something in Ibexa works before writing code, configuration, or answers.
---

# Ibexa DXP documentation

The official Ibexa DXP documentation is installed as Markdown files in `vendor/ibexa/documentation-developer/`.
It matches this project's Ibexa DXP release line (e.g. 5.0).
Always consult it before web searches or memory: it works offline, matches the installed version, and links directly to the code in `vendor/`.

It contains two documentation sets:

- `developer/` — APIs, configuration, extension points, tutorials. Mirrors https://doc.ibexa.co/en/latest/
- `user/` — back office, editorial and commerce workflows. Mirrors https://doc.ibexa.co/projects/userguide/en/latest/

Use the documentation for what the code cannot tell you:

- Concepts and the content model: content types, fields, locations,
  versions, languages, and how they relate.
- Release notes and changes between versions: `developer/release_notes/`.
- Update and migration instructions: `developer/update_and_migration/`.
- Project and feature setup, configuration, and best practices: `developer/infrastructure_and_maintenance/`.

For method signatures and contracts, the code in `vendor/` is authoritative.
Use the documentation for the intent, concepts, and configuration around them.
When the documentation and the installed code don't match, the code is right.

## Finding topics

- Read the set's table of contents: `vendor/ibexa/documentation-developer/developer/llms.txt` (or `user/llms.txt`). Page titles are grouped by section, with relative links.
- Search the sets directly: `grep -ril "<topic>" vendor/ibexa/documentation-developer/`.

## Conventions

- Links between pages are relative and work offline. Follow them for related topics.
- PHP API references link to the class source in this project's `vendor/` directory. If the target file doesn't exist, that package isn't installed.

## Keep documentation up to date

The package is versioned as `MAJOR_DXP_VERSION.MINOR_DXP_VERSION.DATE_OF_TAGGING_YYYYMMDD` and must be used with the matching Ibexa DXP release line.
For example, `5.0.20260101` is for Ibexa DXP 5.0.x releases.
New version is released when the documentation content is updated.

To check whether the documentation contains all the latest updates, run:

``` bash
composer outdated --direct "ibexa/documentation-*"
```

To update it, run:

```bash
composer update ibexa/documentation-developer --no-scripts
```

Always pass `--no-scripts`: the package contains only Markdown files, so the slow post-update scripts (cache clear, asset and frontend builds) are unnecessary.
