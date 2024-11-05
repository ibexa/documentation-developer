# AttributeName Criterion

The `AttributeName` Search Criterion searches for products by the value of their attribute name.

## Arguments

- `value` - string representing the attribute's name

## Example

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <AttributeNameCriterion>measure</AttributeNameCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
      "AttributeQuery": {
        "Query": {
          "AttributeNameCriterion": "measure"
        }
      }
    }
    ```