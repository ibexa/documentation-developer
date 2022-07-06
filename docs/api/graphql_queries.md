---
description: Use GraphQL to query for content and Locations.
---

# GraphQL queries

## Querying content

You can query a single Content item or a list of Content items using fields defined in the domain schema.

### Get a Content item

To get a specific Content item by its ID, use its relevant singular field,
for example `article`, `folder`, `image`, etc.:

```
{
  content {
    article (id: 55) {
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

To query a Location and its children, use the repository schema:

```
{
  _repository {
    location(locationId: 2) {
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

The query accepts `locationId`, `remoteId`, and `urlAlias` as arguments.

Response:

```
{
  "data": {
    "_repository": {
      "location": {
        "children": {
          "edges": [
            {
              "node": {
                "content": {
                  "_name": "About us",
                  "_type": {
                    "name": "About"
                  }
                }
              }
            },
            {
              "node": {
                "content": {
                  "_name": "Travel literature, How to get started",
                  "_type": {
                    "name": "Article"
                  }
                }
              }
            }
          ]
        }
      }
    }
  }
}
```

You can also query the children of a Content item:

```
{
  content {
    folder(id: 1) {
      name
      _location {
        children {
          edges {
            # ...
          }
        }
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

To get a Matrix Field Type with GraphQL, see [Matrix Field Type reference](field_types_reference/matrixfield.md).
