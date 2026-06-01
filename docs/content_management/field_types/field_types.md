---
description: Field types define the fields that a content item is built of.
---

# Field types

Field types are the smallest building blocks of content.
[[= product_name =]] comes with many [built-in field types](field_type_reference.md#available-field-types) that cover most common needs, for example, Text line, Email address, Author list, Content relation, Map location, or Float.

Field types are responsible for:

- Storing data, either using the native storage engine mechanisms or specific means
- Validating input data
- Making the data searchable (if applicable)
- Displaying fields of this type

## Custom data

[[= product_name =]] can support custom data to be stored in the fields of a content item.
To do so, you need to create a custom field type.

A custom field type must implement the **FieldType Service Provider Interfaces**
available in the [`Ibexa\Core\FieldType`](https://github.com/ibexa/core/tree/4.6/src/lib/FieldType) namespace.

!!! note "Registration"

    Remember that all your custom field types must be registered in `config/services.yml`.
    For more information, see [Registration](type_and_value.md#registration).

To provide custom functionality for a field type, the SPI interacts with multiple layers of the [[= product_name =]] architecture:

![Field type Overview](field_type_overview.png)

On the top layer, the field type needs to provide conversion from and to a simple PHP hash value to support the **REST API**. The generated hash value may only consist of scalar values and hashes. It must not contain objects or arrays with numerical indexes that aren't sequential and/or don't start with zero.

[[= include_file('docs/snippets/simple_hash_value_caution.md') =]]

Below that, the field type must support the **public PHP API** implementation regarding:

- Settings definition for `FieldDefinition`
- Value creation and validation
- Communication with the Persistence SPI

On the bottom level, a field type can additionally hook into the **Persistence SPI** to store data from a `FieldValue` in an external service.
All non-standard [[= product_name =]] database tables (for example, `ezurl`) are treated as [external storage](field_type_storage.md#storing-data-externally).

The following sequence diagrams visualize the process of creating and publishing new content across all layers, especially focused on the interaction with a field type.

## Creating content

![Create content sequence](create_content_sequence.png)

## Publishing content

!!! note "indexLocation()"

    For **Solr** locations are indexed during Content indexing.
    For **Legacy/SQL** indexing isn't required as location data already exists in a database.

![Publish content sequence](publish_content_sequence.png)

## Updating content

![Update content sequence](update_content_sequence.png)

## Loading content

![Load content sequence](load_content_sequence.png)
