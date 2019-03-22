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

For each Content Type the schema exposes a singular and plural field, e.g. `article` and `articles`.
Use the singular field to query a single Content item, and the plural to get a whole `Connection`,
that is a list of Content items.

You can also query Content Type and Content Type Group information through the `_info` and `_types` fields.

### Repository schema

The repository schema, accessed through `_repository`, exposes the eZ Platform Repository
in a manner similar to the [Public PHP API](public_php_api.md)

## Authentication

GraphQL for eZ Platform supports session-based authentication.
You can get your session cookie by logging in through the interface, or through a REST request.

## Usage

You can access GraphQL with `<yourdomain>/graphql`.

### GraphiQL client

You can also make use of the included [GraphiQL interactive client](https://github.com/graphql/graphiql).
Access it through `<yourdomain>/graphiql`.

Here you can run your queries and preview the results in an easy-to-read format.

### Reference

GraphiQL offers side-by-side reference based on your generated schema in the **Docs** pane.
