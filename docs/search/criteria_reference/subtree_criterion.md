---
description: Subtree Search Criterion
---

# Subtree Criterion

The [`Subtree` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Subtree.html) searches for content based on its location ID subtree path.
It returns the content item and all the content items below it in the subtree.

## Arguments

- `value` - string(s) representing the pathstring(s) to search for

## Example

### PHP

``` php
$query->query = new Criterion\Subtree('/1/2/71/72/');
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SubtreeCriterion>/1/2/71/</SubtreeCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SubtreeCriterion": "/1/2/71/"
        }
    }
    ```
