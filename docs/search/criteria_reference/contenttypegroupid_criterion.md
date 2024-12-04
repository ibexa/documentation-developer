---
description: ContentTypeGroupId Search Criterion
---

# ContentTypeGroupId Criterion

The [`ContentTypeGroupId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentTypeGroupId.html) searches for content based on the ID of its content type group.

## Arguments

- `value` - int(s) representing the content type group ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ContentTypeGroupId([1, 2]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentTypeGroupIdCriterion>[1, 2]</ContentTypeGroupIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeGroupIdCriterion": [1, 2]
        }
    }
    ```

## Use case

You can use the `ContentTypeGroupId` Criterion to query all Media content items
(the default ID for the Media content type group is 3):

``` php hl_lines="1"
        $query->query = new Criterion\ContentTypeGroupId([3]);

        $results = $this->searchService->findContent($query);
        $media = [];
        foreach ($results->searchHits as $searchHit) {
            $media[] = $searchHit;
        }
    }
```

### REST API

=== "XML"

    ```xml
      <Query>
        <Filter>
            <ContentIdCriterion>[69, 72]</ContentIdCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentIdCriterion": [69, 72]
            }
        }
    ```