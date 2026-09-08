---
description: Set up rules for validating Page block content.
---

# Page block validators

Validators check values passed to Page block attributes.
The following block validators are available:

- `required` - checks whether the attribute is provided
- `regexp` - validates attribute according to the provided regular expression
- `not_blank` - checks whether the attribute isn't left empty
- `not_blank_richtext` - checks whether a `richtext` attribute isn't left empty
- `content_type` - checks whether the selected content types match the provided values
- `content_container` - checks whether the selected content item is a container

!!! note

    Don't use the `required` and `not_blank` validators for `richtext` attributes.
    Instead, use `not_blank_richtext`.

For each validator you can provide a message that displays in the Page Builder when an attribute field doesn't fulfill the criteria.

Additionally, for some validators you can provide settings under the
`ibexa_fieldtype_page.blocks.<block_name>.validators.regexp.options` [configuration key](configuration.md#configuration-files), for example:

``` yaml
email:
    type: string
    name: E-mail address
    validators:
        regexp:
            options:
                pattern: '/^\S+@\S+\.\S+$/'
            message: Provide a valid e-mail address
```
