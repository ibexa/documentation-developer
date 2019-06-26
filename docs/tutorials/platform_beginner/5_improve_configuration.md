# Step 5 - Improve configuration

## Define image variations

Image variations are different versions of the same image. You can use them to scale images, crop them, add effects, etc.

So far the images in the ride list are fitted to the templates automatically, and the result does not look good.
Now you will create a variation to specify how you want the images to look in detail.

Create a new file: `app/config/image_variations.yaml`:

``` yaml
ezpublish:
    system:
        default:
            image_variations:
                ride_list:
                    reference: null
                    filters:
                        - {name: geometry/scaledownonly, params: [140, 100]}
```

At the beginning of the `ezplatform.yaml` file (before the `ezplatform` key), add the following lines to import the content of `app/config/image_variations.yaml`:

``` yaml
imports:
    - { resource: image_variations.yaml }
```

Next, modify the templates to use these variations. Variation names are provided as parameters when rendering the image content.

In `app/Resources/views/line/ride.html.twig` add the `'alias': 'ride_list'` parameter in the following way, in lines 8-10:

``` html+twig
{% if not ez_is_field_empty( content, 'photo' ) %}
    {{ ez_render_field(content, 'photo', {
        'parameters': {
            'alias': 'ride_list'
        }
    }) }}
{% endif %}
```

This ensures that the photo displayed next to each Ride in the list will be scaled down properly with proportions retained.

Clear cache and refresh the front page. Photos should now have a regular size and fit in the table.

![Ride list with proper image variations](img/bike_tutorial_ride_list.png)

## Separate view configuration

In a larger site there are many elements that need configuration. To keep it more organized, you can split parts of configuration into separate files.

As an example, you can separate all content view configuration into its own file. Create an `app/config/views.yaml` file. Copy everything under `content_view` from `ezplatform.yaml` and move it to the new file.
Remove the corresponding code from `ezplatform.yaml`. The `views.yaml` should look like this:

``` yaml
ezplatform:
    system:
        site_group:
            content_view:
                full:
                    ride:
                        template: full/ride.html.twig
                        match:
                            Identifier\ContentType: ride
                    home_page:
                        template: full/home_page.html.twig
                        match:
                            Id\Location: 2
                line:
                    ride:
                        template: line/ride.html.twig
                        match:
                            Identifier\ContentType: ride
```

Import the file in `ezplatform.yaml`, like you did with `image_variations.yaml`:

``` yaml
- { resource: views.yaml }
```
