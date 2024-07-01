# Ancestor Criterion

The [`Ancestor` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Ancestor.html)
searches for content that is an ancestor of the provided Location, including this Location.

## Arguments

- `value` - array of Location pathStrings

## Example

### PHP

``` php
$query->query = new Criterion\Ancestor([$this->locationService->loadLocation(62)->pathString]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <AncestorCriterion>/81/82/</AncestorCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "AncestorCriterion": "/81/82/"
        }
    }
    ```

## Use case

You can use the Ancestor Search Criterion to create a list of breadcrumbs leading to the Location:

``` php hl_lines="2"
$query = new LocationQuery();
$query->query = new Criterion\Ancestor([$this->locationService->loadLocation($locationId)->pathString]);

$results = $this->searchService->findLocations($query);
$breadcrumbs = [];
foreach ($results->searchHits as $searchHit) {
    $breadcrumbs[] = $searchHit;
}

return $this->render('parts/breadcrumbs.html.twig', [
    'breadcrumbs' => $breadcrumbs,
]);
```

``` html+twig
{% for breadcrumb in breadcrumbs %}
    {% if not loop.first %} -> {% endif %}
    {% if not loop.last %}
        <a href="{{ ibexa_path( breadcrumb.valueObject ) }}">{{ breadcrumb.valueObject.contentInfo.name }}</a>
    {% else %}
        {{ breadcrumb.valueObject.contentInfo.name }}
    {% endif %}
{% endfor %}
```
