# ContentId Criterion

The [`ContentId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentId.html)
searches for content by its ID.

## Arguments

- `value` - int(s) representing the Content ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ContentId([62, 64]);
```

### REST API

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