---
description: Set up rules for validating Page block content.
---

# Page block validators

Validators check values passed to Page block attributes.
The following block validators are available:

- `required` - checks whether the attribute is provided
- `regexp` - validates attribute according to the provided regular expression
- `not_blank` - checks whether the attribute is not left empty
- `content_type` - checks whether the selected Content Types match the provided values
- `content_container` - checks whether the selected Content item is a container

For each validator you can provide a message that displays in the Page Builder
when an attribute field does not fulfil the criteria.

Additionally, for some validators you can provide settings in the `options` key, for example:

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

The following example shows how to create a validator which requires that string attributes contain only alphanumerical characters.

First, create classes that support your intended method of validation.
For example, in `src/Validator`, create an `AlphaOnly.php` file:

``` php
[[= include_file('code_samples/page/custom_block_validator/src/Validator/AlphaOnly.php') =]]
```

In `src/Validator`, create an `AlphaOnlyValidator.php` class that performs the validation.

``` php
[[= include_file('code_samples/page/custom_block_validator/src/Validator/AlphaOnlyValidator.php') =]]
```

Then, in `config/packages/ibexa_page_fieldtype.yaml` enable the new validator in Page Builder:

``` yaml
[[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 0, 3) =]]
```

Finally, add the validator to one of your block attributes in `config/packages/ibexam_page_fieldtype.yaml`, for example:

``` yaml hl_lines="16-18"
[[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 0, 1) =]][[= include_file('code_samples/page/custom_block_validator/config/packages/page_blocks.yaml', 3, 20) =]]
```
