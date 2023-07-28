# AttributeGroupIdentifier Criterion

The `AttributeGroupIdentifier` Search Criterion searches for products by the value of their attribute group identifier.

## Arguments

- `value` - string representing the attribute's identifier

## Example

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <AttributeGroupIdentifier>attribute_group</AttributeGroupIdentifier>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
      "AttributeQuery": {
        "Query": {
          "AttributeGroupIdentifier": "attribute_group"
        }
      }
    }
    ```