# SectionId Criterion

The [`SectionId` URL Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/Criterion/SectionId.php)
matches URLs based on the ID of the related content Section.

## Arguments

- `sectionIds` - array of ints representing the IDs of the related content Sections

## Example

``` php
$query->filter = new Criterion\SectionId(['1', '3']);
```
