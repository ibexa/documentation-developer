---
description: See how you can manage Ibexa DXP configuration files.
---

# Step 6 — Improve configuration

## Define image variations

Image variations are different versions of the same image. You can use them to scale images, crop them, add effects, etc.

So far the images in the ride list are fitted to the templates automatically, and the result does not look good.
Now you will create a variation to specify how you want the images to look in detail.

Create a new `config/packages/image_variations.yaml` file containing:

``` yaml
ibexa:
    system:
        default:
            image_variations:
                ride_list:
                    reference: null
                    filters:
                        - {name: geometry/scaledownonly, params: [140, 100]}
```

Next, modify the templates to use these variations. Variation names are provided as parameters when rendering the image content.

In `templates/line/rides.html.twig` add the `'alias': 'ride_list'` parameter in the following way, in lines 8-10:

``` html+twig
{% if not ibexa_field_is_empty( content, 'photo' ) %}
    {{ ibexa_render_field(content, 'photo', {
        'parameters': {
            'alias': 'ride_list'
        }
    }) }}
{% endif %}
```

This ensures that the photo displayed next to each Ride in the list will be scaled down properly with proportions retained.

Clear cache and refresh the front page. Photos should now have a regular size and fit in the table.

![Ride list with proper image variations](bike_tutorial_ride_list.png)

## Separate view configuration

In a larger site there are many elements that need configuration. To keep it more organized, you can split parts of configuration into separate files.

As an example, you can separate all content view configuration into its own file. Create a `config/packages/views.yaml` file. 
Copy everything under `content_view` from `config/packages/ibexa.yaml` and move it to the new file.
Remove the corresponding code from `ibexa.yaml`. 

The `views.yaml` file should look like this:

``` yaml
ibexa:
    system:
        site:
            content_view:
                full:
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
                    ride:
                        template: full/ride.html.twig
                        match:
                            Identifier\ContentType: ride
                line:
                    ride:
                        template: line/rides.html.twig
                        match:
                            Identifier\ContentType: ride
```
