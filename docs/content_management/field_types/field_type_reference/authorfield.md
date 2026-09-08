# Author field type

This field type allows the storage and retrieval of one or more authors. For each author, it can handle a name and an email address. It's typically used to store information about additional authors who have written/created different parts of a content item.

| Name     | Internal name  | Expected input | Output   |
|----------|----------------|----------------|----------|
| `Author` | `ibexa_author` | mixed          | `string` |

## Properties

| Attribute | Type                                     | Description      | Example   |
|-----------|------------------------------------------|------------------|-----------|
| `authors` | `\Ibexa\Core\FieldType\Author\Author[]` | List of authors. | See below |

Example:

## Hash format

The hash format mostly matches the value object. It has the following key `authors`.

Example

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The Field definition of this field type can be configured with a single option:

| Name            | Type    | Default value               | Description                                                                                                                             |
|-----------------|---------|-----------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `defaultAuthor` | `mixed` | `Type::DEFAULT_VALUE_EMPTY` | One of the `DEFAULT_*` constants, used by the administration interface for setting the default Field value. See below for more details. |

Following `defaultAuthor` default value options are available as constants in the `Ibexa\Core\FieldType\Author\Type` class:

| Constant               | Description                               |
|------------------------|-------------------------------------------|
| `DEFAULT_VALUE_EMPTY`  | Default value is empty.                   |
| `DEFAULT_CURRENT_USER` | Default value uses currently logged user. |
