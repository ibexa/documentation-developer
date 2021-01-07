# Data migration

You can migrate your Repository data, that is Content items, as well as Content Types, languages, Object states, Sections, etc.,
between installations by using the migration script.

## Exporting data

To export Repository content, use the `ibexa:migrations:generate` command.
This command generates a YAML file with the requested part of the Repository.
The file is located by default in the `src/Migrations/Ibexa` folder.
You can later use this file to import the data.

``` bash
bin/console ibexa:migrations:generate --type=content --mode=create
```

### type

The mandatory `--type` option defines the type of Repository data to export.
The following types are available:

- `content`
- `content_type`
- `role`
- `content_type_group`
- `user`
- `user_group`
- `language`
- `object_state_group`
- `object_state`
- `section`
- `location`

If you do not provide the `--type` option, the command will ask you to select a type of data.

### mode

The mandatory `--mode` option defines the action that importing the file will perform.
The following modes are available:

- `create` - creates new items
- `update` - updates an existing item
- `delete` - deletes an existing item

If you do not provide the `--mode` option, the command will ask you to select the mode.

The following combinations of types are modes are available:

||`create`|`update`|`delete`|
|---|:---:|:---:|:---:|
|`content`|+|+|+|
|`content_type`|+|+||
|`role`|+|+|+|
|`content_type_group`|+|+||
|`user`|+|+||
|`user_group`|+||+|
|`language`|+|||
|`object_state_group`|+|||
|`object_state`|+|||
|`section`|+|+||
|`location`||+||

### match-property

The optional `--match-property` option, together with `value`, enables you to select which data from the Repository to export.
`match-property` defines what property should be used as a criterion for selecting data.
The following properties are available (per type):

- `content`
    - `content_id`
    - `content_type_id`
    - `content_type_group_id`
    - `content_type_identifier`
    - `content_remote_id`
    - `location_id`
    - `location_remote_id`
    - `parent_location_id`
    - `user_id`
- `content_type`
    - `content_type_identifier`
- `content_type_group`
    - `content_type_group_id`
    - `content_type_group_identifier`
- `language`
    - `language_code`
- `location`
    - `location_remote_id`
    - `location_id`
- `object_state`
    - `object_state_id`
    - `object_state_identifier`
- `object_state_group`
    - `object_state_group_id`
    - `object_state_group_identifier`
- `role`
    - `identifier`
    - `id`
- `section`
    - `section_id`
    - `section_identifier`
- `user`
    - `login`
    - `email`

### value

The optional `--value` option, together with `match-property`, filters the Repository content that the command exports.
`value` defines which values of the `match-property` should be included in the export.

For example, to export only Article Content items, use the `content_type_identifier` match property with `article` as the value:

``` bash
bin/console ibexa:migrations:generate --type=content --mode=create --match-property=content_type_identifier --value=article
```

### file

The optional `--file` option defines the name of the YAML file to export to.

``` bash
bin/console ibexa:migrations:generate --type=content --mode=create --file=my_data_export.yaml
```

### user-context

The optional `--user-context` option enables you to run the export command as a specified User.
The command only exports Repository data that the selected User has access to.

``` bash
bin/console ibexa:migrations:generate --type=content --mode=create --user-context=jessica_andaya
```

## Importing data

To import Repository data from a YAML file, run the `ibexa:migrations:migrate` command.

Place your import file in the `src/Migrations/Ibexa` folder.
The command takes the file name within this folder as parameter.

``` bash
bin/console ibexa:migrations:migrate --file=my_data_export.yaml
```

## Converting migration files

If you want to convert a file from the format used by the [Kaliop migration bundle](https://github.com/kaliop-uk/ezmigrationbundle)
to the current migration format, use the `ibexa:migrations:kaliop:convert` command.

The source file must use Kaliop mode and type combinations.
The converter handles Kaliop types that are different from Ibexa types.

``` bash
bin/console ibexa:migrations:kaliop:convert --input=kaliop_format.yaml --output=ibexa_format.yaml
```

You can also convert multiple files using `ibexa:migrations:kaliop:bulk-convert`:

``` bash
bin/console ibexa:migrations:kaliop:bulk-convert --recursive --input-directory=kaliop_files --output-directory=ibexa_files
```

If you do not specify the output directory, the command overwrites the input files.
