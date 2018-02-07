# Implement the Legacy Storage Engine Converter

So far, your Field Type’s value is represented by the `Tweet\Value` class. It holds a semantic representation of the type’s data: a URL, author URL and the tweet's content.

The next step is to tell the system how to actually *store* this.

## About converters

Unlike eZ Publish Legacy, eZ Platform supports (by design) multiple storage engines. The main, and almost only one right now is the Legacy Storage Engine, based on the legacy database, with a new implementation. Since each storage engine may have its own way of storing data, you need to map each Field Type value to something legacy can understand.

We will implement a Field Type Converter, each storage engine defining its own interface for those.

## Legacy Field Type converters

The legacy storage engine uses the `ezcontentobject_attribute` table to store Field values, and `ezcontentclass_attribute` to store Field definition values (settings, etc.). They are both based on the same principle.

Each row represents a Field or a FieldDefinition, and offers several free fields, of different types, where the type can store its data:

- `ezcontentobject_attribute` offers 3 fields for this purpose:
    - `data_int`
    - `data_text`
    - `data_float`
- `ezcontentclass_attribute` offers a few more:
    - four `data_int` (`data_int1` to `data_int4`) fields
    - four `data_float` (`data_float1` to `data_float4`) ones
    - five `data_text` (`data_text1` to `data_text5`)

Each type is free to use those fields in any way it requires. Converters will map a Field’s semantic values to the fields described above, for both settings (validation + configuration) and value.

## Implementing Tweet\\LegacyConverter

The Converter will be placed alongside the Type and Value definitions (the kernel stores them inside the Legacy Storage Engine structure): `eZ/Publish/FieldType/Tweet/LegacyConverter.php` .

A Legacy Converter must implement the `eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter` interface:

``` php
// TweetFieldTypeBundle/eZ/Publish/FieldType/Tweet/LegacyConverter.php

<?php

namespace EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet;

use eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter;

class LegacyConverter implements Converter
{
}
```

The Converter interface expects you to implement 5 methods:

- `toStorageValue()` and `toFieldValue()`
    used to convert an API field value to a legacy storage value, and a legacy storage value to an API field value.  

- `toStorageFieldDefinition()` and `toFieldDefinition()`
    used to convert a field definition to a legacy one, and a stored legacy field definition to an API field definition.

- `getIndexColumn()`
    tell the API which legacy DB field should be used to sort & filter content, either `sort_key_string` or `sort_key_int`.

### Implementing Field Value converters: toFieldValue() and toStorageValue()

As said above, those two methods are used to convert from a Field to a value that Legacy can store, and the other way around.

You have defined that you wanted to store the tweet’s URL in `data_text`, and that sorting would be done on the `username-status-tweetid` string you extract in `getName()` and `getSortInfo()`.

`toStorageValue()` will fill the provided `eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldValue` from a `Tweet\Value`, while `toFieldValue()` will do the exact opposite:

``` php
// TweetFieldTypeBundle/eZ/Publish/FieldType/Tweet/LegacyConverter.php

use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue;

// [...]

public function toStorageValue(FieldValue $value, StorageFieldValue $storageFieldValue)
{
    $storageFieldValue->dataText = json_encode($value->data);
    $storageFieldValue->sortKeyString = $value->sortKey;
}

public function toFieldValue(StorageFieldValue $value, FieldValue $fieldValue)
{
    $fieldValue->data = json_decode($value->dataText, true);
    $fieldValue->sortKey = $value->sortKeyString;
}
```

With these two methods, the legacy storage engine is able to convert a `Tweet\Value` into legacy data, and legacy data back into a `Tweet\Value` object.

### Implementing Field Definition converters: `toStorageFieldDefinition()` and `toFieldDefinition()`

The first two methods you have implemented apply to a Field’s value, but you also need to convert your Field’s definition. For example, a TextLine’s max length, or any FieldDefinition option.

This is done using `toStorageDefinition()` that converts a `FieldDefinition` into a `StorageFieldDefinition`. `toFieldDefinition()` does the opposite. In this case, you actually don’t need to implement those methods since your Tweet Type doesn’t have settings:

``` php
// TweetFieldTypeBundle/eZ/Publish/FieldType/Tweet/LegacyConverter.php

use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldDefinition;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;

// [...]

public function toStorageFieldDefinition(FieldDefinition $fieldDef, StorageFieldDefinition $storageDef)
{
}

public function toFieldDefinition(StorageFieldDefinition $storageDef, FieldDefinition $fieldDef)
{
}
```

### Implementing `getIndexColumn()`

In `toFieldValue()` and `toStorageValue()` you have used the `sortKeyString` property from `StorageFieldValue`. `getIndexColumn()` will tell provide the legacy storage engine with the type of index / sort column it should use: string (`sort_key_string`) or int (`sort_key_int`). Depending on which one is returned, the system will either use the `sortKeyString` or the `sortKeyInt` properties from the `StorageFieldValue`.

``` php
// TweetFieldTypeBundle/eZ/Publish/FieldType/Tweet/LegacyConverter.php

public function getIndexColumn()
{
    return 'sort_key_string';
}
```

## Registering the converter

Just like a Type, a Legacy Converter needs to be registered and tagged in the service container.

The tag is `ezpublish.storageEngine.legacy.converter`, and it requires an `alias` attribute to be set to the Field Type identifier (`eztweet`). Add this block to `Resources/config/fieldtypes.yml`:

``` yml
# Resources/config/fieldtypes.yml

services:
# declaration of the Fieldtype service
# ...
    ezsystems.tweetbundle.fieldtype.eztweet.converter:
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\LegacyConverter
        tags:
            - {name: ezpublish.storageEngine.legacy.converter, alias: eztweet}
```

------------------------------------------------------------------------

⬅ Previous: [Register the Field Type as a service](4_register_the_field_type_as_a_service.md)

Next: [Introduce a template](6_introduce_a_template.md) ➡
