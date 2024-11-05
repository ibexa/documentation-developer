# SectionId Criterion

The [`SectionId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-SectionId.html)
searches for content based on the ID of the Section it is assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Section(s)

## Example

### PHP

``` php
$query->query = new Criterion\SectionId(3);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SectionIdCriterion>3</SectionIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SectionIdCriterion": "3"
        }
    }
    ```