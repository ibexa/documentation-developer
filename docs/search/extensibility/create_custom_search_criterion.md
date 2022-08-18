---
description: Create custom Search Criterion to use with Solr and Elasticsearch search engines.
---

# Create custom Search Criterion

To provide support for a custom Search Criterion, do the following.

## Create Criterion class

First, create a `CameraManufacturerCriterion.php` file 
that contains the Criterion class:

=== "Solr"

    ``` php
    --8<--
    code_samples/search/solr/src/Query/Criterion/Solr/CameraManufacturerCriterion.php
    --8<--
    ```

=== "Elasticsearch"

    ``` php
    --8<--
    code_samples/search/elasticsearch/src/Query/Criterion/Elasticsearch/CameraManufacturerCriterion.php
    --8<--
    ```

## Create Criterion visitor

Then, add a `CameraManufacturerVisitor` class, implementing `CriterionVisitor`:

=== "Solr"

    ``` php
    --8<--
    code_samples/search/solr/src/Query/Criterion/Solr/CameraManufacturerVisitor.php
    --8<--
    ```

=== "Elasticsearch"

    ``` php
    --8<--
    code_samples/search/elasticsearch/src/Query/Criterion/Elasticsearch/CameraManufacturerVisitor.php
    --8<--
    ```

Finally, register the visitor as a service.

Search Criteria can be valid for both Content and Location search.
To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service::

=== "Solr"

    ``` yaml
    --8<--
    code_samples/search/solr/config/criterion_services.yaml
    --8<--
    ```

=== "Elasticsearch"

    ``` yaml
    --8<--
    code_samples/search/elasticsearch/config/criterion_services.yaml
    --8<--
    ```
