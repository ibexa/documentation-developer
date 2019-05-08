# Searching

This section covers how the [`SearchService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html) can be used to search for Content, by using a [`Query`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query.html) and a combinations of [`Criteria`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion.html) you will get a [`SearchResult`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html) object back containing list of Content and count of total hits. In the future this object will also include facets, spell checking etc. when running on a backend that supports it *(for instance Solr)*.

!!! note

    To be able to use search API described in this section, you need to create some content (articles, folders) under eZ Platform root.

### Difference between filter and query

Query object contains two properties you can set criteria on `filter` and `query`. You can mix and match use or use both at the same time, there is one distinction between the two:

-   `query` Has an effect on scoring *(relevancy)* calculation, and also on the default sorting if `sortClause` is not specified, *when used with Solr.* Typically `query` is used for `FullText` search criterion, otherwise you can place everything else on `filter`.

## Performing a simple full text search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContentCommand.php>

In this recipe, you will run a simple full text search over every compatible attribute.

### Query and Criterion objects

Described above`Query` object is used to build up a Content query based on a set of `Criterion` objects.

```php
$query = new \eZ\Publish\API\Repository\Values\Content\Query();
// Use 'query' over 'filter' for FullText to get hit score (relevancy) with Solr
$query->query = new Query\Criterion\FullText( $text );
```

Multiple criteria can be grouped together using "logical criteria", such as [LogicalAnd](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalAnd.html) or [LogicalOr](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalOr.html). Since in this case you only want to run a text search, simply use a [`FullText`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.html) criterion object.

The full list of criteria can be found on your installation in the following directory [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Values/Content/Query/Criterion](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/Criterion). Additionally you may look at integration tests like [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Tests/SearchServiceTest.php](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php) for more details on how these are used.

### Running the search query and using the results

The `Query` object is given as an argument to [`SearchService::findContent()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findContent). This method returns a `SearchResult` object. This object provides you with various information about the search operation (number of results, time taken, spelling suggestions, or facets, as well as, of course, the results themselves).

``` php
$result = $searchService->findContent( $query );
$output->writeln( 'Found ' . $result->totalCount . ' items' );
foreach ( $result->searchHits as $searchHit )
{
    $output->writeln( $searchHit->valueObject->contentInfo->name );
}
```

The `searchHits` properties of the `SearchResult` object is an array of `SearchHit` objects. In `valueObject` property of `SearchHit`, you will find the `Content` object that matches the given `Query`.

!!! Tip

    If you you are searching using a unique identifier, for instance using the Content ID or Content remote ID criterion, then you can use [`SearchService::findSingle()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findSingle), this takes a Criterion and returns a single Content item, or throws a `NotFound` exception if none is found.

## Retrieving Sort Clauses for parent Location

You can use the method `$parentLocation->getSortClauses()` to return an array of Sort Clauses for direct use on `LocationQuery->sortClauses`.

## Performing an advanced search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent2Command.php>

As explained in the previous chapter, Criterion objects are grouped together using logical criteria. You will now see how multiple criteria objects can be combined into a fine grained search `Query`.

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$criterion1 = new Criterion\Subtree( $locationService->loadLocation( 2 )->pathString );
$criterion2 = new Criterion\ContentTypeIdentifier( 'folder' );
$query->filter = new Criterion\LogicalAnd(
    array( $criterion1, $criterion2 )
);

$result = $searchService->findContent( $query );
```

A [`Subtree`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Subtree.html) criterion limits the search to the subtree with `pathString`, which looks like: `/1/2/`. A [`ContentTypeId`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeId.html) Criterion to limit the search to Content of Content Type 1. Those two criteria are grouped with a `LogicalAnd` operator. The query is executed as before, with `SearchService::findContent()`.

### Fine-tuning search results

#### `$languageFilter`

The `$languageFilter` parameter provides a prioritized list of languages for the current SiteAccess. Passing it is recommended for front-end use, because otherwise all languages of the Content items will be returned.

Additionally, you can make use of the `useAlwaysAvailable` argument of the `$languageFilter`. This in turn uses the `alwaysAvailable` flag which by default is set on Content Type. When it is set to `true`, it ensures that when a language from the prioritized list can't be matched, the Content will be returned in its main language.

#### `Criterion\Visibility`

`Criterion\Visibility` enables you to ensure that only visible content will be returned.

Note that the criterion behaves differently depending on the method you use, because Locations have visibility, but Content does not. This means that when using the `LocationQuery` (`findLocations($query)`), the method will return the Location, if it is visible. When used with the `Query` (`findContent($query)`), however, the Content item will be returned even if one of its Locations is visible (although others may be hidden). That is why using `Criterion\Visibility` is recommended with `LocationQuery`.

This example shows the usage of both `$languageFilter` and `Criterion\Visibility`:

``` php
$query = new LocationQuery([
    'filter' => new Criterion\LogicalAnd([
    new Criterion\Visibility(Criterion\Visibility::VISIBLE),
    new Criterion\ParentLocationId($parentLocation->id),
    ];),
    'sortClauses' => $parentLocation->getSortClauses(),
]);
$searchService->findLocations($query,
    ['languages' => $configResolver->getParameter('languages')]);
```

## Performing a fetch like search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent3Command.php>

A search isn't only meant for searching, it also provides the interface for what was called "fetch" in previous versions. As this is back-end agnostic, eZ Platform "ezfind" fetch functions are now powered by Solr.

Following the examples above you now change it a bit to combine several criteria with both an AND and an OR condition.

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\LogicalOr(
            array(
                new Criterion\ContentTypeIdentifier( 'folder' ),
                new Criterion\ContentTypeId( 2 )
            )
        )
    )
);

