# DateMetadata Criterion

The [`DateMetadata` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/DateMetadata.php)
searches for content based on the date when it was created or last modified.

## Arguments

- `target` - indicated if creation or modification date should be queried, either `DateMetadata::CREATED` or `DateMetadata::MODIFIED`
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - indicating the date(s) that should be matched, provided as a UNIX timestamp (or array of timestamps)

## Example

``` php
$query->query = new Criterion\DateMetadata(
    Criterion\DateMetadata::CREATED,
    Criterion\Operator::BETWEEN,
    [1576800000, 1576972800]
);
```

## Use case

You can use the `DateMetadata` Criterion to search for blog posts that have been created within the last week:

``` php hl_lines="5"
$query = new LocationQuery;
$date = strtotime("-1 week");
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('blog_post'),
        new Criterion\DateMetadata(Criterion\DateMetadata::CREATED, Criterion\Operator::GTE, $date),
    ]
);
```
