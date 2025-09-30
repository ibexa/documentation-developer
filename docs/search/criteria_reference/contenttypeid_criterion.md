---
description: ContentTypeId Search Criterion
---

# ContentTypeId Criterion

The [`ContentTypeId` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentTypeId.html) searches for content based on the ID of its content type.

## Arguments

- `value` - int(s) representing the content type ID(s)

## Limitations

`ContentTypeId` can be used on all search engines.

## Example

### PHP

```php
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
    {
        "ViewInput": {
            "identifier": "ContentTypeIdCriterionTest",
            "Query": {
                "Filter": {
                    "ContentTypeIdCriterion": 44
                }
            }
        }
    }
    ```
