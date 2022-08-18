# Author Field Type

This Field Type allows the storage and retrieval of one or more authors. For each author, it can handle a name and an email address. It is typically used to store information about additional authors who have written/created different parts of a Content item.

| Name     | Internal name | Expected input | Output   |
|----------|---------------|----------------|----------|
| `Author` | `ezauthor`    | mixed        | `string` |
## PHP API Field Type

### Value Object

##### Properties

|Attribute|Type|Description|Example|
|------|------|------|------|
|`authors`|`\Ibexa\Core\FieldType\Author\Author[] `|List of authors.|See below|

Example:

``` php
$authorList = Author\Value([
   new Author\Author([
       'id' => 1,
       'name' => 'Boba Fett',
       'email' => 'boba.fett@example.com'
   ]),
   new Author\Author([
       'id' => 2,
       'name' => 'Darth Vader',
       'email' => 'darth.vader@example.com'
   ]),
]);
```

### Hash format

The hash format mostly matches the value object. It has the following key `authors`.

Example

``` php
[
    [
       'id' => 1,
       'name' => 'Boba Fett',
       'email' => 'boba.fett@example.com'
    ],
    [
       'id' => 2,
       'name' => 'Darth Vader',
       'email' => 'darth.vader@example.com'
    ]
]
```

##### String representation

The string contains all the authors with their names and emails.

Example: `John Doe john@doe.com`

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

The Field definition of this Field Type can be configured with a single option:

|Name|Type|Default value|Description|
|------|------|------|------|
|`defaultAuthor`|`mixed`|`Type::DEFAULT_VALUE_EMPTY`|One of the `DEFAULT_*` constants, used by the administration interface for setting the default Field value. See below for more details.|

Following `defaultAuthor` default value options are available as constants in the `Ibexa\Core\FieldType\Author\Type` class:

|Constant|Description|
|------|------|
|`DEFAULT_VALUE_EMPTY`|Default value will be empty.|
|`DEFAULT_CURRENT_USER`|Default value will use currently logged user.|

``` php
// Author Field Type example settings

use Ibexa\Core\FieldType\Author\Type;

$settings = [
    "defaultAuthor" => Type::DEFAULT_VALUE_EMPTY
];
```
