---
name: ibexa-documentation
description: Find answers in the locally installed Ibexa DXP documentation (developer and user docs). Use when working on an Ibexa DXP project and you need to look up how a feature, API, configuration, extension point, or back-office workflow works.
---

# Ibexa DXP documentation

<!-- Placeholder skill: shipped with ibexa/documentation-developer, content to be expanded. -->

The full Ibexa DXP documentation is installed locally in
`vendor/ibexa/documentation-developer/`:

- `developer/` — developer documentation: APIs, extension points,
  configuration, tutorials.
- `user/` — user documentation: back office, content management, commerce
  workflows.

## Finding a topic

1. Read the set's table of contents:
   `vendor/ibexa/documentation-developer/developer/llms.txt` or
   `vendor/ibexa/documentation-developer/user/llms.txt` — grouped by section,
   with relative links.
2. Or search directly:
   `grep -ri "<topic>" vendor/ibexa/documentation-developer/developer/`.
3. Follow the relative links between pages (including cross-links between the
   developer and user docs); they all work offline.

## Conventions

- One page per directory: `<set>/<section>/.../<page>/index.md`.
- PHP API references are links to the class source in `vendor/`, with the fully
  qualified class name as the link text. If the target file doesn't exist, that
  package isn't installed in this project — the class name still tells you what
  to look for.
- Prefer the documentation matching this project's installed version; this
  package is versioned together with Ibexa DXP.
