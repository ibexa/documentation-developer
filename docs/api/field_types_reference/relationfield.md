# Relation Field Type

!!! caution "Deprecated"

    The Relation Field Type is deprecated since v2.0.

    Use [RelationList](relationlistfield.md) with a selection limit instead.

This Field Type makes it possible to store and retrieve the value of a relation to another Content item.

| Name       | Internal name      | Expected input |
|------------|--------------------|----------------|
| `Relation` | `ezobjectrelation` | mixed        |

## PHP API Field Type 

### Input expectations

|Type|Example|
|------|------|
|`string`|`"150"`|
|`integer`|`150`|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property|Type| Description|
|---------|-----|-----------|
| `$destinationContentId` | `string|int|null` | This property is used to store the value provided, which represents the related content. |

``` php
// Value object content example

$relation->destinationContentId = $contentInfo->id;
```

##### Constructor

The `Relation\Value` constructor will initialize a new Value object with the value provided. It expects a mixed value.

``` php
// Constructor example

// Instantiates a Relation Value object
$relationValue = new Relation\Value( $contentInfo->id );
```

### Validation

This Field Type validates whether the provided relation exists, but before that it will check that the value is either a string or an int.

### Settings

The Field definition of this Field Type can be configured with three options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`selectionMethod`|`int`|`Relation\Type::SELECTION_BROWSE`| *This setting is not implemented yet, only one selection method is available.* |
|`selectionRoot`|`string`|`null`|This setting defines the selection root.|
|`selectionContentTypes`|`array`|`[]`|An array of Content Type IDs that are allowed for related Content.|

``` php
// Relation FieldType example settings

use Ibexa\Core\FieldType\Relation\Type;

$settings = [
    "selectionMethod" => 1,
    "selectionRoot" => null,
    "selectionContentTypes" => []
];
```
