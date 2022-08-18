# ParentLocationId Criterion

The [`ParentLocationId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/ParentLocationId.php)
searches for content based on the Location ID of its parent.

## Arguments

- `value` - int(s) representing the parent Location IDs

## Example

``` php
$query->query = new Criterion\ParentLocationId([54, 58]);
```

## Use case

You can use the `ParentLocationId` Search Criterion to list blog posts contained in a blog:

``` php hl_lines="4"
$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd([
    new Criterion\Visibility(Criterion\Visibility::VISIBLE),
    new Criterion\ParentLocationId($locationId),
]);

$results = $this->searchService->findLocations($query);
$posts = [];
foreach ($results->searchHits as $searchHit) {
    $posts[] = $searchHit;
}

return $this->render('full/blog.html.twig', [
    'posts' => $posts,
]);
```

``` html+twig
<p>Posts:</p>
<ul>
    {% for post in posts %}
        <li>{{ post.valueObject.contentInfo.name }}</li>
    {% endfor %}
</ul>
```
