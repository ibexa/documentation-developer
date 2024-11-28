---
description: ObjectStateId Search Criterion
---

# ObjectStateId Criterion

The [`ObjectStateId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ObjectStateId.html) searches for content based on its object state ID.

## Arguments

- `value` - int(s) representing the object state ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ObjectStateId([4, 5]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdCriterion>1</ObjectStateIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ObjectStateIdCriterion": "1"
        }
    }
    ```