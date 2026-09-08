---
description: CustomField Sort Clause
---

# CustomField Sort Clause

The `CustomField` Sort Clause sorts search results by raw search index fields.

## Arguments

- `field` - string representing the search index field name
[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `CustomField` Sort Clause in production code.
    Valid use cases are: testing, or temporary (one-off) tools.