$result = $searchService->findContent( $query );
```

A `ParentLocationId` criterion limits the search to the children of Location 2. An array of `ContentTypeId` Criteria to limit the search to Content of Content Type's with ID 1 or 2 grouped in a `LogicalOr` operator. Those two criteria are grouped with a `LogicalAnd` operator. As always the query is executed as before, with `SearchService::findContent()`.

Change the Location filter to use the Subtree criterion filter as shown in the advanced search example above.

### Using in() instead of OR

The above example is fine, but it can be optimized by taking advantage of the fact that all filter criteria support being given an array of values (IN operator) instead of a single value (EQ operator).

You can also use the [`ContentTypeIdentifier`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.html) Criterion:

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\ContentTypeIdentifier( array( 'article', 'folder' ) )
    )
);

$result = $searchService->findContent( $query );
```

!!! tip

    All filter criteria are capable of doing an "IN" selection, the `ParentLocationId` above could, for example, have been provided `array( 2, 43 )` to include second level children in both your content tree (2) and your media tree (43).

## Performing a Faceted Search

!!! note "Under construction"

    Faceted Search is not fully implemented yet.

    -   Implemented Facets SOLR BUNDLE &gt;=1.4: `User, ContentType, and Section` , see:   [![](https://jira.ez.no/images/icons/issuetypes/epic.png)EZP-26465](https://jira.ez.no/browse/EZP-26465?src=confmacro) - Search Facets M1 Development

    You can register [custom facet builder visitors](https://github.com/ezsystems/ezplatform-solr-search-engine/blob/v1.1.1/lib/Resources/config/container/solr/facet_builder_visitors.yml) with Solr for Content(Info) and SOLR BUNDLE &gt;=1.4 Location search.

    **Contribution starting point**

    The link above is also the starting point for contributing visitors for other API [FacetBuilders](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/FacetBuilder) and [Facets](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Search/Facet) . As for integration tests, fixtures that will need adjustments are found in [ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Tests/_fixtures/Solr) , and those missing in that link but [defined in SearchServiceTest](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php#L2474), are basically not implemented yet.

To be able to take advantage of facets, you can set the `Query->facetBuilders` property, which will result in relevant facets being returned on `SearchResult->facets`. All facet builders share the following properties:

|Property|Description|
|--------|-----------|
|`name`| Recommended, to set the human-readable name of the returned facet for use in UI, so if you need translation this value should already be translated.|
|`minCount`| Optional, the minimum of hits of a given grouping, e.g. minimum number of content items in a given facet for it to be returned.|
|`limit`| Optional, Maximum number of facets to be returned; only X number of facets with the greatest number of hits will be returned.|

As an example, apply `UserFacet` to be able to group content according to the creator:

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

// [...]

$query = new Query();
$query->filter = new Criterion\ContentTypeIdentifier(['article']);
$query->facetBuilders[] = new FacetBuilder\UserFacetBuilder(
    [
        'name' => 'Document owner',
        'type' => FacetBuilder\UserFacetBuilder::OWNER,// Specific to UserFacetBuilder, one of: OWNER, GROUP or MODIFIER
        'minCount' => 2,
        'limit' => 5
    ]
);

$result = $searchService->findContentInfo( $query );
list( $userId, $articleCount ) = $result->facets[0]->entries;
```

## Performing a pure search count

In many cases you might need the number of Content items matching a search, but with no need to do anything else with the results.

Thanks to the fact that the `searchHits` property of the [`SearchResult`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html) object always refers to the total amount, it is enough to run a standard search and set `$limit` to 0. This way no results will be retrieved, and the search will not be slowed down, even when the number of matching results is huge.

``` php
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->limit = 0;

// [...] ( Add criteria as shown above )

$resultCount = $searchService->findContent( $query )->totalCount;
```
