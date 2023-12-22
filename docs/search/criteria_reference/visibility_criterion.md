# Visibility Criterion

The [`Visibility` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Visibility.html)
searches for content based on whether it is visible or not.

This Criterion takes into account both hiding content and hiding Locations.

When used with Content Search, the Criterion takes into account all assigned Locations.
This means that hidden content will be returned if it has at least one visible Location.
Use Location Search to avoid this.

## Arguments

- `value` - Visibility constant (VISIBLE, HIDDEN)

## Example

### PHP

``` php
$query->query = new Criterion\Visibility(Criterion\Visibility::HIDDEN);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <VisibilityCriterion>HIDDEN</VisibilityCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentIdCriterion": "HIDDEN"
        }
    }
    ```