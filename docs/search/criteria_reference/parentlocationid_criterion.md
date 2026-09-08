---
description: ParentLocationId Search Criterion
---

# ParentLocationId Criterion

The `ParentLocationId` Search Criterion
searches for content based on the Location ID of its parent.

## Arguments

- `value` - int(s) representing the parent location IDs

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ParentLocationIdCriterion>[81, 82]</ParentLocationIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ParentLocationIdCriterion": [69, 72]
        }
    }
    ```

## Use case

You can use the `ParentLocationId` Search Criterion to list blog posts contained in a blog, by combining it with the `Visibility` Criterion so that hidden posts are excluded.
