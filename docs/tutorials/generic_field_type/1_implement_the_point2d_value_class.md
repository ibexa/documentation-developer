---
description: Learn how to create a Value class that stores the value of the Field.
---

# Step 1 - Implement the Point 2D Value class

## Project installation

To start the tutorial, you need to make a clean [[= product_name =]] installation.
Follow the guide for your system to [install Ibexa DXP](install_ibexa_dxp.md),
[configure a server](requirements.md),
and [start the web server](install_ibexa_dxp.md#use-phps-built-in-server).
Remember to install using the `dev` environment.

Open your project with a clean installation and create the base directory for a new Point 2D Field Type in `src/FieldType/Point2D`.

## The Value class

The Value class of a Field Type is by design very simple.
It is used to represent an instance of the Field Type within a Content item.
Each Field presents its data using an instance of the Type's Value class.
For more information about Field Type Value, see [Value handling](type_and_value.md#value-handling).

!!! tip

    According to the convention, the class representing Field Type Value should be named `Value` and should be placed in the same namespace as the Type definition.

The Point 2D Value class will contain:

- private properties, used to store the actual data
- an implementation of the `__toString()` method, required by the Value interface

By default, the constructor from `FieldType\Value` will be used.

The Point 2D is going to store two elements (coordinates for point 2D):

- `x` value
- `y` value

At this point, it does not matter where they are stored. You want to focus on what the Field Type exposes as an API.

`src/FieldType/Point2D/Value.php` should have the following properties:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_1/Value.php', 9, 13) =]]
```

A Value class must also implement the `Ibexa\Contracts\Core\FieldType\Value` interface.
To match the `FieldType\Value` interface, you need to implement `__toString()` method.
You also need to add getters and setters for `x` and `y` properties.
This class will represent the point 2D.

The final code should look like this:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_1/Value.php') =]]
```
