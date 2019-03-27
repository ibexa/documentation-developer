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

## Pagination

GraphQL offers [cursor-based pagination](https://graphql.org/learn/pagination/) for paginating query results.

You can paginate plural fields using `edges`:

```
{
  content {
    articles(sortBy: _datePublished, first:3) {
      pageInfo {
        hasNextPage
        endcursor
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
