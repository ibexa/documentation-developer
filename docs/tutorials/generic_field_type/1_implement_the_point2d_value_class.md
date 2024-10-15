---
description: Learn how to create a Value class that stores the value of the field.
---

# Step 1 - Implement the Point 2D Value class

## Project installation

To start the tutorial, you need to make a clean [[= product_name =]] installation.
Follow the guide for your system to [install [[= product_name =]]](install_ibexa_dxp.md), [configure a server](requirements.md), and [start the web server](install_ibexa_dxp.md#use-phps-built-in-server).
Remember to install using the `dev` environment.

Open your project with a clean installation and create the base directory for a new Point 2D field type in `src/FieldType/Point2D`.

## The Value class

The Value class of a field type is by design very simple.
It's used to represent an instance of the field type within a content item.
Each field presents its data using an instance of the Type's Value class.
For more information about field type Value, see [Value handling](type_and_value.md#value-handling).

!!! tip

    According to the convention, the class representing field type Value should be named `Value` and should be placed in the same namespace as the Type definition.

[[= include_file('docs/snippets/simple_hash_value_caution.md') =]]

The Point 2D Value class contains:

- private properties, used to store the actual data
- an implementation of the `__toString()` method, required by the Value interface

By default, the constructor from `FieldType\Value` is used.

The Point 2D is going to store two elements (coordinates for point 2D):

- `x` value
- `y` value

At this point, it doesn't matter where they're stored. You want to focus on what the field type exposes as an API.

`src/FieldType/Point2D/Value.php` should have the following properties:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_1/Value.php', 9, 14) =]]
```

A Value class must also implement the `Ibexa\Contracts\Core\FieldType\Value` interface.
To match the `FieldType\Value` interface, you need to implement `__toString()` method.
You also need to add getters and setters for `x` and `y` properties.
This class represents the point 2D.

The final code should look like this:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_1/Value.php') =]]
```
