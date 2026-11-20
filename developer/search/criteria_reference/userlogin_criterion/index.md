# UserLogin Criterion

UserLogin Search Criterion

The [`UserLogin` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/UserLogin.php) searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserLogin(['johndoe']);
```

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserLogin('adm*', Criterion\Operator::LIKE);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <UserLoginCriterion>johndoe</UserLoginCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "UserLoginCriterion": "johndoe"
    }
}
```
