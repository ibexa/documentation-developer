# GraphQL

[GraphQL](https://graphql.org/) is a query language for the API.
The GraphQL implementation for eZ Platform is located in [`ezsystems/ezplatform-graphql`](https://github.com/ezsystems/ezplatform-graphql).

## Setup

Using GraphQL requires a domain schema.
The schema is generated automatically when installing eZ Platform.

When you modify Content Types in your installation, you need to regenerate the schema:

``` bash
php bin/console ezplatform:graphql:generate-schema
php bin/console cache:clear
```

YAML files with the schema are located in `config/graphql/types/ezplatform`.
They contain information about the domain objects and the fields
you can [query](graphql_queries.md) and [operate on](graphql_operations.md).

## Domain schema

GraphQL for eZ Platform is based on the Content Types, Content Type groups, and Content items
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

The repository schema, accessed through `_repository`, exposes the eZ Platform Repository
in a manner similar to the [Public PHP API](public_php_api.md).

The `_repository` field also enables you to query e.g. Object states configured for the Repository.

### Custom schemas

You can also use your own [custom schema](graphql_customization.md#custom-schema).

## Authentication

GraphQL for eZ Platform supports session-based authentication.
You can get your session cookie by logging in through the interface or through a REST request.

## Usage

You can access GraphQL with `<yourdomain>/graphql`.

### GraphiQL client

The [GraphiQL interactive client](https://github.com/graphql/graphiql) is included in the installation.
Access it through `<yourdomain>/graphiql`.

Here you can run your queries and preview the results in an easy-to-read format.

### Reference

GraphiQL offers side-by-side reference based on your generated schema in the **Docs** pane.
