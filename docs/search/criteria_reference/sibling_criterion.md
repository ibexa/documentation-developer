---
description: Sibling Search Criterion
---

# Sibling Criterion

The [`Sibling` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Sibling.html) searches for content under the same parent as the indicated location.

## Arguments

- `locationId` - int representing the location ID
- `parentLocationId` - int representing the parent location ID

## Limitations

`Sibling` can be used on all search engines.

## Example

### PHP

```php
$query->query = new Criterion\Sibling(59, 2);

// Or using the named constructor
$location = $locationService->loadLocation(59);
$query->query = Criterion\Sibling::fromLocation($location);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SiblingCriterion>
                <locationId>85</locationId>
                <parentLocationId>81</parentLocationId>
            </SiblingCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SiblingCriterion": {
                "locationId": 85,
                "parentLocationId": 81
            }
        }
    }
    ```
