# Creating a Point 2D Field Type 

!!! tip "Getting the code"

    The code created in this tutorial is available on [GitHub]().

This tutorial covers the creation and development of a custom eZ Platform [Field Type](../../api/field_type_reference.md) based on a Generic Field Type.
The Generic Field Type is a very powerful type of extension, it allows you to easily build complex solutions on a ready-to-go Field Type template.

Field Types are responsible for:

- Storing data, either using the native storage engine mechanisms or specific means
- Validating input data
- Making the data searchable (if applicable)
- Displaying fields

You can find more information in [Field Type documentation](../../api/field_type_api.md).
It describes how each component of a Field Type interacts with the various layers of the system, and how to implement them.

## Intended audience

This tutorial is aimed at developers who are familiar with eZ Platform and are comfortable with operating in PHP and Symfony.

## Content of the tutorial

This tutorial will demonstrate how to create a Field Type on the example of the Generic Field Type.
It will show you how to use the Generic Field Type as a template for a custom Field Type. 

## Preparation

To start the tutorial, you need to make a clean eZ Platform installation.
Follow the guide for your system from [Install eZ Platform](../../getting_started/install_ez_platform.md).
Remember to install using the `dev` environment.

## Steps

In this tutorial you will go through the following steps:

- [1. Implement the Point 2D Value class](1_implement_the_point2d_value_class.md)
- [2. Define the Point 2D Field Type](2_define_point2d_field_type.md)
- [3. Create form for editing Field Type](3_register_point2d_as_a_service.md)
- [4. Introduce a template](4_introduce_a_template.md)
- [5. Add a new Point 2D field](5_add_a_field.md)
- [6. Implement Point 2D settings](6_settings.md)
- [7. Add basic validation](7_add_a_validation.md)
- [8. Data migration between Field Type versions](8_data_migration.md)
