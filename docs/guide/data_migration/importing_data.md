# Importing data

To import Repository data from YAML files, run the `ibexa:migrations:migrate` command.

Place your import file in the `src/Migrations/Ibexa/migrations` folder
or in [a custom folder that you configure](migration_management.md#migration-folders).
The command takes the file name within this folder as parameter.
If file is not specified, all files within this directory are used.

``` bash
php bin/console ibexa:migrations:migrate --file=my_data_export.yaml
```

Ibexa Migrations store execution metadata in `ibexa_migrations` database table. This allows incremental upgrades:
the `ibexa:migration:migrate` command ignores files that it had previously executed.


## Migration file content

The following examples show what data you can import using data migrations.

### Product catalog

Create an attribute group with an attribute:

``` yaml
-   type: attribute_group
    mode: create
    identifier: hat
    names:
        eng-GB: Hat
-   type: attribute
    mode: create
    identifier: size
    attribute_type_identifier: integer
    attribute_group_identifier: hat
    names:
        eng-GB: Size
```

Create a customer group with a defined global price discount:

``` yaml
-   type: customer_group
    mode: create
    identifier: contractors
    names:
        eng-GB: Contractors
    global_price_rate: -20.0
```

Create a currency:

``` yaml
-   type: currency
    mode: create
    code: TST
    subunits: 3
```

### Criteria

When using `update` or `delete` modes, you can use criteria to identify the objects to operate on.

``` yaml
type: currency
mode: update
criteria:
    type: field_value
    field: code
    value: EUR
    operator: '=' # default
code: EEE
subunits: 3
enabled: false
```

Available operators are:

- `=`
- `<>`
- `<`
- `<=`
- `>`
- `>=`
- `IN`
- `NIN`
- `CONTAINS`
- `STARTS_WITH`
- `ENDS_WITH`.

You can combine criteria by using logical criteria `and` and `or`:

``` yaml
type: or
criteria:
    -   type: field_value
        field: code
        value: EUR
    -   type: field_value
        field: code
        value: X
        operator: STARTS_WITH
```

Criteria can be nested.

