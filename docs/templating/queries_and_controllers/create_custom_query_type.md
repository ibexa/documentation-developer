---
description: Create a Query type to search for content according to your custom needs.
---

# Create a custom Query type

If you need to perform a more complex query than the [built-in Query types](built-in_query_types.md) allow,
you can create a custom Query type.

The following example shows how to create a custom Query type
that renders the latest Content items of selected Types.

First, add the following `LatestContentQueryType.php` file to `src/QueryType`:

``` php
[[= include_file('code_samples/front/custom_query_type/src/QueryType/LatestContentQueryType.php') =]]
```

!!! tip

    When the custom Query type is in the `App` namespace, like in the example above, it is registered automatically as a service.
    Otherwise, register it with the `ibexa.query_type` service tag.

The name defined in `getName()` is the one you use to identify the Query type in content view configuration.

``` php
[[= include_file('code_samples/front/custom_query_type/src/QueryType/LatestContentQueryType.php', 10, 14) =]]
```

!!! caution

    Query type name must be unique.

The `getQuery()` method constructs the query based on Search Criteria and Sort Clauses.
See [Content search](search_api.md) for more information about queries
and [Search reference](search_criteria_reference.md) for a reference of available Criteria and Sort Clauses.

The `getSupportedParameters()` method provides the parameters you can set in content view configuration.

``` php
[[= include_file('code_samples/front/custom_query_type/src/QueryType/LatestContentQueryType.php', 31, 35) =]]
```

!!! note

    To have more control over the details of parameters, use the [Options resolver-based Query type](#options-resolver-based-query-type).

Then, in the content view configuration, indicate that the content view should use the custom Query type:

``` hl_lines="10"
[[= include_file('code_samples/front/custom_query_type/config/packages/views.yaml', 8, 21) =]]
```

## Options resolver-based Query type

Additionally, your custom Query type can extend the `OptionsResolverBasedQueryType` abstract class.
This gives you more flexibility when defining parameters.

In the `configureOptions()` method you can define the allowed parameters, their types and default values.

``` php hl_lines="34 35 36 37 38 39 40"
[[= include_file('code_samples/front/custom_query_type/src/QueryType/OptionsBasedLatestContentQueryType.php') =]]
```

!!! note

    In contrast with the previous example, a Query type that extends `OptionsResolverBasedQueryType`
    must implement the `doGetQuery()` method instead of `getQuery()`.
