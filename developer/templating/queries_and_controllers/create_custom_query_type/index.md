# Create a custom Query type

Create a Query type to search for content according to your custom needs.

If you need to perform a more complex query than the [built-in Query types](../built-in_query_types/index.md) allow, you can create a custom Query type.

The following example shows how to create a custom Query type that renders the latest content items of selected Types.

First, add the following `LatestContentQueryType.php` file to `src/QueryType`:

```php
<?php declare(strict_types=1);

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Core\QueryType\QueryType;

class LatestContentQueryType implements QueryType
{
    public static function getName()
    {
        return 'LatestContent';
    }

    public function getQuery(array $parameters = [])
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['contentType'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['contentType']);
        }

        return new LocationQuery([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [
                new Query\SortClause\DatePublished(Query::SORT_DESC),
            ],
            'limit' => $parameters['limit'] ?? 10,
        ]);
    }

    public function getSupportedParameters()
    {
        return ['contentType', 'limit'];
    }
}
```

> **Tip: Tip**
>
> When the custom Query type is in the `App` namespace, like in the example above, it's registered automatically as a service. Otherwise, register it with the `ibexa.query_type` service tag.

The name defined in `getName()` is the one you use to identify the Query type in content view configuration.

```php
public static function getName()
{
    return 'LatestContent';
}
```

> **Caution: Caution**
>
> Query type name must be unique.

The `getQuery()` method constructs the query based on Search Criteria and Sort Clauses.

For more information, see [Content search](../../../search/search_api/index.md) and [Search reference](../../../search/criteria_reference/search_criteria_reference/index.md).

The `getSupportedParameters()` method provides the parameters you can set in content view configuration.

```php
public function getSupportedParameters()
{
    return ['contentType', 'limit'];
}
```

> **Note: Note**
>
> To have more control over the details of parameters, use the [Options resolver-based Query type](#options-resolver-based-query-type).

Then, in the content view configuration, indicate that the content view should use the custom Query type:

```text
            content_view:
                full:
                    latest:
                        controller: ibexa_query::locationQueryAction
                        template: '@ibexadesign/full/latest.html.twig'
                        match:
                            Identifier\ContentType: "latest"
                        params:
                            query:
                                query_type: LatestContent
                                parameters:
                                    contentType: [article, blog_post]
                                assign_results_to: latest
```

## Options resolver-based Query type

Additionally, your custom Query type can extend the `OptionsResolverBasedQueryType` abstract class. This gives you more flexibility when defining parameters.

In the `configureOptions()` method you can define the allowed parameters, their types and default values.

```php
<?php declare(strict_types=1);

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Core\QueryType\OptionsResolverBasedQueryType;
use Ibexa\Core\QueryType\QueryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionsBasedLatestContentQueryType extends OptionsResolverBasedQueryType implements QueryType
{
    public static function getName()
    {
        return 'OptionsLatestContent';
    }

    protected function doGetQuery(array $parameters)
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['contentType'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['contentType']);
        }

        return new LocationQuery([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [
                new Query\SortClause\DatePublished(Query::SORT_DESC),
            ],
            'limit' => $parameters['limit'] ?? 10,
        ]);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(['contentType', 'limit']);
        $resolver->setAllowedTypes('contentType', 'array');
        $resolver->setAllowedTypes('limit', 'int');
        $resolver->setDefault('limit', 10);
    }
}
```

> **Note: Note**
>
> In contrast with the previous example, a Query type that extends `OptionsResolverBasedQueryType` must implement the `doGetQuery()` method instead of `getQuery()`.
