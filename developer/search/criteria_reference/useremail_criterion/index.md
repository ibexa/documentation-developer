# UserEmail Criterion

UserEmail Search Criterion

The [`UserEmail` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/UserEmail.php) searches for content based on the email assigned to the user account.

## Arguments

- `value` - string(s) representing the User email(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserEmail(['johndoe']);
```

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserEmail('nospam*', Criterion\Operator::LIKE);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <UserEmailCriterion>j.black*</UserEmailCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "UserEmailCriterion": "j.black*"
    }
}
```
