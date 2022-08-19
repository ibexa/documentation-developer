---
description: Learn how to query for content and render it in a list.
---

# Step 5 — Display a list of Content items

Now that you know how to display a single Content item, you can take care of rendering a list of Content items.

In this step you will display a table of all Rides on the front page.

## Customize the homepage template

In `templates/full/home_page.html.twig` replace the "Hello world" with a table that will display the list of all existing Rides:

``` html+twig hl_lines="15 16"
{% extends "main_layout.html.twig" %}

{% block content %}
    <div class="col-xs-10 col-xs-offset-1 text-justified">
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
            {% for ride in rides.currentPageResults %}
                {{ render( controller( 'ibexa_content::viewAction', { 'location': ride.valueObject, 'viewType': 'line' } )) }}
            {% endfor %}
            </tbody>
        </table>
        {% if rides.haveToPaginate() %}
            <div class="col-xs-12 text-center">
                <div class="pagerfanta pagination">
                    {{ pagerfanta(rides, 'ibexa') }}
                </div>
            </div>
        {% endif %}
    </div>
{% endblock %}
```

The `rides` variable you use in line 15 above needs to contain a list of all Rides.
To get this list, you will use a Query Type.

## Create a QueryType for the home page

QueryType objects are used to limit and sort results for Content Item queries.
For more information, see [Built-In Query Types](built-in_query_types.md).

Here, you need to display `ride` objects that have been published (are visible).
Create a `RideQueryType.php` file in `src/QueryType`:

``` php hl_lines="21 22"
<?php

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\QueryType\QueryType;

class RideQueryType implements QueryType
{
    public static function getName()
    {
        return 'Ride';
    }

    public function getQuery(array $parameters = [])
    {
        return new LocationQuery([
            'filter' => new Criterion\LogicalAnd(
                [
                    new Criterion\Visibility(Criterion\Visibility::VISIBLE),
                    new Criterion\ContentTypeIdentifier(['ride']),
                ]
            )
        ]);
    }

    public function getSupportedParameters()
    {
    }
}
```

This Query Type will find all visible Content items that belong to the `ride` Content Type (lines 21-22).

Now you need to indicate that this Query Type will be used in your configuration.

## Add Query Type to configuration

Edit `config/packages/ibexa.yaml`.
In the view configuration for the home page indicate that this view will use the Query Type:

``` yaml hl_lines="6 10 11 12 13 14 15"
site:
    content_view:
        full:
            # existing keys, do not change them
            home_page:
                controller: ibexa_query::pagingQueryAction
                template: full/home_page.html.twig
                match:
                    Id\Location: 2
                params:
                    query:
                        query_type: Ride
                        limit: 4
                        assign_results_to: rides
```

The `query_type` parameter in line 12 indicates which Query Type to use.
You defined the name `Ride` in the Query Type file in the `getName` method.

Using the `pagingQueryAction` of the built-in `ibexa_query` controller (line 6)
enables you to automatically get paginated results.
You can set the limit of results per page in the `limit` parameter.

### View types

So far you have been using the `full` view type to render the Ride's full view.
Here, on the other hand, you use the `line` view, as indicated by `'viewType': 'line'` in the home page template (line 16).

You can configure custom view types with any name you want, as long as you include them in the configuration.
Let's do this now with the `line` view for Rides.

## Create a line template for Rides

Add a rule for the `ride` template in your `config/packages/ibexa.yaml` file.
`line` should be at the same level as `full`.

``` yaml
system:
    site:
        content_view:
            line:
                ride:
                    template: line/rides.html.twig
                    match:
                        Identifier\ContentType: ride
```

Create the `templates/line/rides.html.twig` template.

Because this template will be rendered inside a table, it starts with a `<tr>` tag.

``` html+twig
<tr>
    <td>
        <a href="{{ path( "ibexa.url.alias", { 'locationId': content.contentInfo.mainLocationId } ) }}"
           target="_self">
            <strong>
                {{ content.name }}
            </strong>
            {% if not ibexa_field_is_empty( content, 'photo' ) %}
                {{ ibexa_render_field(content, 'photo') }}
            {% endif %}
        </a>
    </td>
    <td>
        {{ ibexa_render_field(content, 'starting_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}) }}
    </td>
    <td>
        {{ ibexa_render_field(content, 'ending_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}) }}
    </td>
    <td>
        <p>{{ ibexa_render_field( content, 'length' ) }} Km</p>
    </td>
</tr>
```

Now go to the homepage of your website and you will see the list of Rides.
However, the Ride photos are too large and stretch the table.
In the next step you will ensure they are displayed in proper size.
