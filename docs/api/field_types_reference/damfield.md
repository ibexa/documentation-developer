# DAM Field Type

This Field Type stores asset information from a DAM system.
It replaces the [ImageAsset Field Type](field_types_reference/imageassetfield.md).

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Image Asset` | `ezimageasset`      | mixed             |

### Value object

##### Properties

Value object of `dam` contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `destinationContentId`  |  `string` | Related content ID. |
| `alternativeText`  |  `string` |  The alternative image text. |
| `source` | `string` | Source of the DAM asset. |
