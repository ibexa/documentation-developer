# Relation field type

This field type makes it possible to store and retrieve the value of a relation to another content item.

| Name       | Internal name      | Expected input |
|------------|--------------------|----------------|
| `Relation` | `ezobjectrelation` | mixed        |

## PHP API field type

### Input expectations

|Type|Example|
|------|------|
|`string`|`"150"`|
|`integer`|`150`|

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property|Type| Description|
|---------|-----|-----------|
| `$destinationContentId` | `string|int|null` | This property is used to store the value provided, which represents the related content. |

``` php
// Value object content example

$relation->destinationContentId = $contentInfo->id;
```

##### Constructor

The `Relation\Value` constructor initializes a new Value object with the value provided. It expects a mixed value.

``` php
// Constructor example

// Instantiates a Relation Value object
$relationValue = new Relation\Value( $contentInfo->id );
```

### Validation

This field type validates whether the provided relation exists, but before that it checks that the value is either a string or an int.

### Settings

The Field definition of this field type can be configured with three options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`selectionMethod`|`int`|`Relation\Type::SELECTION_BROWSE`| *This setting is not implemented yet, only one selection method is available.* |
|`selectionRoot`|`string`|`null`|This setting defines the selection root.|
|`selectionContentTypes`|`array`|`[]`|An array of content type IDs that are allowed for related Content.|

``` php
// Relation FieldType example settings

use Ibexa\Core\FieldType\Relation\Type;

$settings = [
    "selectionMethod" => 1,
    "selectionRoot" => null,
    "selectionContentTypes" => []
];
```
