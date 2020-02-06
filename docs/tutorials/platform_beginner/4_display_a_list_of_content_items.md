# Step 4 - Display a list of content items

Now that you know how to display a single Content item, you can take care of rendering a list of Content items.

In this step you will display a table of all Rides on the front page.

## Customize the homepage template

In `Resources/views/full/home_page.html.twig` replace the "Hello world" with a call to a controller which will display the list of all existing Rides:

``` html+twig hl_lines="5"
{% extends "main_layout.html.twig" %}

{% block content %}
    <div class="col-xs-10 col-xs-offset-1 text-justified">
        {{ render( controller( "AppBundle:Homepage:getAllRides", {'location': location, 'request': app.request} ) ) }}
    </div>
{% endblock %}
```

The application will look for a `getAllRidesAction` inside the `HomepageController` in `AppBundle`.

## Create a controller for the home page

Create the `/src/AppBundle/Controller/HomepageController.php` file:

``` php hl_lines="33 34 47 48"
<?php

namespace AppBundle\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    private $contentService;

    private $locationService;

    public function __construct(ContentService $contentService, LocationService $locationService)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
    }

    public function getAllRidesAction(Request $request, Location $location)
    {
        $rootLocationId = $this->getConfigResolver()->getParameter('content.tree_root.location_id');
        $rootLocation = $this->locationService->loadLocation($rootLocationId);

        return $this->render(
            'list/rides.html.twig',
            [
                'pagerRides' => $this->findRides($rootLocation, $request),
                'location' => $location
            ]
        );
    }

    private function findRides(Location $rootLocation, Request $request)
    {
        $query = new LocationQuery();
        $query->query = new Criterion\LogicalAnd(
            [
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                new Criterion\ContentTypeIdentifier(['ride']),
            ]
        );
        $query->sortClauses = [
            new SortClause\DatePublished(LocationQuery::SORT_ASC),
        ];

        $pager = new Pagerfanta(
            new LocationSearchAdapter($query, $this->getRepository()->getSearchService())
        );
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($request->get('page', 1));

        return $pager;
    }
}
```

This controller searches for all visible Content items of the type **Ride** (lines 47-48)
and renders them using the `list/rides.html.twig` template (line 33-34).

### Register the controller

!!! tip

    To learn how to use Symfony services, see [Symfony Service Container documentation](https://symfony.com/doc/3.4/service_container.html).

Because you are using the `ContentService`, you need to register the `HomepageController` as a service.

Add the following section in `app/config/services.yml`, under the `services` key:

``` yaml
AppBundle\Controller\:
    public: true
    resource: '../../src/AppBundle/Controller/*'
```

## Create a template to list all Rides

Create `app/Resources/views/list/rides.html.twig`. It displays the list of Rides in a `<table>` tag.
The `<head>` of the `<table>` is contained in this **Ride** list template, while each `<tr>` (line of the table) will be provided by the line ride template.

``` html+twig hl_lines="17"
<div class="row regular-content-size">
    <div class="col-xs-12 box-style">
        <h3 class="center bottom-plus new-header">{{ 'List of all Rides'|trans }}</h3>
        {% if pagerRides is not empty %}
            <table class="table table-hover">
                <thead>
                <tr class="table-header">
                    <th>{{ 'Ride'|trans }}</th>
                    <th>{{ 'From'|trans }}</th>
                    <th>{{ 'To'|trans }}</th>
                    <th>{{ 'Distance'|trans }}</th>
                </tr>
                </thead>
                <tbody>
                {# Loop over the page results #}
                {% for ride in pagerRides.currentPageResults %}
                    {{ render( controller( 'ez_content:viewAction', { 'location': ride, 'viewType': 'line' } )) }}
                {% endfor %}
                </tbody>
            </table>
        {% else %}
            <p>{{ 'There are no Rides yet.'|trans }}</p>
        {% endif %}

        {% if pagerRides.haveToPaginate() %}
            <div class="colo-xs-12 text-center">
                <div class="pagerfanta pagination">
                    {{ pagerfanta( pagerRides, 'twitter_bootstrap3_translated', {'routeName': location } ) }}
                </div>
            </div>
        {% endif %}
    </div>
</div>
```

### View types

So far you have been using the `full` view type to render the Ride's full view.
Here, on the other hand, you use the `line` view, as indicated by `'viewType': 'line'` (line 17).

You can configure custom view types with any name you want, as long as you include them in the configuration.
Let's do this now with the `line` view for Rides.

## Create a line template for Rides

Add a rule for the `ride` template in your `app/config/ezplatform.yml `file.
`line` should be at the same level as `full`.

``` yaml
system:
    site_group:
        content_view:
            line:
                ride:
                    template: line/ride.html.twig
                    match:
                        Identifier\ContentType: ride
```

Create the `app/Resources/views/line/ride.html.twig` template.

Because this template will be rendered inside a table, it starts with a `<tr>` tag.

``` html+twig
<tr>
    <td>
        <a href="{{ path( "ez_urlalias", { 'locationId': content.contentInfo.mainLocationId } ) }}"
        target="_self">
            <strong>
                {{ content.name }}
            </strong>
            {% if not ez_is_field_empty( content, 'photo' ) %}
                {{ ez_render_field(content, 'photo') }}
            {% endif %}
        </a>
    </td>
    <td>
        {{ ez_render_field(content, 'starting_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}) }}
    </td>
    <td>
        {{ ez_render_field(content, 'ending_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}) }}
    </td>
    <td>
        <p>{{ ez_render_field( content, 'length' ) }} Km</p>
    </td>
</tr>
```

Now go to the homepage of your website and you will see the list of Rides.
However, the Ride photos are too large and stretch the table. In the next step you will ensure they are displayed in proper size.
