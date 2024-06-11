# ContentName Criterion

The [`ContentName` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentName.php)
searches for content by its name.

## Arguments

- `value` - string(s) representing the Content name(s), the joker `*` can be used for partial search.

## Example

### PHP

``` php
$query->query = new Criterion\ContentName(['laptop', 'tablet']);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <OR>
                <ContentNameCriterion>laptop</ContentNameCriterion>
                <ContentNameCriterion>tablet</ContentNameCriterion>
            </OR>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentNameCriterion": ["laptop", "tablet"]
        }
    }
    ```