# UserMetadata Criterion

The [`UserMetadata` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserMetadata.php)
searches for content based on its creator or modifier.

## Arguments

- `target` - UserMetadata constant (OWNER, GROUP, MODIFIER); GROUP means the User Group of the Content item's creator
- `operator` - Operator constant (EQ, IN)
- `value` - int(s) representing the User IDs or User Group IDs (in case of the UserMetadata::GROUP target)

## Example

### PHP

``` php
$query->query = new Criterion\UserMetadata(Criterion\UserMetadata::GROUP, Criterion\Operator::EQ, 12);
```

### REST API

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

You can use the `UserMetadata` Criterion to search for blog posts created by the Contributor user group:

``` php hl_lines="7"
// ID of your custom Contributor User Group
$contributorGroupId = 32;

$query = new LocationQuery;
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('blog_post'),
        new Criterion\UserMetadata(Criterion\UserMetadata::GROUP, Criterion\Operator::EQ, $contributorGroupId)
    ]
);
```
