# IsUserBased Criterion

IsUserBased Search Criterion

The [`IsUserBased` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/IsUserBased.php) searches for content that plays the role of a User account.

> **Note: Note**
>
> In the default setup only the user content type is treated as user accounts. However, you can also [set other content types to be treated as such](../../../administration/configuration/repository_configuration/index.md#user-identifiers).

## Arguments

- (optional) `value` - bool representing whether to search for User-based (default `true`) or non-User-based content

## Limitations

The `IsUserBased` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\IsUserBased();
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <IsUserBasedCriterion>false</IsUserBasedCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "IsUserBasedCriterion": "false"
    }
}
```
