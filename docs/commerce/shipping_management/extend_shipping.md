---
description: Extend Shipping with custom shipping method type and other extra features.
edition: commerce
---

# Extend shipping

There are different ways you can extend your Shipping module implementation. 
One of them is to create a custom shipping method type.
You can also toggle shipping method availability in checkout based on a condition and display shipping method parameters on the shipping method details page.

You can also [customize the shipment processing workflow](configure_shipment.md#custom-shipment-workflows).

## Create custom payment method type

If your application needs shipping methods of other type than the default ones, you must create custom shipping method types. 
Code samples below show how this could be done.
 
### Define custom shipping method type

Use a built-in type factory to define the shipping method type class in the service definition file:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 1, 8) =]]
```

At this point a custom shipping method type should be visible in the user interface.

### Create options form

Create a form type that corresponds to the custom shipping method type.
Here, you can also define a name of the custom shipping method type by using the  `getTranslationMessages` method.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Form/Type/CustomShippingMethodOptionsType.php') =]]
```

Create a translations file that defines a name for the custom shipping method type, for example:

``` yaml
[[= include_file('code_samples/front/shop/shipping/translations/ibexa_shipping.en.yaml') =]]
```

Next, define an options form mapper in the service definition file:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 8, 15) =]]
```

### Create options validator

You might want to make sure that form data provided by the user is validated. 
To do that, create an options validator that checks input in fields that are specific for this shipping method type against the constraints and dispatches an error when needed.

Define a compound validator class in the service definition file:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 15, 22) =]]
```

Create the validator class:

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/CustomerNotNullValidator.php') =]]
```

Then, register the validator as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 22, 25) =]]
```

### Create storage converter

Before form data can be stored in database tables, Field values must be converted to a storage-specific format.
A storage converter class converts a `customer_identifier` string into a `customer_id` numerical value.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageConverter.php') =]]
```

Register the converter as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 25, 28) =]]
```

#### Storage definition 

!!! note "Create table"

    Before you can proceed, create a database table, which has the columns that are used below:

    `CREATE TABLE ibexa_shipping_method_region_custom(id int, customer_id text, shipping_method_region_id int);`


Define a table that stores information specific for the shipping method, together with its schema.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageDefinition.php') =]]
```

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Storage/StorageSchema.php') =]]
```

Then, register the storage definition as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 28, 31) =]]
```

![Creating a shipping method of custom type](img/custom_shipping_method_type.png "Creating a shipping method of custom type")

## Toggle shipping method type availability

You can decide whether shipping methods of your custom type should be available for selection during checkout.
For example, you can limit shipping method availability to customers who meet a specific condition.
Here, a voter class checks the `customer_identifier` against a condition.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Voter/CustomVoter.php') =]]
```

Register the voter as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 31, 34) =]]
```

## Display shipping method parameters on shipping method details page

You can extend the default functionality by making parameters of shipping method of your custom type visible on the **Cost** tab of the shipping method details page.

``` php
[[= include_file('code_samples/front/shop/shipping/src/ShippingMethodType/Cost/CustomCostFormatter.php') =]]
```

Register the formatter class as a service:

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 0, 1) =]] [[= include_file('code_samples/front/shop/shipping/config/packages/services.yaml', 34, 38) =]]
```

