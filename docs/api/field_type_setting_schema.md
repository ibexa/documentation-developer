# Schema settings and validators
 
## Settings schema
 
It is recommended to use a simple HashMap format for the settings schema returned by `eZ\Publish\SPI\FieldType\FieldType::getSettingsSchema()`, which follows these rules:
 
-   The key of the HashMap identifies a setting (e.g. `default`)
-   Its value is a HashMap (2nd level) describing the setting using:
    -   `type` to identify the setting type (e.g. `int` or `string`)
    -   `default` containing the default setting value
 
An example schema could look like this:
 
```
array(
    'backupData' => array(
        'type' => 'bool',
        'default' => false
    ),
    'defaultValue' => array(
        'type' => 'string',
        'default' => 'Sindelfingen'
    )
);
```
 
## Validator schema
 
The schema for validator configuration should have a similar format to the settings schema, except it has an additional level, to group settings for a certain validation mechanism:
 
-   The key on the 1st level is a string, identifying a validator
-   Assigned to that is a HashMap (2nd level) of settings
-   This HashMap has a string key for each setting of the validator
-   It is assigned to a 3rd level HashMap, the setting description
-   This HashMap should have the same format as for normal settings
 
For example, for the `ezstring` type, the validator schema could be:
 
```
array(
    'stringLength' => array(
        'minStringLength' => array(
            'type'    => 'int',
            'default' => 0,
        ),
        'maxStringLength' => array(
            'type'    => 'int'
            'default' => null,
        )
    ),
);
```
 
## Settings schema and allowed validators
 
### Internal Field Type conventions and best practices
 
`FieldType=>settingsSchema` and `FieldType=>allowedValidators` are intentionally left free-form, to give flexibility to Field Type developers. However, for internal Field Types (aka those delivered with eZ Platform), a common standard should be established as best practice. The purpose of this page is to collect and unify this standard.
 
#### Settings schema
 
The general format of the settings schema of a Field Type is a HashMap of setting names, assigned to their type and default value, e.g.:
 
``` php
     array(
         'myFancySetting' => array(
             'type' => 'int',
             'default' => 23,
         ),
         'myOtherFancySetting' => array(
             'type' => 'string',
             'default' => 'Sindelfingen',
         ),
     );
```
 
The type should be either a valid PHP type shortcut or one of the following special types:
 
-   Hash (a simple HashMap)
-   Choice (an enumeration)
-   &lt;&lt;&lt;YOUR TYPE HERE&gt;&gt;&gt;