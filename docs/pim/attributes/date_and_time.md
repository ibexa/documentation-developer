---
description: Date and time attribute type allows you to store product information related to time, like an expiration date or date of manufacturing.
---

# Date and time attribute type

The date and time attribute type is one of the [attribute types](products.md#attributes) that allows you to efficiently represent date and time values as part of the product specification in the [Product Information Management](pim_guide.md) system.

It's an [LTS update](release_process_and_roadmap.md) you can install to expand the capabilities of your [[= product_name =]].

You can use it to store, for example, manufacturing dates, expiration dates, or event dates, all with specified accuracy.


## Installation

### Download the bundle

To get the most recent stable version of this package, open a command terminal, navigate to your project directory, and run the following command:

``` bash
composer require ibexa/product-catalog-date-time-attribute
```

### Enable the bundle

Symfony Flex enables and configures the `IbexaProductCatalogDateTimeAttributeBundle` automatically.
If you don't use it, you can manually enable this bundle by adding it to the list of bundles in `config/bundles.php`:

``` php
return [
   // ...
    Ibexa\Bundle\ProductCatalogDateTimeAttribute\IbexaProductCatalogDateTimeAttributeBundle::class => ['all' => true],
   // ...
];
```

### Update database schema

The new attribute type requires changes to the database schema.
Execute the following queries on your database to support the new attribute type:

=== "MySQL"

    ``` sql
    CREATE TABLE ibexa_product_specification_attribute_datetime (id INT NOT NULL, value DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX ibexa_product_specification_attribute_datetime_idx (value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
    ALTER TABLE ibexa_product_specification_attribute_datetime ADD CONSTRAINT ibexa_product_specification_attribute_datetime_fk FOREIGN KEY (id) REFERENCES ibexa_product_specification_attribute (id) ON UPDATE CASCADE ON DELETE CASCADE;
    ```

=== "PostgreSQL"

    ``` sql
    CREATE TABLE ibexa_product_specification_attribute_datetime (id INT NOT NULL, value TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id));
    CREATE INDEX ibexa_product_specification_attribute_datetime_idx ON ibexa_product_specification_attribute_datetime (value);
    COMMENT ON COLUMN ibexa_product_specification_attribute_datetime.value IS '(DC2Type:datetime_immutable)';
    ALTER TABLE ibexa_product_specification_attribute_datetime ADD CONSTRAINT ibexa_product_specification_attribute_datetime_fk FOREIGN KEY (id) REFERENCES ibexa_product_specification_attribute (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
    ```

You can now start working with the date and time attribute type.

## Usage

The Date and time attribute type's support in the system is on par with the other, built-in attribute types.

You can manage it through the back office, [data migrations](importing_data.md#date-and-time-attribute), REST, or through the PHP API.

When creating an attribute based on the date and time attribute type you can select the accuracy level to match your needs:

![Creating a product using a date and time attribute with "trimster" accuracy level](img/datetime.png "Creating a product using a date and time attribute with "trimster" accuracy level")

| Accuracy | Example |
|---|---|
| Year | 2025 |
| Trimester | Q3 2025 |
| Month | July 2025 |
| Day  | 2025-07-06 |
| Minute | 2025-07-06 11:15 |
| Second | 2025-07-06 11:15:37 |
