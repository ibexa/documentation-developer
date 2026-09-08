---
description: DateMetadata Search Criterion
---

# DateMetadata Criterion

The `DateMetadata` Search Criterion searches for content based on the date when it was created or last modified.

## Arguments

- `target` - indicating if publication or modification date should be queried, either `DateMetadata::CREATED` or `DateMetadata::PUBLISHED` (both with the same functionality), or `DateMetadata::MODIFIED`
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - indicating the date(s) that should be matched, provided as a UNIX timestamp (or array of timestamps)

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <DateMetadataCriterion>
                <Target>modified</Target>
                <Value>1675681020</Value>
                <Operator>gte</Operator>
            </DateMetadataCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
        "Query": {
            "Filter": {
                "DateMetadataCriterion": {
                    "Target": "modified",
                    "Value": 1675681020,
                    "Operator": "gte"
                }
            }
        }
    ```

## Use case

You can use the `DateMetadata` Criterion to search for blog posts that have been created within the last week, by combining it with a content type Criterion and the `GTE` operator.
