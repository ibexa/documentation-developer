---
description: GraphQL enables making concise, readable requests to Ibexa DXP APIs.
---

# GraphQL

[GraphQL](https://graphql.org/) is a query language for the API.
The GraphQL implementation for [[= product_name =]] is located in [`ibexa/graphql`](https://github.com/ibexa/graphql).

## Setup

Using GraphQL requires a domain schema.
The schema is generated automatically when installing [[= product_name =]].

When you modify Content Types or product types in your installation, you need to regenerate the schema:

``` bash
php bin/console ibexa:graphql:generate-schema
php bin/console cache:clear
```

YAML files with the schema are located in `config/graphql/types/ibexa`.
They contain information about the domain objects and the fields
you can [query](graphql_queries.md) and [operate on](graphql_operations.md).

### Schema generation limitations

GraphQL schema cannot be generated for names that do not follow the [GraphQL specification](http://spec.graphql.org/June2018/#sec-Names),
for example names that start with a digit.

This concerns image variations, Content Types, Content Type groups, product types, and Field definition identifiers.

It is recommended to rename the relevant identifiers. Failure to generate schema is registered in logs.
To find identifiers that are not included in the schema, look for "Skipped schema generation" log messages, for example:
`Skipped schema generation for Image Variation`.

## Domain schema

GraphQL for [[= product_name =]] is based on the Content Types (including product types), Content Type groups, and Content items
defined in the Repository.

For each Content Type the schema exposes a singular and plural field, e.g. `article` and `articles`.
Use the singular field to query a single Content item, and the plural to get a whole `Connection`
(a list of Content items that supports pagination).

With the queries you can inspect:

- the existing types 
- details of Content Types, and their Fields in the context of developing your own application

You can request additional content information such as the Section or Objects states,
available under the `_info` field.

You can also query Content Type and Content Type group information through the `_info` and `_types` fields.

### Repository schema

The repository schema, accessed through `_repository`, exposes the [[= product_name =]] Repository
in a manner similar to the [Public PHP API](php_api.md).

The `_repository` field also enables you to query e.g. Object states configured for the Repository.

### Custom schemas

You can also use your own [custom schema](graphql_customization.md#custom-schema).

### SiteAccesses and multiple Repositories

GraphQL is SiteAccess-aware, but can have only one schema per installation.
This means you cannot use GraphQL with multiple repositories.

When you request a URL from a SiteAccess that is different than the current one,
the API generates it for the Content item's SiteAccess, with an absolute URL if necessary.

## Authentication

GraphQL for [[= product_name =]] supports session-based authentication.
You can get your session cookie by logging in through the interface or through a REST request.

### JWT authentication

If you have [JWT authentication](development_security.md#jwt-authentication) enabled,
you can use the following query to get your authentication token:

```
mutation CreateToken {
  createToken(username: "admin", password: "publish") {
    token
    message
  }
}
```

Response:

```
{
  "data": {
    "createToken": {
      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MDI4MzU5MTksImV4cCI6MTYwMjgzOTUxOSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRtaW4ifQ.QtDjPU6q68fdvgm6O_1-aEoe-s7s-VQr-9CTMC9ba6E",
      "message": null
    }
  }
}
```

## Usage

You can access GraphQL with `<yourdomain>/graphql`.

### GraphiQL client

The [GraphiQL interactive client](https://github.com/graphql/graphiql) is included in the installation.
Access it through `<yourdomain>/graphiql`.

Here you can run your queries and preview the results in an easy-to-read format.

### Reference

GraphiQL offers side-by-side reference based on your generated schema in the **Docs** pane.
