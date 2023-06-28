# ContentTypeId Criterion

The [`ContentTypeId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeId.php)
searches for content based on the ID of its Content Type.

## Arguments

- `value` - int(s) representing the Content Type ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ContentTypeId([44]);
```

### REST API

=== "XML"

    ```xml
      <Query>
        <Filter>
            <ContentTypeIdCriterion>44</ContentTypeIdCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeIdCriterion": 44
            }
        }
    ```