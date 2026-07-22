---
description: ContentName Search Criterion
---

# ContentName Criterion

The [`ContentName` Search Criterion](https://github.com/ibexa/core/blob/5.0/src/contracts/Repository/Values/Content/Query/Criterion/ContentName.php) searches for content by its name.

## Arguments

- `value` - string representing the content name, the wildcard character `*` can be used for partial search

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
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
