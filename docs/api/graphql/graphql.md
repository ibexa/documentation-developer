---
description: GraphQL enables making concise, readable requests to Ibexa DXP APIs.
---

# GraphQL

[GraphQL](https://graphql.org/) is a query language for the API.
The GraphQL implementation for [[= product_name =]] is located in [`ibexa/graphql`](https://github.com/ibexa/graphql).

## Setup

Using GraphQL requires a domain schema.

Before using GraphQL for the first time, or anytime you modify content types or product types in your installation, you need to generate the schema:

``` bash
php bin/console ibexa:graphql:generate-schema
php bin/console cache:clear
```

YAML files with the schema are located in `config/graphql/types/ibexa`.
They contain information about the domain objects and the fields you can [query](graphql_queries.md) and [operate on](graphql_operations.md).

### Schema generation limitations

GraphQL schema cannot be generated for names that don't follow the [GraphQL specification](http://spec.graphql.org/June2018/#sec-Names), for example names that start with a digit.

This concerns image variations, content types, content type groups, product types, and field definition identifiers.

It's recommended to rename the relevant identifiers. Failure to generate schema is registered in logs.
To find identifiers that aren't included in the schema, look for "Skipped schema generation" log messages, for example: `Skipped schema generation for Image Variation`.

## Domain schema

GraphQL for [[= product_name =]] is based on the content types (including product types), content type groups, and content items defined in the repository.

For each content type the schema exposes a singular and plural field, for example, `article` and `articles`.
Use the singular field to query a single content item, and the plural to get a whole `Connection` (a list of content items that supports pagination).

With the queries you can inspect:

- the existing types
- details of content types, and their fields in the context of developing your own application

You can request additional content information such as the section or Objects states, available under the `_info` field.

You can also query content type and content type group information through the `_info` and `_types` fields.

### Repository schema

The repository schema, accessed through `_repository`, exposes the [[= product_name =]] repository in a manner similar to the [Public PHP API](php_api.md).

The `_repository` field also enables you to query, for example, object states configured for the repository.

### Custom schemas

You can also use your own [custom schema](graphql_customization.md#custom-schema).

### SiteAccesses and multiple Repositories

GraphQL is SiteAccess-aware, but can have only one schema per installation.
This means you cannot use GraphQL with multiple repositories.

When you request a URL from a SiteAccess that is different than the current one, the API generates it for the content item's SiteAccess, with an absolute URL if necessary.

## Authentication

GraphQL for [[= product_name =]] supports session-based authentication.
You can get your session cookie by logging in through the interface or through a REST request.

### JWT authentication

If you have [JWT authentication](development_security.md#jwt-authentication) enabled, you can use the following query to get your authentication token:

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

Here you can run your queries and preview the results in a readable format.

### Reference

GraphiQL offers side-by-side reference based on your generated schema in the **Docs** pane.
