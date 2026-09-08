---
description: Ancestor Search Criterion
---

# Ancestor Criterion

The `Ancestor` Search Criterion searches for content that is an ancestor of the provided location, including this location.

## Arguments

- `value` - array of location pathStrings

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <AncestorCriterion>/81/82/</AncestorCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "AncestorCriterion": "/81/82/"
        }
    }
    ```

## Use case

You can use the `Ancestor` Search Criterion to create a list of breadcrumbs leading to a location, because it matches every ancestor of that location, including the location itself.
