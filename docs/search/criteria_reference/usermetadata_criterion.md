---
description: UserMetadata Search Criterion
---

# UserMetadata Criterion

The `UserMetadata` Search Criterion searches for content based on its creator or modifier.

## Arguments

- `target` - UserMetadata constant (OWNER, GROUP, MODIFIER); GROUP means the user group of the content item's creator
- `operator` - Operator constant (EQ, IN)
- `value` - int(s) representing the User IDs or user group IDs (in case of the UserMetadata::GROUP target)

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserMetadataCriterion>
                <target>GROUP</target>
                <operator>EQ</operator>
                <value>12</value>
            </UserMetadataCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
        "Query": {
            "Filter": {
                "UserMetadataCriterion": {
                    "target": "GROUP",
                    "operator": "EQ",
                    "value": 12
                }
            }
        }
    }
    ```

## Use case

You can use the `UserMetadata` Criterion to search for blog posts created by a specific user group, such as Contributor, by using the `GROUP` target with the `EQ` operator.
