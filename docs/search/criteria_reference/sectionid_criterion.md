# SectionId Criterion

The [`SectionId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/SectionId.php)
searches for content based on the ID of the Section it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Section(s)

## Example

``` php
$query->query = new Criterion\SectionId(3);
```
