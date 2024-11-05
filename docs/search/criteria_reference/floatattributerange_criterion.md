# FloatAttributeRange Criterion

The `FloatAttributeRange` Search Criterion searches for products by the range of values of their float attribute.

## Arguments

- `identifier` - string representing the attribute
- `min` - indicating the beginning of the range
- `max` - indicating the end of the date range

## Example

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <FloatAttributeRangeCriterion>
                <identifier>length</identifier>
                <min>16.5</min>
                <max>25</max>
            </FloatAttributeRangeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
        "AttributeQuery": {
            "Query": {
                "FloatAttributeRangeCriterion": {
                    "identifier": "length",
                    "min": 16.5,
                    "max": 25
                }
            }
        }
    }
    ```