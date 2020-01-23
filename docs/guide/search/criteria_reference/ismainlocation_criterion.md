# IsMainLocation Criterion

The [`IsMainLocation` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LanguageCode.php)
searches for Locations based on whether they are the main Location of a Content item or not.

This Criterion is available only for Location Search.

## Arguments

- `value` - `IsMainLocation::MAIN` (0) or `IsMainLocation::NOT_MAIN` (1),
representing whether to search for a main or not main Location

## Example

``` php
$query->query = new Criterion\Location\IsMainLocation(IsMainLocation::MAIN);
```
