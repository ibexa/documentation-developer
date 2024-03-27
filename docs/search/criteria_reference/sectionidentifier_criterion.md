# SectionIdentifier Criterion

The [`SectionIdentifier` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-SectionIdentifier.html)
searches for content based on the identifier of the Section it is assigned to.

## Arguments

- `value` - string(s) representing the identifiers of the Section(s)

## Example

### PHP

``` php
$query->query = new Criterion\SectionIdentifier(['sports', 'news']);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SectionIdentifierCriterion>sports</SectionIdentifierCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SectionIdentifierCriterion": "sports"
        }
    }
    ```