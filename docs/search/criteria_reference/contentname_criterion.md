---
description: ContentName Search Criterion
---

# ContentName Criterion

The [`ContentName` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentName.html) searches for content by its name.

## Arguments

- `value` - string representing the content name, the wildcard character `*` can be used for partial search

## Example

### PHP

``` php
$query->query = new Criterion\ContentName('*phone');
```

### REST API

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
