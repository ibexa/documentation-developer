---
description: Use GraphQL to query for content and Locations.
---

# GraphQL queries

## Querying content

You can query a single content item or a list of content items using fields defined in the domain schema.

### Get a content item

To get a specific content item by its content ID, location ID, or URL alias, use its relevant singular field, for example `article`, `folder`, or `image`.

```graphql
{
  content {
    article(contentId: 62) {
      title
      author {
        name
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "article": {
        "title": "Travel literature, how to get started",
        "author": [
          {
            "name": "Administrator User"
          }
        ]
      }
    }
  }
}
```

You can request any fields of the content item. In the example above, these are `title` and `author`.

You can also query the generic `item` object.
The `item` object references a content item, but you can also get its [location information](#querying-locations).
The query accepts `locationId`, `remoteId`, and `urlAlias` as arguments.

```graphql
{
  item(locationId: 2) {
    _name
    ... on FolderItem {
        name
    }
    ... on LandingPageItem {
        name
    }
    ... on ArticleItem {
        title
    }
  }
}
```

Response:

```json
{
  "data": {
    "item": {
      "_name": "Ibexa Digital Experience Platform"
    }
  }
}
```

#### Get language versions

To get fields of a content item in a specific language, use the `language` argument.
The language must be configured for the current SiteAccess.

```graphql
{
  content {
    article(id: 57) {
      title: title(language: eng_GB)
      title_PL: title(language: pol_PL)
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "article": {
        "title": "Most interesting cat breeds",
        "title_PL": "Najciekawsze rasy kotów"
      }
    }
  }
}
```

When you don't specify a language, the response contains the most prioritized translation.

### Get a group of content items

To get a list of all content items of a selected type, use the plural field, for example, `articles`:

```graphql
{
  content {
    articles {
      edges {
        node {
          _location {
            id
          }
          title
          author {
            name
          }
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "articles": {
        "edges": [
          {
            "node": {
              "_location": {
                "id": 57
              },
              "title": "Travel literature, How to get started",
              "author": [
                {
                  "name": "Administrator User"
                }
              ]
            }
          },
          {
            "node": {
              "_location": {
                "id": 58
              },
              "title": "Why we love NYC",
              "author": [
                {
                  "name": "Administrator User"
                }
              ]
            }
          },
          # ...
        ]
      }
    }
  }
}
```

!!! tip "Edges"

    `edges` are used when querying plural fields to offer [pagination](#pagination).

### Get content type information

To get the IDs and names of all Fields in the `article` content type:

```graphql
{
  content {
    _types {
      article {
        _info {
          fieldDefinitions {
            id
            name
          }
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "_types": {
        "article": {
          "_info": {
            "fieldDefinitions": [
              {
                "id": 1,
                "name": "Title"
              },
              {
                "id": 152,
                "name": "Short title"
              },
              {
                "id": 153,
                "name": "Author"
              },
              {
                "id": 120,
                "name": "Intro"
              },
              {
                "id": 121,
                "name": "Body"
              },
              {
                "id": 123,
                "name": "Enable comments"
              },
              {
                "id": 154,
                "name": "Image"
              }
            ]
          }
        }
      }
    }
  }
}
```

## Querying Locations

You can get the Location object from any item by querying for `_location` or `_allLocations`.
When you use `_location`, the API returns:

- the location specified in the `locationId` or `urlAlias` argument
- the location based on the current SiteAccess
- the main location

```graphql
{
  content {
    folder (contentId: 133) {
      _allLocations {
        pathString
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "folder": {
        "_allLocations": [
          {
            "pathString": "/1/2/128/132/"
          },
          {
            "pathString": "/1/2/133/"
          }
        ]
      }
    }
  }
}
```

To query the URL alias of a content item, use `_url`.
This returns the "best" URL alias for this content item based on its main Location and the current SiteAccess:

```graphql
{
  content {
    folder (contentId: 1) {
      _url
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "folder": {
        "_url": "/site/ez-platform"
      }
    }
  }
}
```

## Getting children of a Location

To get a [location's](#querying-locations) children, it's recommended to use the [Query field](content_queries.md#content-query-field).

Alternatively, you can query the `children` property of an `item` or `content` object:

```graphql
{
  item(locationId: 2) {
    _location {
      children {
        edges {
          node {
            content {
              _name
              _type {
                name
              }
            }
          }
        }
      }
    }
  }
}
```
Response:

```json
{
  "data": {
    "item": {
      "_location": {
        "children": {
          "edges": [
            {
              "node": {
                "content": {
                  "_name": "Ibexa Platform",
                  "_type": {
                    "name": "Folder"
                  }
                }
              }
            },
            {
              "node": {
                "content": {
                  "_name": "Product Catalog",
                  "_type": {
                    "name": "Product catalog"
                  }
                }
              }
            }
          ]
        }
      }
    }
  }
```

## Querying products

You can query a single product, products of one type, or all products by providing criteria.

!!! note

    GraphQL schema for product catalog is generated only when at least one product type exists in the system.
    If your queries fail, make sure you regenerated the schema.

To get a single product by its code:

```graphql
{
  products {
    single(code: "DRESUN") {
      name
      productType {name}
      createdAt {
        timestamp
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "products": {
      "single": {
        "name": "Sundress",
        "productType": {
          "name": "Dress"
        },
        "createdAt": {
          "timestamp": 1649229733
        }
      }
    }
  }
}
```

To get products of a specific type:

```graphql
{
  products {
    byType {
  	  dresses {
        edges {
          node {
            name
            code
          }
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "products": {
      "byType": {
        "dresses": {
          "edges": [
            {
              "node": {
                "name": "Sundress",
                "code": "DRESUN"
              }
            },
            {
              "node": {
                "name": "Cocktail dress",
                "code": "DRECO"
              }
            }
          ]
        }
      },
    }
  }
}
```

To get all products, using specific criteria (in this case, unavailable products):

```graphql
{
  products {
    all(
      availability:unavailable
    	sortBy: [name]
    ) {
      edges {
        node {
          name
          code
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "products": {
      "all": {
        "edges": [
          {
            "node": {
              "name": "Cocktail dress",
              "code": "DRECO"
            }
          },
          {
            "node": {
              "name": "Sundress",
              "code": "DRESUN"
            }
          }
        ]
      }
    }
  }
}
```

## Filtering

To get all articles with a specific text:

```graphql
{
  content {
    articles(query: {Text:"travel"}) {
      edges {
        node {
          title
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "content": {
      "articles": {
        "edges": [
          {
            "node": {
              "title": "Travel literature, How to get started"
            }
          },
          {
            "node": {
              "title": "Travel with your dog"
            }
          }
        ]
      }
    }
  }
}
```

To filter products based on content fields:

```graphql
{
  products {
    all {
      edges {
        node {
          fields {
            ... on DressContentFields {
              name
              description {
                plaintext
              }
            }
            _all {
              fieldDefIdentifier
              value
            }
          }
        }
      }
    }
  }
}
```

### Querying product attributes

To filter products based on attributes:

```graphql
{
  products {
    single(code: "BLUELACE") {
      attributes {
        ... on DressAttributes {
          measure {
            reason
          }
          lace_color {
            identifier
            value
          }
        }
      }
    }
  }
}

```

If the attribute type (in this case, `measure`) cannot be found in the schema, the response is:

```json
{
  "data": {
    "products": {
      "single": {
        "attributes": {
          "measure": {
            "reason": "This attribute type isn't yet part of the schema."
          },
          "lace_color": {
            "identifier": "lace_color",
            "value": "#387be8"
          }
        }
      }
    }
  }
}
```

You can also query attributes by providing the attribute type:

```graphql
{
  products {
    all {
      edges {
        node {
          attributes {
            _all {
              ... on ColorAttribute {
                identifier
                name
                colorValue: value
              }
              ... on IntegerAttribute {
                identifier
                name
                sizeValue: value
              }
            }
          }
        }
      }
    }
  }
}
```

!!! note

    You need to use aliases (for example, `sizeValue`) when querying attributes by the attribute type due to the conflicting return types.

Response:

```json
{
  "data": {
    "products": {
      "all": {
        "edges": [
          {
            "node": {
              "attributes": {
                "_all": [
                  {
                    "identifier": "size",
                    "name": "Size",
                    "sizeValue": 36
                  },
                  {
                    "identifier": "color",
                    "name": "Color",
                    "colorValue": "#fcff38"
                  }
                ]
              }
            }
          },
          {
            "node": {
              "attributes": {
                "_all": [
                  {
                    "identifier": "color",
                    "name": "Color",
                    "colorValue": "#000000"
                  },
                  {
                    "identifier": "size",
                    "name": "Size",
                    "sizeValue": 40
                  }
                ]
              }
            }
          }
        ]
      }
    }
  }
}
```

## Sorting

You can sort query results using `sortBy`:

```graphql
{
  content {
    articles(sortBy: _datePublished) {
      edges {
        node {
          title
        }
      }
    }
  }
}
```

You can use an array of clauses as well. To reverse the item list, add `_desc` after the clause:

```graphql
articles(sortBy:[_datePublished,_desc])
```

## Pagination

GraphQL offers [cursor-based pagination](https://graphql.org/learn/pagination/) for paginating query results.

You can paginate plural fields by using `edges`:

```graphql
{
  content {
    articles(sortBy: _datePublished, first:3) {
      pageInfo {
        hasNextPage
        endCursor
      }
      edges {
        node {
          title
        }
      }
    }
  }
}
```

This query returns the first three articles, ordered by their publication date.
If the current `Connection` (list of results) isn't finished yet and there are more items to read, `hasNextPage` is `true`.

For the `children` node, you can use the following pagination method:

```graphql
{
  _repository {
    location(locationId: 2) {
      children(first: 3) {
        pages {
          number
          cursor
        }
        edges {
          node {
            content {
              _name
            }
          }
        }
      }
    }
  }
}
```

Response:

```json
{
  "data": {
    "_repository": {
      "location": {
        "children": {
          "pages": [
            {
              "number": 2,
              "cursor": "YXJyYXljb25uZWN0aW9uOjE="
            },
            {
              "number": 3,
              "cursor": "YXJyYXljb25uZWN0aW9uOjM="
            }
          ],
          "edges": [
            {
              # ...
            }
          ]
        }
      }
    }
  }
}
```

In the response, `number` contains page numbers, starting with 2 (because 1 is the default).

To request a specific page, provide the `cursor` as an argument to `children`:

```graphql
children(first: 3, after: "YXJyYXljb25uZWN0aW9uOjM=")
```

### Get Matrix field type

To get a Matrix field type with GraphQL, see [Matrix field type reference](matrixfield.md).

### Enable pagination for RelationList field type

To learn how to enable pagination for RelationList field type, see the [RelationList field type reference](relationlistfield.md).

### Url field type integration 

To learn how to customize the URL field type when using GraphQL, see the [URL field type reference](urlfield.md#graphql-integration).
