# GraphQL

[GraphQL](https://graphql.org/) is a query language for the API.
The GraphQL implementation for eZ Platform is located in [`ezsystems/ezplatform-graphql`](https://github.com/ezsystems/ezplatform-graphql).

## Setup

To use GraphQL, you need to generate the domain schema:

``` bash
php bin/console ezplatform:graphql:generate-schema
php bin/console cache:clear
```

This produces YAML files located in `app/config/graphql/ezplatform`.
They contain the information about the domain objects and the fields you can query.

Every time you modify Content Types in your installation, you need to regenerate the schema
using the command above.

## Domain schema

GraphQL for eZ Platform is based on the Content Types, Content Type groups and Content items
defined in the repository.

TODO: expand this section

## Authentication

TODO

## Usage

You can access GraphQL with `<yourdomain>/graphql`.

### GraphiQL client

You can also make use of the included [GraphiQL interactive client](https://github.com/graphql/graphiql).
Access it through `<yourdomain>/graphiql`.

Here you can run your queries and preview the results in an easy-to-read format.

### Reference

GraphiQL offers side-by-side reference based on your generated schema in the **Docs** pane.

## Queries

### Examples

#### Get all articles

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

#### Get Content Type information

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

### Filtering

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

### Sorting

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

TODO: natural filtering https://github.com/ezsystems/ezplatform-graphql/pull/5

## Pagination

GraphQL offers [cursor-based pagination](https://graphql.org/learn/pagination/) for paginating query results.

You can paginate plural fields using `edges`:

```
{
  content {
    articles(sortBy: _datePublished, first:3) {
      pageInfo {
        hasNextPage
      }
      edges {
        cursor
        node {
          title
        }
      }
    }
  }
}
```

This query reads the first three articles, ordered by publication date.
If the current connection (list of results) is not finished yet and that there are more items to read,
`hasNextPage` will be `true`.

## Customization (custom field types, custom domain objects)

TODO: custom application schema https://github.com/ezsystems/ezplatform-graphql/pull/9/files#diff-ca9b69b23d78a2fcabaa6c8cb307ab60R1
