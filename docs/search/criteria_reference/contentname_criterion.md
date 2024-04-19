# ContentName Criterion

The [`ContentName` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentName.php)
searches for content by its name.

## Arguments

- `value` - int(s) representing the Content name

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
            <ContentNameCriterion>laptop</ContentNameCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentNameCriterion": "laptop"
        }
    }
    ```