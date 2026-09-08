---
description: ContentName Search Criterion
---

# ContentName Criterion

The [`ContentName` Search Criterion](https://github.com/ibexa/core/blob/6.0/src/contracts/Repository/Values/Content/Query/Criterion/ContentName.php) searches for content by its name.

## Arguments

- `value` - string representing the content name, the wildcard character `*` can be used for partial search

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentNameCriterion>*phone</ContentNameCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentNameCriterion": "*phone"
        }
    }
    ```
