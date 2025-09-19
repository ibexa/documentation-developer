---
description: Notification DateCreated Search Criterion
month_change: true
---

# Notification DateCreated Criterion

The `DateCreated` Search Criterion searches for notifications based on the date when they were created.

## Arguments

- `created` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (GTE, LTE)

## Example

### PHP

```php hl_lines="14-15 17"
[[= include_file('code_samples/notifications/Src/Query/search.php') =]]
```
