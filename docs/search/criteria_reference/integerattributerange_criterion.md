# IntegerAttributeRange Criterion

The `IntegerAttributeRange` Search Criterion searches for products by the range of values of their integer attribute.

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
            <IntegerAttributeRangeCriterion>
                <identifier>length</identifier>
                <min>16</min>
                <max>25</max>
            </IntegerAttributeRangeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
        "AttributeQuery": {
            "Query": {
                "IntegerAttributeRangeCriterion": {
                    "identifier": "length",
                    "min": 16,
                    "max": 25
                }
            }
        }
    }
    ```