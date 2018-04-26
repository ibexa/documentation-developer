# Browsing, finding, viewing

You will start by going through the various ways to find and retrieve content from eZ Platform using the API. While this will be covered in further dedicated documentation, it is necessary to explain a few basic concepts of the public API. In the following recipes, you will learn about the general principles of the API as they are introduced in individual recipes.

## Displaying values from a Content item

In this recipe, you will see how to fetch a Content item from the repository, and obtain its Field's content.

Let's first see the full code. You can see the Command line version at <https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentCommand.php>

**Viewing content**

```php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();

try
{
    $content = $contentService->loadContent( 66 );
    $contentType = $contentTypeService->loadContentType( $content->contentInfo->contentTypeId );
    // iterate over the field definitions of the content type and print out each field's identifier and value
    foreach( $contentType->fieldDefinitions as $fieldDefinition )
    {
        $output->write( $fieldDefinition->identifier . ": " );
        $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
        $field = $content->getField( $fieldDefinition->identifier );

        // We use the Field's toHash() method to get readable content out of the Field
        $valueHash = $fieldType->toHash( $field->value );
        $output->writeln( $valueHash );
    }
}
catch( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    // if the id is not found
    $output->writeln( "No content with id $contentId" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    // not allowed to read this content
    $output->writeln( "Anonymous users are not allowed to read content with id $contentId" );
}
```

Let's analyze this code block by block.

``` php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();
```

This is the initialization part. As explained above, everything in the public API goes through the repository via dedicated services. You get the repository from the service container, using the method `get()` of your container, obtained via `$this->getContainer()`. Using your `$repository` variable, fetch the two services you will be using `getContentService()` and `getFieldTypeService()`.

``` php
try
{
    // iterate over the field definitions of the content type and print out each field's identifier and value
    $content = $contentService->loadContent( 66 );
```

Everything starting from line 5 is about getting your Content and iterating over its Fields. You can see that the whole logic is part of a `try/catch` block. Since the public API uses Exceptions for error handling, this is strongly encouraged, as it will allow you to conditionally catch the various errors that may happen. The exceptions that can occur will be covered in a later paragraph.

The first thing you do is use the Content Service to load a Content item using its ID, 66: `$contentService->loadContent ( 66 )`. As you can see on the API doc page, this method expects a Content ID, and returns a [Content value object](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Content.html).

``` php
foreach( $contentType->fieldDefinitions as $fieldDefinition )
{
    // ignore ezpage
    if( $fieldDefinition->fieldTypeIdentifier == 'ezpage' )
        continue;
    $output->write( $fieldDefinition->identifier . ": " );
    $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
    $fieldValue = $content->getFieldValue( $fieldDefinition->identifier );
    $valueHash = $fieldType->toHash( $fieldValue );
    $output->writeln( $valueHash );
}
```

This block is the one that actually displays the value.

It iterates over the Content item's Fields using the Content Type's Field Definitions (`$contentType->fieldDefinitions`).

For each Field Definition, you start by displaying its identifier (`$fieldDefinition->identifier`). You then get the Field Type instance using the Field Type Service (`$fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier )`). This method expects the requested Field Type's identifier, as a string (ezstring, ezxmltext, etc.), and returns an `eZ\Publish\API\Repository\FieldType` object.

The Field Value object is obtained using the `getFieldValue()` method of the Content value object which you obtained using `ContentService::loadContent()`.

Using the Field Type object, you can convert the Field Value to a hash using the `toHash()` method, provided by every Field Type. This method returns a primitive type (string, hash) out of a Field instance.

With this example, you should get a first idea on how you interact with the API. Everything is done through services, each service being responsible for a specific part of the repository (Content, Field Type, etc.).

## Loading Content in different languages

Since you didn't specify any language code, your Field object is returned in the given Content item's main language.

If you want to take SiteAccess languages into account:

-   Provide prioritized languages on `load()` this will be taken into account by the returned Content object when retrieving translated properties like fields, for example:
    `$contentService->loadContent( 66, $configResolver->getParameter('languages'));`
    -   `ConfigResolver` is a service, so it can be obtained from Symfony Container or injected directly: `@ezpublish.config.resolver`.
    -   *Note: As of v2.0 this is planned to be done for you when you don't specify languages.*

Otherwise if you want to use an altogether different language, you can specify a language code in the `getField()` call:

``` php
$content->getFieldValue( $fieldDefinition->identifier, 'fre-FR' )
```

**Exceptions handling**

``` php
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No content with id $contentId found</error>" );
}
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Permission denied on content with id $contentId</error>" );
}
```

As said earlier, the public API uses [Exceptions](http://php.net/exceptions) to handle errors. Each method of the API may throw different exceptions, depending on what it does. Which exceptions can be thrown is usually documented for each method. In our case, `loadContent()` may throw two types of exceptions: `NotFoundException`, if the requested ID isn't found, and `UnauthorizedException` if the currently logged in user isn't allowed to view the requested content.

It is a good practice to cover each exception you expect to happen. In this case, since our Command takes the Content ID as a parameter, this ID may either not exist, or the referenced Content item may not be visible to our user. Both cases are covered with explicit error messages.

## Traversing a Location subtree

This recipe will show how to traverse a Location's subtree. The full code implements a command that takes a Location ID as an argument and recursively prints this location's subtree.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/BrowseLocationsCommand.php>

In this code the [LocationService](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html) is introduced. This service is used to interact with Locations. You will use two methods from this service: [`loadLocation()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_loadLocation), and [`loadLocationChildren()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_loadLocationChildren).

**Loading a Location**

``` php
try
{
    // load the starting location and browse
    $location = $this->locationService->loadLocation( $locationId );
    $this->browseLocation( $location, $output );
}
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No location found with id $locationId</error>" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Current users are not allowed to read location with id $locationId</error>" );
}
```

As for the ContentService, `loadLocation()` returns a value object, here a `Location`. Errors are handled with exceptions: `NotFoundException` if the Location ID couldn't be found, and `UnauthorizedException` if the current repository user isn't allowed to view this Location.

**Iterating over a Location's children**

``` php
private function browseLocation( Location $location, OutputInterface $output, $depth = 0 )
{
    $childLocationList = $this->locationService->loadLocationChildren( $location, $offset = 0, $limit = 10 );
    // If offset and limit had been specified to something else then "all", then $childLocationList->totalCount contains the total count for iteration use
    foreach ( $childLocationList->locations as $childLocation )
    {
        $this->browseLocation( $childLocation, $output, $depth + 1 );
    }
}
```

`LocationService::loadLocationChildren()` returns a [LocationList](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/LocationList.php) value objects that you can iterate over.

Note that unlike `loadLocation()`, you don't need to care for permissions here: the currently logged-in user's permissions will be respected when loading children, and Locations that can't be viewed won't be returned at all.

!!! note

    Should you need more advanced children fetching methods, the `SearchService` is what you are looking for.

## Viewing Content Metadata

Content is a central piece in the public API. You will often need to start from a Content item, and dig in from its metadata. Basic content metadata is made available through `ContentInfo` objects. This value object mostly provides primitive fields: `contentTypeId`, `publishedDate` or `mainLocationId`. But it is also used to request further Content-related value objects from various services.

The full example implements an `ezplatform:cookbook:view_content_metadata` command that prints out all the available metadata, given a Content ID.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentMetaDataCommand.php>

Several new services are introduced here: [`URLAliasService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html), [`UserService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html) and [`SectionService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SectionService.html).

**Services initialization**

``` php
/** @var $repository \eZ\Publish\API\Repository\Repository */
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$locationService = $repository->getLocationService();
$urlAliasService = $repository->getURLAliasService();
$sectionService = $repository->getSectionService();
$userService = $repository->getUserService();
```

### Setting the Repository User

In a command line script, the repository runs as if executed by the anonymous user. In order to identify it as a different user, you need to use the `UserService` together with `PermissionResolver` as follows (in the example `admin` is the login of the administrator user):

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByLogin('admin');
$permissionResolver->setCurrentUserReference($user);
```

This may be crucial when writing maintenance or synchronization scripts.

This is of course not required in template functions or controller code, as the HTTP layer will take care of identifying the user, and automatically set it in the repository.

### The ContentInfo Value Object

You will now load a `ContentInfo` object using the provided ID and use it to get your Content item's metadata

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

### Locations

**Getting Content Locations**

``` php
// show all locations of the content
$locations = $locationService->loadLocations( $contentInfo );
$output->writeln( "<info>LOCATIONS</info>" );
foreach ( $locations as $location )
{
    $urlAlias = $urlAliasService->reverseLookup( $location );
    $output->writeln( "  $location->pathString  ($urlAlias->path)" );
}
```

First use `LocationService::loadLocations()` to **get** the **Locations** for `ContentInfo`. This method returns an array of [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php) value objects. In this example, you print out the Location's path string (/path/to/content). You also use [URLAliasService::reverseLookup()](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html#method_reverseLookup) to get the Location's main [URLAlias](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/URLAlias.html).

### Relations

Now you will list relations from and to your Content. Since relations are versioned, you need to feed the [`ContentService::loadRelations()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadRelations) with a `VersionInfo` object. You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadVersionInfo). If you had been looking for an archived version, you could have specified the version number as the second argument to this method.

**Browsing a Content's relations**

``` php
// show all relations of the current version
$versionInfo = $contentService->loadVersionInfo( $contentInfo );
$relations = $contentService->loadRelations( $versionInfo );
if ( !empty( $relations ) )
{
    $output->writeln( "<info>RELATIONS</info>" );
    foreach ( $relations as $relation )
    {
        $name = $relation->destinationContentInfo->name;
        $output->write( "  Relation of type " . $this->outputRelationType( $relation->type ) . " to content $name" );
    }
}
```

You can iterate over the [Relation](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Relation.html) objects array you got from `loadRelations()`, and use these value objects to get data about your relations. It has two main properties: `destinationContentInfo`, and `sourceContentInfo`. They also hold the relation type (embed, common, etc.), and the optional Field this relations is made with.

### ContentInfo properties

You can of course get your Content item's metadata by using the value object's properties.

**Primitive object metadata**

``` php
// show meta data
$output->writeln( "\n<info>METADATA</info>" );
$output->writeln( "  <info>Name:</info> " . $contentInfo->name );
$output->writeln( "  <info>Type:</info> " . $contentType->identifier );
$output->writeln( "  <info>Last modified:</info> " . $contentInfo->modificationDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>Published:</info> ". $contentInfo->publishedDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>RemoteId:</info> $contentInfo->remoteId" );
$output->writeln( "  <info>Main Language:</info> $contentInfo->mainLanguageCode" );
$output->writeln( "  <info>Always available:</info> " . ( $contentInfo->alwaysAvailable ? 'Yes' : 'No' ) );
```

### Owning user

You can use [`UserService::loadUser()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html#method_loadUser) with Content `ownerId` property of our `ContentInfo` to load the Content's owner as a `User` value object.

``` php
$owner = $userService->loadUser( $contentInfo->ownerId );
$output->writeln( "  <info>Owner:</info> " . $owner->contentInfo->name );
```

To get the current version's creator, and not the content's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

The Section's ID can be found in the `sectionId` property of the `ContentInfo` object. To get the matching Section value object, you need to use the `SectionService::loadSection()` method.

``` php
$section = $sectionService->loadSection( $contentInfo->sectionId );
$output->writeln( "  <info>Section:</info> $section->name" );
```

### Versions

To conclude you can also iterate over the Content's version, as `VersionInfo` value objects.

``` php
$versionInfoArray = $contentService->loadVersions( $contentInfo );
if ( !empty( $versionInfoArray ) )
{
    $output->writeln( "\n<info>VERSIONS</info>" );
    foreach ( $versionInfoArray as $versionInfo )
    {
        $creator = $userService->loadUser( $versionInfo->creatorId );
        $output->write( "  Version $versionInfo->versionNo " );
        $output->write( " by " . $creator->contentInfo->name );
        $output->writeln( " " . $this->outputStatus( $versionInfo->status ) . " " . $versionInfo->initialLanguageCode );
    }
}
```

Use the `ContentService::loadVersions()` method to get an array of `VersionInfo` objects.

## Search

This section covers how the [`SearchService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html) can be used to search for Content, by using a [`Query`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query.html) and a combinations of [`Criteria`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion.html) you will get a [`SearchResult`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html) object back containing list of Content and count of total hits. In the future this object will also include facets, spell checking etc. when running on a backend that supports it *(for instance Solr)*.

!!! note

    To be able to use search API described in this section, you need to create some content (articles, folders) under eZ Platform root.

#### Difference between filter and query

Query object contains two properties you can set criteria on `filter` and `query`. You can mix and match use or use both at the same time, there is one distinction between the two:

-   `query` Has an effect on scoring *(relevancy)* calculation, and also on the default sorting if `sortClause` is not specified, *when used with Solr and Elastic.* Typically `query` is used for `FullText` search criterion, otherwise you can place everything else on `filter`.

### Performing a simple full text search

!!! tip "Checking feature support per search engine"

    To find out if a given search engine supports advanced full text capabilities, use the [`$searchService->supports($capabilityFlag)`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/SearchService.php#L187-L197) method.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContentCommand.php>

In this recipe, you will run a simple full text search over every compatible attribute.

#### Query and Criterion objects

Described above`Query` object is used to build up a Content query based on a set of `Criterion` objects.

```php
$query = new \eZ\Publish\API\Repository\Values\Content\Query();
// Use 'query' over 'filter' for FullText to get hit score (relevancy) with Solr/Elastic
$query->query = new Query\Criterion\FullText( $text );
```

Multiple criteria can be grouped together using "logical criteria", such as [LogicalAnd](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalAnd.html) or [LogicalOr](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalOr.html). Since in this case you only want to run a text search, simply use a [`FullText`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.html) criterion object.

The full list of criteria can be found on your installation in the following directory [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Values/Content/Query/Criterion](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/Criterion). Additionally you may look at integration tests like [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Tests/SearchServiceTest.php](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php) for more details on how these are used.

#### Running the search query and using the results

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

### Retrieving Sort Clauses for parent Location

You can use the method `$parentLocation->getSortClauses()` to return an array of Sort Clauses for direct use on `LocationQuery->sortClauses`.

### Performing an advanced search

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

#### Fine-tuning search results

##### `$languageFilter`

The `$languageFilter` parameter provides a prioritized list of languages for the current SiteAccess. Passing it is recommended for front-end use, because otherwise all languages of the Content items will be returned.

Additionally, you can make use of the `useAlwaysAvailable` argument of the `$languageFilter`. This in turn uses the `alwaysAvailable` flag which by default is set on Content Type. When it is set to `true`, it ensures that when a language from the prioritized list can't be matched, the Content will be returned in its main language.

##### `Criterion\Visibility`

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

### Performing a fetch like search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent3Command.php>

A search isn't only meant for searching, it also provides the interface for what was called "fetch" in previous versions. As this is back-end agnostic, eZ Platform "ezfind" fetch functions are now powered by Solr (or ElasticSearch in experimental, unsupported setups).

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

#### Using in() instead of OR

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

### Performing a Faceted Search

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

### Performing a pure search count

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
