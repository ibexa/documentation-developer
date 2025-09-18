---
description: CreatedAt Search Criterion
---

# CreatedAt Search Criterion

The `CreatedAt` Search Criterion searches for invitations based on the date they were created.

## Arguments

- `value` - date to be matched, provided as a DateTimeInterface object
- `operator` - optional operator string (check the list of the allowed values: https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constants)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\CreatedAt(
    new DateTime('2025-05-01 14:07:02'),
    FieldValueCriterion:: COMPARISON_GTE
);

$query = new InvitationQuery($criteria);
```