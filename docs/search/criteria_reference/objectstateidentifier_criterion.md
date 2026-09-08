---
description: ObjectStateIdentifier Search Criterion
---

# ObjectStateIdentifier Criterion

The `ObjectStateIdentifier` Search Criterion searches for content based on its object state identifier.

## Arguments

- `value` - string(s) representing the object state identifier(s)
- `target` (optional for PHP)  - string representing the object state group

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdentifierCriterion>
                <value>not_locked</value>
                <target>ibexa_lock</target>
            </ObjectStateIdentifierCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
      "Query": {
        "Filter": {
          "ObjectStateIdentifierCriterion": {
            "value": "not_locked",
            "target": "ibexa_lock"
          }
        }
      }
    }
    ```
