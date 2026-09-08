---
description: UserLogin Search Criterion
---

# UserLogin Criterion

The `UserLogin` Search Criterion searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserLoginCriterion>johndoe</UserLoginCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserLoginCriterion": "johndoe"
        }
    }
    ```
