# ContentTypeIdentifier Criterion

The [`ContentTypeIdentifier` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.php)
searches for content based on the identifier of its Content Type.

## Arguments

- `value` - string(s) representing the Content Type identifier(s)

## Example

### PHP

``` php
$query->query = new Criterion\ContentTypeIdentifier(['article', 'blog_post']);
```

### REST API

=== "XML"

    ```xml
      <Query>
        <Filter>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeIdentifierCriterion": "article"
            }
        }
    ```