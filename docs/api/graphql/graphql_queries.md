---
description: Use GraphQL to query for content and Locations.
---

# GraphQL queries

## Querying content

You can query a single Content item or a list of Content items using fields defined in the domain schema.

### Get a Content item

To get a specific Content item by its content ID, Location ID, or URL alias, use its relevant singular field,
for example `article`, `folder`, `image`, etc.:

```
{
  content {
    article (contentId: 62) {
      title
      author {
        name
      }
    }
  }
}
```

Response:

```
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

You can request any Fields of the Content item. In the example above, these are `title` and `author`.

You can also query the generic `item` object.
The `item` object references a Content item, but you can also get its [Location information](#querying-locations).
The query accepts `locationId`, `remoteId`, and `urlAlias` as arguments.

```
{
  item (locationId: 2) {
    _name
  }
}
```

Response:

```
{
  "data": {
    "item": {
      "_name": "Ibexa Digital Experience Platform"
    }
  }
}
```

#### Get language versions

To get Fields of a Content item in a specific language, use the `language` argument.
The language must be configured for the current SiteAccess.

```
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

```
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

When you do not specify a language, the response contains the most prioritized translation.

### Get a group of Content items

To get a list of all Content items of a selected type, use the plural field, e.g. `articles`:

```
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

```
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

### Get Content Type information

To get the IDs and names of all Fields in the `article` Content Type:

```
{
  content {
    _types {
      article{
        _info {
          fieldDefinitions{
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

```
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

- the Location specified in the `locationId` or `urlAlias` argument
- the Location based on the current SiteAccess
- the main Location

```
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

```
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

To query the URL alias of a Content item, use `_url`.
This returns the "best" URL alias for this Content item based on its main Location and the current SiteAccess:

```
{
  content {
    folder (contentId: 1) {
      _url
    }
  }
}
```

Response:

```
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

To get a [Location's](#querying-locations) children,
it is recommended to use the [Query Field](content_queries.md#content-query-field).

Alternatively, you can query the `children` property of an `item` or `content` object:

```
{
  item (locationId: 2) {
    _location{
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

```
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

    You need to use aliases (for example, `sizeValue`) when querying attributes by the attribute type
    due to the conflicting return types.

Response:

```
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

```
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

```
articles(sortBy:[_datePublished,_desc])
```

## Pagination

GraphQL offers [cursor-based pagination](https://graphql.org/learn/pagination/) for paginating query results.

You can paginate plural fields using `edges`:

```
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
If the current `Connection` (list of results) is not finished yet and there are more items to read,
`hasNextPage` will be `true`.

For the `children` node, you can use the following pagination method:

```
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

```
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

```
children(first: 3, after: "YXJyYXljb25uZWN0aW9uOjM=")
```

### Get Matrix Field Type

To get a Matrix Field Type with GraphQL, see [Matrix Field Type reference](matrixfield.md).
