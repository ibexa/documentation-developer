# ContentId Criterion

The [`ContentId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentId.php)
searches for content by its ID.

## Arguments

- `value` - int(s) representing the Content ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ContentId([62, 64]);
```

### REST

=== "XML"

    ```xml
      <Query>
        <Filter>
            <ContentIdCriterion>[69, 72]</ContentIdCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentIdCriterion": [69, 72]
            }
        }
    ```