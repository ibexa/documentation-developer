---
description: Extend Shipping with custom shipping method type and other extra features.
edition: commerce
---

# Extend shipping

There are different ways in which you can extend or customize your Shipping module implementation. 
Here, you can learn about the following ideas to make your Commerce solution more powerful:

- create a custom shipping method type
- toggle shipping method availability in checkout based on a condition
- display shipping method parameters on the shipping method details page

You can also [customize the shipment processing workflow](configure_shipment.md#custom-shipment-workflows).

## Create custom shipping method type

If your application needs shipping methods of other type than the default ones, you create custom shipping method types. 
See the code samples below to learn how you could do it.
 
### Define custom shipping method type class

Create a definition of the shipping method type. 
Use a built-in type factory to define the class in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 1, 8) =]]
```

At this point a custom shipping method type should be visible in the user interface.

### Create options form

To let users create shipping methods of a custom type within the user interface, you need a Symfony form type. 
In `src/ShippingMethodType/Form/Type/`, create a `CustomShippingMethodOptionsType.php` file with a form type.

You also define a name of the custom shipping method type here, by using the `getTranslationMessages` method.

``` php hl_lines="32"
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Form/Type/CustomShippingMethodOptionsType.php') =]]
```

In `translations/`, create a translations file `ibexa_shipping.en.yaml` that stores a name value for the custom shipping method type:

``` yaml
[[= include_file('code_samples/front/shop/shipping/translations/ibexa_shipping.en.yaml') =]]
```

Next, use the type factory to define an options form mapper class in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 8, 15) =]]
```

![Creating a shipping method of custom type](img/custom_shipping_method_type.png "Creating a shipping method of custom type")

### Create options validator

You might want to validate the data provided by the user against certain constraints. 
Here, you create an options validator class that checks whether the user provided the `customer_identifier` value and dispatches an error when needed.

Use the type factory to define a compound validator class in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 15, 22) =]]
```

Then, in `src/ShippingMethodType/`, create a `CustomerNotNullValidator.php` with the validator class:

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/CustomerNotNullValidator.php') =]]
```

Finally, register the validator as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 22, 25) =]]
```

### Create storage converter

Before form data can be stored in database tables, field values must be converted to a storage-specific format.
Here, the storage converter converts the `customer_identifier` string value into the `customer_id` numerical value.

In `src/ShippingMethodType/Storage`, create a `StorageConverter.php` file with the storage converter class:

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageConverter.php') =]]
```

Then, register the storage converter as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 25, 28) =]]
```

#### Storage definition 

Now, create a storage definition class and a corresponding schema.
The table stores information specific for the custom shipping method type.

!!! note "Create table"

    Before you can proceed, in your database, create a table that has columns present in the storage definition, for example:

    `CREATE TABLE ibexa_shipping_method_region_custom(id int auto_increment primary key, customer_id text, shipping_method_region_id int);`

In `src/ShippingMethodType/Storage`, create `StorageDefinition.php` and `StorageSchema.php` files with their corresponding classes.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageDefinition.php') =]]
```

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageSchema.php') =]]
```

Then, register the storage definition as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 28, 31) =]]
```

![Creating a shipping method of custom type](img/custom_shipping_method_type.png "Creating a shipping method of custom type")

## Toggle shipping method type availability

When you implement a web store, you can choose if a certain shipping method is available for selection during checkout.
Here, you limit shipping method availability to customers who meet a specific condition.
In `src/ShippingMethodType/Voter`, create a `CustomVoter.php` file with a voter class:

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Voter/CustomVoter.php') =]]
```

Register the voter as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 31, 34) =]]
```

## Display shipping method parameters in shipping method details view

You can extend the default  shipping method details view by making shipping method visible on the **Cost** tab.
To do this, in `src/ShippingMethodType/Cost`, create a `CustomCostFormatter.php` file with a formatter class:

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Cost/CustomCostFormatter.php') =]]
```

Then register the formatter as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 34, 38) =]]
```

