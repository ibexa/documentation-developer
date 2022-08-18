# ContentTypeGroupId Criterion

The [`ContentTypeGroupId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeGroupId.php)
searches for content based on the ID of its Content Type group.

## Arguments

- `value` - int(s) representing the Content Type group ID(s).

## Example

``` php
$query->query = new Criterion\ContentTypeGroupId([1, 2]);
```

## Use case

You can use the `ContentTypeGroupId` Criterion to query all Media Content items
(the default ID for the Media Content Type group is 3):

``` php hl_lines="1"
        $query->query = new Criterion\ContentTypeGroupId([3]);

        $results = $this->searchService->findContent($query);
        $media = [];
        foreach ($results->searchHits as $searchHit) {
            $media[] = $searchHit;
        }
    }
```
