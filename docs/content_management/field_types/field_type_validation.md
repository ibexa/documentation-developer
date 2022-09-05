---
description: Field Type validation allows you to validate if data entered stored in the Field conforms to the schema.
---

# Field Type validation

## Validator schema

The schema for validator configuration should have a similar format to the [settings schema](type_and_value.md#field-type-settings),
except it has an additional level, to group settings for a certain validation mechanism:

- The key on the 1st level is a string, identifying a validator
- Assigned to that is an associative array (2nd level) of settings
- This associative array has a string key for each setting of the validator
- It is assigned to a 3rd level associative array, the setting description
- This associative array should have the same format as for normal settings

For example, for the `ezstring` type, the validator schema could be:

``` php
[
    'stringLength' => [
        'minStringLength' => [
            'type'    => 'int',
            'default' => 0,
        ],
        'maxStringLength' => [
            'type'    => 'int'
            'default' => null,
        ]
    ],
];
```
