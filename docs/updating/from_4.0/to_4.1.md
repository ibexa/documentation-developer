---
latest_tag: '4.1.1'
---

# Update from v4.0.x to v4.1

This update procedure applies if you are using v4.0.latest.

Go through the following steps to update to v4.1.

## Update the app to v4.1

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

Continue with updating the app:

=== "[[= product_name_content =]]"

    ``` bash
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files. Look through the old YAML files and move your custom configuration to the relevant new files.

Review the `bundles.php` and leave only third-party entires and entries added by the `recipes:install` command, that start with `Ibexa\Bundle`.

## Update the database

Apply the following database update script:

=== "MySQL"

    ``` sql
    ALTER TABLE `ibexa_product_specification_availability`
        ADD COLUMN `is_infinite` TINYINT(1) NOT NULL DEFAULT '0';

    UPDATE `ibexa_product_specification_availability`
        SET is_infinite = IF(stock IS NULL, 1, 0);

    CREATE TABLE IF NOT EXISTS ibexa_measurement_type
    (
        id   int auto_increment primary key,
        name varchar(192) not null,
        constraint ibexa_measurement_type_name
            unique (name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS ibexa_measurement_unit
    (
        id         int auto_increment primary key,
        type_id    int          not null,
        identifier varchar(192) not null,
        constraint ibexa_measurement_unit_type_identifier
            unique (type_id, identifier),
        constraint ibexa_measurement_unit_type_fk
            foreign key (type_id) references ibexa_measurement_type (id)
                on update cascade
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE IF NOT EXISTS ibexa_measurement_range_value
    (
        id               int auto_increment primary key,
        content_field_id int    not null,
        version_no       int    not null,
        unit_id          int    not null,
        min_value        double not null,
        max_value        double not null,
        constraint ibexa_measurement_range_value_attr_ver
            unique (content_field_id, version_no),
        constraint ibexa_measurement_range_value_attr_ver_type_unit
            unique (content_field_id, version_no, unit_id),
        constraint ibexa_measurement_range_value_attr_fk
            foreign key (content_field_id, version_no) references ezcontentobject_attribute (id, version)
                on update cascade on delete cascade,
        constraint ibexa_measurement_range_value_unit_fk
            foreign key (unit_id) references ibexa_measurement_unit (id)
                on update cascade
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE INDEX ibexa_measurement_range_value_unit_id
        on ibexa_measurement_range_value (unit_id);

    CREATE INDEX ibexa_measurement_unit_type_id
        on ibexa_measurement_unit (type_id);

    CREATE TABLE IF NOT EXISTS ibexa_measurement_value
    (
        id               int auto_increment primary key,
        content_field_id int    not null,
        version_no       int    not null,
        unit_id          int    not null,
        value            double not null,
        constraint ibexa_measurement_value_attr_ver
            unique (content_field_id, version_no),
        constraint ibexa_measurement_value_attr_ver_unit
            unique (content_field_id, version_no, unit_id),
        constraint ibexa_measurement_value_attr_fk
            foreign key (content_field_id, version_no) references ezcontentobject_attribute (id, version)
                on update cascade on delete cascade,
        constraint ibexa_measurement_value_unit_fk
            foreign key (unit_id) references ibexa_measurement_unit (id)
                on update cascade
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE INDEX ibexa_measurement_value_unit_id
        on ibexa_measurement_value (unit_id);
    ```

=== "PostgreSQL"

    ``` sql
    ALTER TABLE "ibexa_product_specification_availability" ADD "is_infinite" boolean DEFAULT false NOT NULL;

    UPDATE "ibexa_product_specification_availability" SET "is_infinite" = CASE WHEN "stock" IS NULL THEN true END;

    CREATE TABLE IF NOT EXISTS ibexa_measurement_type
    (
        id serial primary key,
        name varchar(192) not null
    );

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_type_name ON ibexa_measurement_type (name);

    CREATE TABLE IF NOT EXISTS ibexa_measurement_unit
    (
        id serial primary key,
        type_id integer not null
        constraint ibexa_measurement_unit_type_fk
            references ibexa_measurement_type
            on update cascade on delete restrict,
        identifier varchar(192) not null
    );

    CREATE INDEX IF NOT EXISTS ibexa_measurement_unit_type_id ON ibexa_measurement_unit (type_id);

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_unit_type_identifier ON ibexa_measurement_unit (type_id, identifier);

    CREATE TABLE IF NOT EXISTS ibexa_measurement_value
    (
        id serial primary key,
        content_field_id integer not null,
        version_no integer not null,
        unit_id integer not null
        constraint ibexa_measurement_value_unit_fk
            references ibexa_measurement_unit
            on update cascade on delete restrict,
        value double precision not null,
        constraint ibexa_measurement_value_attr_fk
            foreign key (content_field_id, version_no) references ezcontentobject_attribute
                on update cascade on delete cascade
    );

    CREATE INDEX IF NOT EXISTS ibexa_measurement_value_unit_id ON ibexa_measurement_value (unit_id);

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_value_attr_ver ON ibexa_measurement_value (content_field_id, version_no);

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_value_attr_ver_unit ON ibexa_measurement_value (content_field_id, version_no, unit_id);

    CREATE TABLE IF NOT EXISTS ibexa_measurement_range_value
    (
        id serial primary key,
        content_field_id integer not null,
        version_no       integer not null,
        unit_id          integer not null
        constraint ibexa_measurement_range_value_unit_fk
            references ibexa_measurement_unit
            on update cascade on delete restrict,
        min_value        double precision not null,
        max_value        double precision not null,
        constraint ibexa_measurement_range_value_attr_fk
            foreign key (content_field_id, version_no) references ezcontentobject_attribute
                on update cascade on delete cascade
    );

    CREATE INDEX IF NOT EXISTS ibexa_measurement_range_value_unit_id ON ibexa_measurement_range_value (unit_id);

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_range_value_attr_ver
        on ibexa_measurement_range_value (content_field_id, version_no);

    CREATE UNIQUE INDEX IF NOT EXISTS ibexa_measurement_range_value_attr_ver_type_unit
        on ibexa_measurement_range_value (content_field_id, version_no, unit_id);
    ```

### Prepare new database tables

For every database connection you have configured, perform the following steps:

1. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection}`
2. Check the queries and verify that they are safe and will not damage the data.
3. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection} --force`

Run `php bin/console cache:clear` command to make any sure SPI cache issues are cleared.

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed.
If the dry run is successful, run:

``` bash
php bin/console ibexa:migrations:migrate
```

## Update your custom code

### Product catalog

After you update the application and database, account for changes related to the refactored Product Catalog.
For more information, see [Set up product for purchasing](<link_to_article>).

## Finish update


Finish the update process:

``` bash
composer run post-install-cmd
```

Finally, generate the new GraphQl schema:

``` bash
php bin/console ibexa:graphql:generate-schema
```
