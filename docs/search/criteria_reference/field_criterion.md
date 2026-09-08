---
description: Field Search Criterion
---

# Field Criterion

The `Field` Search Criterion searches for content based on the content of one of its fields.

## Arguments

- `target` - string representing the identifier of the field to query
- `operator` - operator constant (IN, EQ, GT, GTE, LT, LTE, LIKE, BETWEEN, CONTAINS)
- `value` - the value to query for

The `LIKE` operator works together with wildcards (`*`). Without a wildcards its results are the same as for the `EQ` operator.

The `CONTAINS` operator works with collection fields like the Country field type, enabling you to retrieve results when the query value is one of the values of the collection.
Querying for a collection with the `EQ` operator returns result only when the whole collection equals the query values.

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <Field>
                <name>name</name>
                <operator>CONTAINS</operator>
                <value>Platform</value>
            </FieldCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
        "Query": {
            "Filter": {
                "Field": {
                    "name": "name",
                    "operator": "CONTAINS",
                    "value": "Platform"
                }
            }
        }
    }
    ```

## Use case

You can use the `Field` Criterion to search for articles whose `name` field contains the word "Featured", by combining it with a content type Criterion and the `CONTAINS` operator.
