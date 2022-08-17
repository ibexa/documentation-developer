---
description: Learn how to embed related content in another Content item's template.
---

# Step 7 — Embed content

Creating lists and detailed views of Content Types and their respective items often involves loading related resources.
In this step, you add a related object, a Landmark, which will be displayed on Ride pages.

You can add as many or as little related resources as you like.

## Add the Landmark Content Type

Now you need to add the second Content Type needed in the site, Landmark.

Go to **Content Types**, and in the **Content** group, add the Landmark Content Type.

A Landmark is an interesting place that Rides go through. Each Ride may be related to multiple Landmarks.

- **Name**: Landmark
- **Identifier**: landmark

Then add all Fields with the following information: 

| Field Type   | Name             | Identifier       |  Required | Searchable | Translatable |
| ------------ | ---------------- | ---------------- | --------- | ---------- | ------------ |
| Text line    | Name             | `name`           | yes       | yes        | yes          |
| Rich text    | Description      | `description`    | no        | yes        | yes          |
| Image Asset  | Photo            | `photo`          | yes       | no         | no           |
| Map location | Location         | `location`       | yes       | yes        | no           |

Confirm the creation of the Content Type by selecting **Create**.

Create a *Landmarks* Folder and add some Landmarks to it.
Note that you will need pictures (for the Photo Field) to represent them.

## Add Landmarks to Ride Content Type definition

Now edit the Ride Content Type in order to add a Multiple Content Relation between the two Content Types.
Create a new **Content relations (multiple)** Field called "Landmarks" with identifier `landmarks` and allow Content Type "Landmark" to be added to it:

![Adding Landmarks to the Ride Content Type](bike_ride_adding_landmarks_to_the_ride_content_type.png "Adding a relation between the Ride and the Landmark using Content Relations (multiple)")

Confirm by clicking **Save**.

Go back to one of your existing Rides, edit it and link some Landmarks to it.
Click **Publish**.

## Display a list of Landmarks in Ride view

### Create Landmark line view

Now you need to create the line view for Landmarks.

Declare a new override rule in `config/packages/views.yaml`:

``` yaml
ibexa:
    system:
        site:
            content_view:
                #full views here
                line:
                    landmark:
                        template: line/landmark.html.twig
                        match:
                            Identifier\ContentType: landmark
```

Add the template for the line view of a Landmark by creating `templates/line/landmark.html.twig`:

``` html+twig hl_lines="4"
<section>
    <div class="col-xs-4 photos-box">
        <a href="#bikeModal{{ content.id }}" data-toggle="modal">
            {{ ibexa_render_field( content, 'photo', { parameters: { 'alias': 'landmark_list', 'class': 'img-rounded'}}) }}
        </a>
    </div>

    {# MODAL #}
    <div class="bike-modal modal fade" id="bikeModal{{ content.id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="modal-body text-center">
                            <h2>{{ content.name }}</h2>
                            <hr class="featurette-divider">
                            {{ ibexa_render_field( content, 'photo', { parameters: { 'alias': 'large'}, attr: { 'class': 'img-responsive img-rounded' }}) }}
                            {{ ibexa_render_field( content, 'description', { attr: { 'class': 'padding-box text-justify' }}) }}
                            {{ ibexa_render_field( content, 'location', { parameters: {'width': '100%', 'height': '250px', 'showMap': true, 'showInfo': false }}) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
```

Like before, you use an image variation here (line 4) and you need to configure it.
Add the following section to `config/packages/image_variations.yaml`, at the same level as `ride_list`:

``` yaml
landmark_list:
    reference: null
    filters:
        - {name: geometry/scalewidth, params: [200]}
```

### Create the RideController

You must provide additional information when the Ride object is displayed.
This requires creating a custom controller.
The controller uses `ContentService` to load related resources (Landmarks) for a particular Ride.

Create a `src/Controller/RideController.php` file:

``` php
<?php

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Ibexa\Contracts\Core\Repository\ContentService;

class RideController extends Controller
{
    private $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function viewRideWithLandmarksAction(ContentView $view)
    {
        $currentContent = $view->getContent();
        $landmarksListId = $currentContent->getFieldValue('landmarks');
        $landmarksList = [];

        foreach ($landmarksListId->destinationContentIds as $landmarkId) {
            $landmarksList[$landmarkId] = $this->contentService->loadContent($landmarkId);
        }

        $view->addParameters(['landmarksList' => $landmarksList]);

        return $view;
    }
}
```

Update `config/packages/views.yaml` to mention the `RideController.php` by adding a line with the `controller` key to the view config:

``` yaml hl_lines="8"
ibexa:
    system:
        site:
            content_view:
                full:
                    ride:
                        template: full/ride.html.twig
                        controller: App\Controller\RideController::viewRideWithLandmarksAction
                        match:
                            Identifier\ContentType: ride
```

### Add the Landmark in the Ride full view

Now modify the Ride full view template to include a list of Landmarks, and the controller that you just created.
Add the following lines at the end of `templates/full/ride.html.twig`, before the last `</div>` and the closing tag `{% endblock %}`:

``` html+twig
{% if landmarksList is not empty %}
    <div class="row regular-content-size">
        <section class="photos">
            <div class="col-xs-12">
                <h4 class="underscore">{{ 'Landmarks'|trans }}</h4>
            </div>
            {% for landmark in landmarksList %}
                {{ render( controller( "ibexa_content::viewAction", { 'content': landmark, 'viewType': 'line'} )) }}
            {% endfor %}
        </section>
    </div>
{% endif %}
```

You can now check the Ride page again to see all the connected Landmarks.


!!! tip

    You can use `dump()` in Twig templates to display all available variables.

![Ride full view with Landmarks](bike_tutorial_ride_with_landmarks.png)
