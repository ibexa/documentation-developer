# Subtree Criterion

The [`Subtree` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Subtree.html)
searches for content based on its Location ID subtree path.
It returns the Content item and all the Content items below it in the subtree.

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