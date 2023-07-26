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
- `content_type` - checks whether the selected Content Types match the provided values
- `content_container` - checks whether the selected Content item is a container

!!! note

    Do not use the `required` and `not_blank` validators for `richtext` attributes.
    Instead, use `not_blank_richtext`.

For each validator you can provide a message that displays in the Page Builder
when an attribute field doesn't fulfil the criteria.

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

## Custom validators

You can create Page block attributes with custom validators.

The following example shows how to create a validator which requires that string attributes contain only alphanumeric characters.

First, create classes that support your intended method of validation.
For example, in `src/Validator`, create an `AlphaOnly.php` file:

``` php
[[= include_file('code_samples/page/custom_block_validator/src/Validator/AlphaOnly.php') =]]
```

In `src/Validator`, create an `AlphaOnlyValidator.php` class that performs the validation.

``` php
[[= include_file('code_samples/page/custom_block_validator/src/Validator/AlphaOnlyValidator.php') =]]
```

Then, under `ibexa_fieldtype_page.block_validators`, enable the new validator in Page Builder:

``` yaml
[[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 0, 3) =]]
```

Finally, add the validator to one of your block attributes, for example:

``` yaml hl_lines="16-18"
[[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 0, 1) =]][[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 3, 20) =]]
```
