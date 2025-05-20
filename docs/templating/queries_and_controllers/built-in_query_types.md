---
description: Use built-in Query types to quickly query content items in templates.
page_type: reference
---

# Built-in Query types

## General Query type parameters

All built-in Query types take the following optional parameters:

- `limit` - maximum number of results to return
- `offset` - offset for search hits, used for paginating the results
- `sort` - [sort order](#sort-order)
- `filter` - additional query filters:
    - `content_type` - return only results of given content types
    - `visible_only` - return only visible results (default `true`)
    - `siteaccess_aware` - return only results limited to the current SiteAccess root (default `true`)

For example:

``` yaml
params:
    query:
        query_type: 'Children'
        parameters:
            content: '@=content'
            filter:
                content_type: ['blog_post']
                visible_only: false
            limit: 5
            offset: 2
            sort: 'content_name asc, date_published desc'
        assign_results_to: items
```

### Sort order

To provide a sort order to the `sort` parameter, use names of the Sort Clauses.
To find them, refer to [Sort Clause](sort_clause_reference.md) and the [relevant Sort Clause class](https://github.com/ibexa/core/blob/4.6/src/bundle/Core/Resources/config/sort_spec.yml#L29)

## Children

The `Children` Query type retrieves children of the given location.

It takes `location` or `content` as parameters.

``` yaml
params:
    query:
        query_type: 'Children'
        parameters:
            content: '@=content'
        assign_results_to: items
```

!!! tip

    For an example of using the `Children` Query type, see [List content](list_content.md#list-children-with-query-type).

## Siblings

The `Siblings` Query type retrieves locations that have the same parent as the provided content item or location.

It takes `location` or `content` as parameters.

``` yaml
params:
    query:
        query_type: 'Siblings'
        parameters:
            content: '@=content'
        assign_results_to: items
```

!!! tip

    For an example of using the `Siblings` Query type, see [Embed related content](embed_content.md#embed-siblings-with-query-type).

## Ancestors

The `Ancestors` Query type retrieves all ancestors (direct parents and their parents) of the provided location.

It takes `location` or `content` as parameters.

``` yaml
params:
    query:
        query_type: 'Ancestors'
        parameters:
            content: '@=content'
        assign_results_to: items
```

## RelatedToContent

The `RelatedToContent` Query type retrieves content that is a reverse relation to the provided content item.

!!! tip

    Reverse relations mean that the Query type shows content items that are *related to* the provided content item.
    For example, if a blog post contains a link to an article, you can use a `RelatedToContent` query to find the blog post from the article.
    To find all relations of a content item (in this example, all content that the blog post is related to), refer to [Embed content](embed_content.md#embed-relations-with-a-custom-controller).

It takes `content` or `field` as required parameters.
`field` indicates the Relation or RelationList field that contains the relations.

``` yaml
params:
    query:
        query_type: 'RelatedToContent'
        parameters:
            content: '@=content'
            field: 'relations'
        assign_results_to: items
```

## GeoLocation

The `GeoLocation` Query type retrieves content by distance of the location provided in a MapLocation field.

It takes the following parameters:

- `field` - MapLocation field identifier
- `distance` - distance to check for
- `latitude` and `longitude` - coordinates of the location to check distance to
- (optional) `operator` - operator to check value against, by default `<=`

``` yaml
params:
    query:
        query_type: 'GeoLocation'
        parameters:
            field: 'location'
            distance: 200
            latitude: '@=content.getFieldValue("location").latitude'
            longitude: '@=content.getFieldValue("location").longitude'
            operator: '<'
        assign_results_to: items
```

## Catalog

The `Catalog` Query type retrieves products belonging to a [catalog](catalogs.md).

It takes the following parameters:

- `identifier` - identifier of the catalog

``` yaml
params:
    query:
        query_type: 'Catalog'
        parameters:
            identifier: 'promo'
        assign_results_to: products
```
