---
description: UserMetadataTermAggregation
---

# UserMetadataTermAggregation

The UserMetadataTermAggregation aggregates search results by the User content item's metadata.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\UserMetadataTermAggregation('user_metadata');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
