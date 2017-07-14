1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Tutorials](Tutorials_31429522.html)
4.  [Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)
5.  [Part 2: Working on the Ride](31431613.html)

# Step 2 - Display the list of Rides on the homepage

Created by Philippe Vincent-Royol, last modified by Sarah Haïm-Lubczanski on Nov 22, 2016

-   1 [Customize your homepage template](#Step2-DisplaythelistofRidesonthehomepage-Customizeyourhomepagetemplate)
-   2 [Create your sub controller to display list of Rides](#Step2-DisplaythelistofRidesonthehomepage-CreateyoursubcontrollertodisplaylistofRides)
-   3 [Create template to display the list of Rides](#Step2-DisplaythelistofRidesonthehomepage-CreatetemplatetodisplaythelistofRides)
-   4 [Use a custom template to display view line of a Ride](#Step2-DisplaythelistofRidesonthehomepage-UseacustomtemplatetodisplayviewlineofaRide)

![](attachments/32866555/32866553.png?effects=drop-shadow)

## Customize your homepage template

Let's modify the `Resources/views/content/full/root_folder.html.twig ` adding a call to a subrequest to display the list of all existing Rides with pagination:

**root\_folder.html.twig**

``` brush:
{% extends "pagelayout.html.twig" %}

{% block content %}
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <h3 class="center bottom-plus new-header">{{ ez_content_name(content) }}</h3>
    <div class="col-xs-10 text-justified">
    {{ render( controller( "AppBundle:Homepage:getAllRides" ) ) }}
    </div>
 {% endblock %}
```

 For the moment, we use a simple `render()` Twig function but when we talk about cache, we will use `render_esi`.

## Create your sub controller to display list of Rides

Create your `/src/AppBundle/Controller/HomepageController.php `with the method `getAllRidesAction`:**
**

**HomepageController.php**

``` brush:
<?php
namespace AppBundle\Controller;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
class HomepageController extends Controller
{
  public function getAllRidesAction(Request $request)
  {
    $repository = $this->getRepository();
    $locationService = $repository->getLocationService();
    $contentService = $repository->getContentService();
    $rootLocationId = $this->getConfigResolver()->getParameter('content.tree_root.location_id');
    $rootLocation = $locationService->loadLocation($rootLocationId);
    $currentLocationId = 2;
    $currentLocation = $locationService->loadLocation($currentLocationId);
    $currentContent = $contentService->loadContentByContentInfo($currentLocation->contentInfo);
    $query = new Query();
    $query->query = new Criterion\LogicalAnd(
      array(
        new Criterion\Subtree($rootLocation->pathString),
        new Criterion\Visibility(Criterion\Visibility::VISIBLE),
        new Criterion\ContentTypeIdentifier(array('ride'))
      )
    );
    $query->sortClauses = array(
      new SortClause\DatePublished(Query::SORT_ASC)
    );
    $pager = new Pagerfanta(
      new ContentSearchAdapter($query, $this->getRepository()->getSearchService())
    );
    //FIXME : get $limit value from a custom parameter
    $limit = 10;
    $pager->setMaxPerPage($limit);
    $pager->setCurrentPage($request->get('page', 1));
    return $this->render(
      'list/rides.html.twig',
      array(
        'location' => $currentLocation,
        'content' => $currentContent,
        'pagerRides' => $pager,
      )
    );
  }
}
```

## Create template to display the list of Rides

Create `app/Resources/views/list/rides.html.twig `template. You use a &lt;table&gt; to display the list of rides. The &lt;thead&gt; of the &lt;table&gt; is in this Ride list template and each &lt;tr&gt; (line of the table) is in the line ride template.

So each time you use the line Ride template, you have to remember the choice of using a &lt;tr&gt;.

**rides.html.twig**

``` brush:
<div class="row regular-content-size">
  <div class="col-xs-10 col-xs-offset-1 box-style">
    <h3 class="center bottom-plus new-header">List of all Rides</h3>
    {# Loop over the page results #}
    {% for ride in pagerRides %}
      {% if loop.first %}
        <table class="table table-hover">
        <thead>
        <tr class="table-header">
          <th> Ride</th>
          <th>From</th>
          <th> To</th>
          <th>Distance</th>
          <th>Level</th>
        </tr>
        </thead>
        <tbody>
      {% endif %}
      {{ render( controller( 'ez_content:viewLocation', { 'locationId': ride.versionInfo.contentInfo.mainLocationId, 'viewType': 'line' } )) }}
      {% if loop.last %}
        </tbody>
        </table>
      {% endif %}
    {% endfor %}
  </div>
</div>
```

The next step is to create the override rule to use a dedicated template for the view line of Rides.

To do so, you need to configure your Bundle to inject override configuration.

## Use a custom template to display view line of a Ride

You add the rule for the line\_ride template to be used in your `app/config/ezplatform.yml `file.

**ezplatform.yml**

``` brush:
system:
    site_group:
        content_view:
            line:
                line_ride:
                    template: "line/ride.html.twig"
                    match:
                        Identifier\ContentType: "ride"
```

Create your `app/Resources/views/line/ride.html.twig `template.

*Remember, it's only one line of a table, so you will find a &lt;tr&gt; tag with some &lt;td&gt; tags.*

**ride.html.twig**

``` brush:
<tr>
    <td>
        <strong>
            <a href="{{ path( "ez_urlalias", { 'locationId': content.contentInfo.mainLocationId } ) }}"
               target="_self">
                {{ ez_content_name( content ) }}
            </a>
        </strong>
    </td>
    <td>
        {{ ez_render_field(content, 'starting_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}
        ) }}
    </td>
    <td>
        {{ ez_render_field(content, 'ending_point', {'parameters': {'width': '100%', 'height': '100px', 'showMap': true, 'showInfo': true }}
        ) }}
    </td>
    <td>
        <p>{{ ez_render_field( content, 'length' ) }} Km</p>
    </td>
    <td>
        <p>{{ ez_render_field( content, 'level' ) }}</p>
    </td>
</tr>
```

Go to the homepage of your Tutorial website, and you will see the list of Rides !

 

 

⬅ Previous: [Step 1 - Display content of a Ride](Step-1---Display-content-of-a-Ride_31431852.html)

Next: [Congrats!](https://doc.ez.no/pages/viewpage.action?pageId=31431873) ➡

 

 

**Tutorial path**

## Attachments:

![](images/icons/bullet_blue.gif) [Beginners\_Tutorial-RideList-view.png](attachments/32866555/32866553.png) (image/png)
![](images/icons/bullet_blue.gif) [part2-step2-end.png](attachments/32866555/32866554.png) (image/png)


# Congrats!

Created by Sarah Haïm-Lubczanski, last modified on Nov 22, 2016

![](attachments/thumbnails/30711113/30711865)

### Success: you have just built your first website

Now you have created your first website with eZ Platform.

The website is simple and efficient.

**You learned**

-   How to do a quick install of eZ Platform
-   How the files in an eZ Platform project are organized
-   Where you should put your asset files
-   How to param your eZ Platform to use templating
-   How to use Twig templates to display the content from your database

 

WORK IN PROGRESS

> This tutorial will evolve quickly, let us know on [Slack](http://share.ez.no/get-involved/exchange#slack), [Forums](http://share.ez.no/forums/suggestions) or even comments on this page what Features you want to implement first after this Tutorial. Thank you!

**Tutorial path**


# Part 3: Adding features

Created by Sarah Haïm-Lubczanski, last modified on Nov 22, 2016

**A sneak peek...**

If you would like a sneak peak at our efforts, take a look at the [Beginner Tutorial Component in Jira](https://jira.ez.no/issues/?jql=component%20%3D%20%22Beginner%20Tutorial%22%20AND%20project%20%3D%20EZP).

**We're constantly improving and extending this tutorial, and our process is open.**

We're preparing a lot of training material on the Bike Ride theme for you for tutorials, developer training, and certification:

-   [Bike Ride Tutorial in JIRA](https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FTutorial%22%20AND%20project%20%3D%20EZP)
-   [Bike Ride Developer Training in JIRA](https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FDevTrain%22)
-   [Bike Ride Certification Course in JIRA](https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FCert%22)

**Want to join in the fun ?**

Read about how you can [Contribute to Documentation](Contribute-to-Documentation_31429594.html)!

Questions ?

If you have any questions, feel free to reach out to us or our [awesome community](http://share.ez.no/get-involved/exchange) for help!

 

 

 

TO BE CONTINUED

 
