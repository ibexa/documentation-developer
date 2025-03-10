---
description: Create custom Sort Clause to use with Solr and Elasticsearch search engines.
---

# Create custom Sort Clause

To create a custom Sort Clause, do the following.

## Create Sort Clause class

First, add a `ScoreSortClause.php` file with the Sort Clause class:

``` php
--8<--
code_samples/search/custom/src/Query/SortClause/ScoreSortClause.php
--8<--
```

## Create Sort Clause visitor

Then, add a `ScoreVisitor` class that implements `SortClauseVisitor`:

=== "Solr"

    ``` php
    --8<--
    code_samples/search/custom/src/Query/SortClause/Solr/ScoreVisitor.php
    --8<--
    ```

=== "Elasticsearch"

    ``` php
    --8<--
    code_samples/search/custom/src/Query/SortClause/Elasticsearch/ScoreVisitor.php
    --8<--
    ```

    The `supports()` method checks if the implementation can handle the given Sort Clause.
    The `visit()` method contains the logic that translates Sort Clause information into data understandable by the search engine.
    The `visit()` method takes the Sort Clause visitor, the Sort Clause itself and the language filter as arguments.

Finally, register the visitor as a service.

Sort Clauses can be valid for both content and Location search.
To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

=== "Solr"

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/sort_clause_services.yaml', 1, 5) =]]
    ```

=== "Elasticsearch"

    ``` yaml
    services:
    [[= include_file('code_samples/search/custom/config/sort_clause_services.yaml', 6, 10) =]]
    ```
