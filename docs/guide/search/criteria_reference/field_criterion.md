# Field Criterion

`Field` Search Criterion searches for content based on the content of one of its Fields.

## Arguments

- `target` - string representing the identifier of the Field to query
- `operator` - operator constant (IN, EQ, GT, GTE, LT, LTE, LIKE, BETWEEN, CONTAINS)
- `value` - the value to query for

The `LIKE` operator works together with wildcards (`*`). Without a wildcards its results are the same as for the `EQ` operator.

The `CONTAINS` operator works with collection Fields like the Country Field Type,
enabling you to retrieve results when the query value is one of the values of the collection.
Querying for a collection with the `EQ` operator will return result only when the whole collection equals the query values.

In Solr search engine, the `CONTAINS` operator used on Fields that are not collections will return the same results as the `EQ` operator.
In Legacy search engine, the `CONTAINS` operator used on Field that are not collections will return the same results as the `EQ` operator.

## Example

``` php
$query->query = new Criterion\Field('name', Criterion\Operator::CONTAINS, 'Platform');
```

## Use case

You can use the `Field` Criterion to search for articles that contain the word "featured":

``` php hl_lines="4"
$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\Field('name', Criterion\Operator::CONTAINS, 'Featured')
    ]
);
```
