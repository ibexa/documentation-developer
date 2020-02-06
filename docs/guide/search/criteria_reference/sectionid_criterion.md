# SectionId Criterion

The [`SectionId` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/6.13.7/eZ/Publish/API/Repository/Values/Content/Query/Criterion/SectionId.php)
searches for content based on the Section it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Section(s)

## Example

``` php
$query->query = new Criterion\SectionId(3);
```
