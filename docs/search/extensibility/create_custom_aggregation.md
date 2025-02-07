---
description: Create custom Aggregation to use with Solr and Elasticsearch search engines.
---

# Create custom Aggregation

## Create aggregation class

To create a custom Aggregation, create an aggregation class.
In the following example, an aggregation groups the location query results by the location priority:

``` php
--8<--
code_samples/search/custom/src/Query/Aggregation/PriorityRangeAggregation.php
--8<--
```

The `PriorityRangeAggregation` class extends `AbstractRangeAggregation`.
The name of the class indicates that it aggregates the results by using the Range aggregation.

An aggregation must implement the `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation` interface or inherit one of following abstract classes:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractStatsAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation`

An aggregation can also implement one of the following interfaces:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\FieldAggregation`, based on content field
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation`, based on content location
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\RawAggregation`, based on details of the index structure

!!! note "Aggregation definition"

    An aggregation definition must contain at least the name of an aggregation and optional aggregation parameters, such as, for example, the path (string) that is used to limit aggregation results to a specific subtree, content type identifier, or field definition identifier, which is mapped to the search index field name.

    Aggregation definition must be independent of the search engine used.

A custom aggregation requires that the following elements are provided:

- An aggregation visitor that returns an array of results
- A result extractor that transforms raw aggregation results from the search engine into `AggregationResult` objects

In simpler cases, you can apply one of the built-in visitors that correspond to the aggregation type.
The example below uses `RangeAggregationVisitor`:

=== "Solr"

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 1, 9) =]]
    ```

=== "Elasticsearch"

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 10, 18) =]]
    ```

The visitor is created by `SearchFieldAggregationVisitorFactory`.
You provide it with two arguments:

- The aggregation class in `aggregationClass`
- The field name in search index in `searchIndexFieldName`

=== "Solr"

    Tag the service with `ibexa.search.solr.query.location.aggregation.visitor`.

=== "Elasticsearch"

    Tag the service with `ibexa.elasticsearch.query.location.aggregation_visitor`.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor` and provide it with the aggregation class in the `aggregationClass` parameter.

=== "Solr"

    Tag the service with `ibexa.search.solr.query.location.aggregation.result.extractor`.

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 19, 26) =]]
    ```

=== "Elasticsearch"

    Tag the service with `ibexa.search.elasticsearch.query.location.aggregation.result.extractor`.

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 27, 33) =]]
    ```

You can use a different type of aggregation, followed by respective visitor and extractor classes:

=== "Solr"

    - `Ibexa\Solr\Query\Common\AggregationVisitor\StatsAggregationVisitor`
    - `Ibexa\Solr\Query\Common\AggregationVisitor\TermAggregationVisitor`
    - `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
    - `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

=== "Elasticsearch"

    - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor`
    - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\StatsAggregationVisitor`
    - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\TermAggregationVisitor`

    - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor`
    - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
    - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

In a more complex use case, you must create your own visitor and extractor.

### Create aggregation visitor

=== "Solr"

    The aggregation visitor must implement `Ibexa\Contracts\Solr\Query\AggregationVisitor`:

    ``` php
    --8<--
    code_samples/search/custom/src/Query/Aggregation/Solr/PriorityRangeAggregationVisitor.php
    --8<--
    ```

=== "Elasticsearch"

    The aggregation visitor must implement `Ibexa\Contracts\ElasticSearchEngine\Query\AggregationVisitor`:

    ``` php
    --8<--
    code_samples/search/custom/src/Query/Aggregation/Elasticsearch/PriorityRangeAggregationVisitor.php
    --8<--
    ```

The `canVisit()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

The `visit()` method returns an array of results.

Finally, register the aggregation visitor as a service.

=== "Solr"

    Tag the aggregation visitor with `ibexa.search.solr.query.location.aggregation.visitor`:

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 34, 37) =]]
    ```

    For content-based aggregations, use the `ibexa.search.solr.query.content.aggregation.visitor` tag.

=== "Elasticsearch"

    Tag the aggregation visitor with `ibexa.elasticsearch.query.location.aggregation_visitor`:

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 42, 45) =]]
    ```

    For content-based aggregations, use the `ibexa.search.elasticsearch.query.content.aggregation.visitor` tag.


### Create result extractor

=== "Solr"

    You must also create a result extractor, which implements  `Ibexa\Solr\ResultExtractor\AggregationResultExtractor` that transforms raw aggregation results from Solr into `AggregationResult` objects:

    ``` php
    --8<--
    code_samples/search/custom/src/Query/Aggregation/Solr/PriorityRangeAggregationResultExtractor.php
    --8<--
    ```

    The `canVisit()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

    The `extract()` method converts the [raw data provided by the search engine](https://solr.apache.org/guide/8_8/search-sample.html#aggregation) to a `RangeAggregationResult` object.

=== "Elasticsearch"

    You must also create a result extractor, which implements  `Ibexa\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor` that transforms raw aggregation results from Elasticsearch into `AggregationResult` objects:

    ``` php
    --8<--
    code_samples/search/custom/src/Query/Aggregation/Elasticsearch/PriorityRangeAggregationResultExtractor.php
    --8<--
    ```

    The `supports()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

    The `extract()` method converts the [raw data provided by the search engine](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations.html) to a `RangeAggregationResult` object.


Finally, register the result extractor as a service.

=== "Solr"

    Tag the result extractor with `ibexa.search.solr.query.location.aggregation.result.extractor`:

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 38, 41) =]]
    ```

    For content-based aggregations, use the `ibexa.search.solr.query.content.aggregation.result.extractor` tag.

=== "Elasticsearch"

    Tag the result extractor with `ibexa.elasticsearch.query.location.aggregation_result_extractor`:

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/aggregation_services.yaml', 46, 49) =]]
    ```

    For content-based aggregations, use the `ibexa.search.elasticsearch.query.content.aggregation.result.extractor` tag.
