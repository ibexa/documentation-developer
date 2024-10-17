---
description: ContentTypeIdentifier Search Criterion
edition: commerce
---

# ContentTypeIdentifier Criterion

The [`ContentTypeIdentifier` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentTypeId.html) searches for content based on the identifier of its content type.

## Arguments

- `value` - string(s) representing the content type identifier(s)

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