---
description: UserEmail Search Criterion
---

# UserEmail Criterion

The `UserEmail` Search Criterion searches for content based on the email assigned to the user account.

## Arguments

- `value` - string(s) representing the User email(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserEmailCriterion>j.black*</UserEmailCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserEmailCriterion": "j.black*"
        }
    }
    ```
