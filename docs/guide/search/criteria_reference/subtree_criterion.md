# Subtree Criterion

The [`Subtree` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/6.13.7/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Subtree.php)
searches for content based on its subtree.
It will return the Content item and all the Content items below it in the subtree.

## Arguments

- `value` - string(s) representing the pathstring(s) to search for

## Example

``` php
$query->query = new Criterion\Subtree('/1/2/71/72/');
```
