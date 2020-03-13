# Sibling Criterion

The [`Sibling` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Sibling.php)
searches for content under the same parent as the indicated Location.

## Arguments

- `locationId` - int representing the Location ID.
- `parentLocationId` - int representing the parent Location ID.

## Example

``` php
$query->query = new Criterion\Sibling(59, 2);
```
