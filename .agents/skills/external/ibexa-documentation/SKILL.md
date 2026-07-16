---
name: ibexa-documentation
description: Find answers in the locally installed Ibexa DXP developer documentation. Use when working on an Ibexa DXP project and you need to look up how a feature, API, configuration, or extension point works.
---

# Ibexa DXP developer documentation

<!-- Placeholder skill: shipped with ibexa/documentation-developer, content to be expanded. -->

The full Ibexa DXP developer documentation is installed locally in
`vendor/ibexa/documentation-developer/`.

## Finding a topic

1. Read `vendor/ibexa/documentation-developer/llms.txt` — the table of contents
   for the whole documentation, grouped by section, with relative links into `doc/`.
2. Or search directly: `grep -ri "<topic>" vendor/ibexa/documentation-developer/doc/`.
3. Follow the relative links between pages; they all work offline.

## Conventions

- One page per directory: `doc/<section>/.../<page>/index.md`.
- PHP API references are links to the class source in `vendor/`, with the fully
  qualified class name as the link text. If the target file doesn't exist, that
  package isn't installed in this project — the class name still tells you what
  to look for.
- Prefer the documentation matching this project's installed version; this
  package is versioned together with Ibexa DXP.
