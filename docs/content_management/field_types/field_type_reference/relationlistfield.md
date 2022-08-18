# RelationList Field Type

This Field Type makes it possible to store and retrieve values of a relation to other Content items.

| Name           | Internal name          | Expected input |
|----------------|------------------------|----------------|
| `RelationList` | `ezobjectrelationlist` | `mixed`        |

## PHP API Field Type 

### Input expectations

|Type|Description|Example|
|------|------|------|
|`int|string`|ID of the related Content item|`42`|
|`array`|An array of related Content IDs|`[ 24, 42 ]`|
|`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`|ContentInfo instance of the related Content|n/a|
|`Ibexa\Core\FieldType\RelationList\Value`|RelationList Field Type Value Object|See below.|

### Value Object

##### Properties

`Ibexa\Core\FieldType\RelationList\Value` contains the following properties:

|Property|Type|Description|Example|
|------|------|------|------|
|`destinationContentIds`|`array`|An array of related Content IDs|`[ 24, 42 ]`|

``` php
// Value object content example
$relationList->destinationContentId = [
    $contentInfo1->id,
    $contentInfo2->id,
    170
];
```

##### Constructor

The `RelationList\Value` constructor will initialize a new Value object with the value provided. It expects a mixed array as value.

``` php
//Constructor example

// Instantiates a RelationList Value object
$relationListValue = new RelationList\Value(
    [
        $contentInfo1->id,
        $contentInfo2->id,
        170
    ]
);
```

### Validation

This Field Type validates if:

- the `selectionMethod` specified is `\Ibexa\Core\FieldType\RelationList\Type::SELECTION_BROWSE` or `\Ibexa\Core\FieldType\RelationList\Type::SELECTION_DROPDOWN`. A validation error is thrown if the value does not match.
- the `selectionDefaultLocation` specified is `null`, `string` or `integer`. If the type validation fails a validation error is thrown.
- the value specified in `selectionContentTypes` is an `array`. If not, a validation error in given.
- the number of Content items selected in the Field is not greater than the `selectionLimit`.

!!! note

    The dropdown selection method is not implemented yet.

### Settings

The Field definition of this Field Type can be configured with the following options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`selectionMethod`|`mixed`|`SELECTION_BROWSE`|Method of selection in the back-end interface.|
|`selectionDefaultLocation`|`string|integer`|`null`|ID of the default Location for the selection when using the back-end interface.|
|`selectionContentTypes`|`array`|`[]`|An array of Content Type IDs that are allowed for related Content.|

Following selection methods are available:

| Name| Description|
|-----|------------|
| `SELECTION_BROWSE` | Selection will use browse mode.|
| `SELECTION_DROPDOWN` | *Not implemented yet* |

### Validators

|Name|Type|Default value|Description|
|------|------|------|------|
|`RelationListValueValidator[selectionLimit]`|`integer`|`0`|The number of Content items that can be selected in the Field. When set to 0, any number can be selected.|

``` php
// Example of using settings and validators configuration in PHP

use Ibexa\Core\FieldType\RelationList\Type;

$fieldSettings = [
    "selectionMethod" => Type::SELECTION_BROWSE,
    "selectionDefaultLocation" => null,
    "selectionContentTypes" => []
 ];

$validators = [
    "RelationListValueValidator" => [
        "selectionLimit" => 0,
    ]
];
```
