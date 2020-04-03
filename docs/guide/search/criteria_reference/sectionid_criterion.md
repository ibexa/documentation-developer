# SectionId Criterion

The [`SectionId` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/SectionId.php)
searches for content based on the ID of the Section it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Section(s)

## Example

``` php
$query->query = new Criterion\SectionId(3);
```
