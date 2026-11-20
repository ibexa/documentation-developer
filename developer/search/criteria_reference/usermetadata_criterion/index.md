# UserMetadata Criterion

UserMetadata Search Criterion

The [`UserMetadata` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/UserMetadata.php) searches for content based on its creator or modifier.

## Arguments

- `target` - UserMetadata constant (OWNER, GROUP, MODIFIER); GROUP means the user group of the content item's creator
- `operator` - Operator constant (EQ, IN)
- `value` - int(s) representing the User IDs or user group IDs (in case of the UserMetadata::GROUP target)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserMetadata(Criterion\UserMetadata::GROUP, Criterion\Operator::EQ, 12);
```

### REST API

**XML**

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

**JSON**

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

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

// ID of your custom Contributor User Group
$contributorGroupId = 32;

$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd(
    [
        new Criterion\ContentTypeIdentifier('blog_post'),
        new Criterion\UserMetadata(Criterion\UserMetadata::GROUP, Criterion\Operator::EQ, $contributorGroupId),
    ]
);
```
