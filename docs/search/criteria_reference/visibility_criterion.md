# Visibility Criterion

The [`Visibility` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/Visibility.php)
searches for content based on whether it is visible or not.

This Criterion takes into account both hiding content and hiding Locations.

When used with Content Search, the Criterion takes into account all assigned Locations.
This means that hidden content will be returned if it has at least one visible Location.
Use Location Search to avoid this.

## Arguments

- `value` - Visibility constant (VISIBLE, HIDDEN)

## Example

``` php
$query->query = new Criterion\Visibility(Criterion\Visibility::HIDDEN);
```
