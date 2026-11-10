# Step 2 — Prepare the Page

Learn how to build a Page with a custom layout.

Editions: Experience

In this step you can prepare and configure your front page, together with its layout and templates.

## Create Page layout

Go to the front page of your website (`<yourdomain>`). You can see that it looks unfinished. However, you can still use the menu and look around the existing content in the website.

![It's a Dog's World - Starting point](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_starting_point.png "It's a Dog's World - Starting point")

> **Tip: Tip**
>
> At any point in the tutorial if you don't see the results of your last actions, try clearing the cache and regenerating assets:
>
> `php bin/console cache:clear`
>
> `yarn encore <dev|prod>`

Log in to the back office. Go to **Content Structure**. The **Ibexa Digital Experience Platform** content item is the first page that is shown to the visitor. Here you can check what content type it belongs to: it's a *Landing page*.

![Ibexa Digital Experience Platform is a landing page](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_home_is_an_lp.png)

The page is displayed without any template. Click **Edit** to enter a mode that enables you to work with pages. You can see that the home page has only one drop zone.

![Empty Page with default layout](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_empty_single_block.png)

Click the **Fields** button on the left of the top bar to switch to editing page fields. Change the Title of the page to "Home". Then, publish the page to update its name.

The design for the website you're making needs a layout with two zones: a main column and a narrower sidebar. Ibexa Experience provides only a one-zone default layout, so you need to create a new one.

Preparing a new layout requires three things:

- entry in configuration
- thumbnail
- template

### Add entry in configuration

First create a new file for layout configuration, `config/packages/ibexa_fieldtype_page.yaml`:

```yaml
ibexa_fieldtype_page:
    layouts:
        sidebar:
            identifier: sidebar
            name: Right sidebar
            description: Main section with sidebar on the right
            thumbnail: /assets/images/layouts/sidebar.png
            template: layouts/sidebar.html.twig
            zones:
                first:
                    name: First zone
                second:
                    name: Second zone
```

### Add thumbnail

> **Tip: Tip**
>
> For a detailed description of creating a Page layout, see [Page layouts](../../../templating/render_content/render_page/index.md#render-a-layout).

The `sidebar` (line 3) is the internal key of the layout. `name` (line 5) is displayed in the interface when the user selects a layout. The `thumbnail` (line 7) points to an image file that is shown when creating a new landing page next to the name. Use the [supplied thumbnail file](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/public/assets/images/layouts/sidebar.png) and place it in the `public/assets/images/layouts/` folder.

The `template` (line 8) points to the Twig file containing the template for this layout.

### Create page template

Configuration points to `sidebar.html.twig` as the template for the layout. The template defines what zones are available in the layout.

Create a `templates/layouts/sidebar.html.twig` file:

```html+twig
<div class="landing-page__zones">
    <main class="landing-page__zone landing-page__zone--{{ zones[0].id }} col-xs-8" data-ibexa-zone-id="{{ zones[0].id }}">
        {% if zones[0].blocks %}
            {% set locationId = parameters.location is not null ? parameters.location.id : contentInfo.mainLocationId %}

            {% for block in zones[0].blocks %}
                <div class="landing-page__block block_{{ block.type }}" data-ibexa-block-id="{{ block.id }}">
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'locationId': locationId,
                        'contentId': contentInfo.id,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    })) }}
                </div>
            {% endfor %}
        {% endif %}
    </main>
    <aside class="landing-page__zone landing-page__zone--{{ zones[1].id }} col-xs-4" data-ibexa-zone-id="{{ zones[1].id }}">
        {% if zones[1].blocks %}
            {% set locationId = parameters.location is not null ? parameters.location.id : contentInfo.mainLocationId %}

            {% for block in zones[1].blocks %}
                <div class="landing-page__block block_{{ block.type }}" data-ibexa-block-id="{{ block.id }}">
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'locationId': locationId,
                        'contentId': contentInfo.id,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    })) }}
                </div>
            {% endfor %}
        {% endif %}
    </aside>
</div>
```

The above template creates two columns and defines their widths. Each column is at the same time a zone, and each zone renders the blocks that it contains.

> **Tip: Tip**
>
> In sites with multiple layouts you can separate the rendering of zones into a separate `zone.html.twig` template to avoid repeating the same code in every layout.

> **Note: Note**
>
> A zone in a layout template **must have** the `data-ibexa-zone-id` attribute (lines 2 and 19). A block **must have** the `data-ibexa-block-id` attribute (lines 7 and 24).

With these three elements: configuration, icon and template, the new layout is ready to use.

### Change Home Page layout

Now you can change the Home Page to use the new layout. Edit Home and in the top bar select **Switch layout**. Choose the new layout called "Main section with sidebar on the right". The empty zones you defined in the template are visible in the editor.

![Select layout window](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_select_layout.png)

> **Tip: Tip**
>
> If the new layout isn't available when editing the page, you may need to clear the cache (using `php bin/console cache:clear`) and/or reload the app.

![Empty page with new layout](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_new_layout.png)

Publish the Home page. You can notice that it still has some additional text information. This is because the looks of a page are controlled by two separate template files, and you have only prepared one of those. The `sidebar.html.twig` file defines how zones are organized and how content is displayed in them. But you also need a general template file that is used for every page, regardless of its layout.

Add this new template, `templates/full/landing_page.html.twig`:

```html+twig
{% extends 'pagelayout.html.twig' %}

{% block content %}
    <div class="col-md-12">
        {{ ibexa_render_field(content, 'page') }}
    </div>
{% endblock %}
```

This template renders the page content. If there is any additional content or formatting you would like to apply to every page, it should be placed in this template.

Now you need to tell the app to use this template to render pages. Edit the `config/packages/views.yaml` file and add the following code under the `full:` key:

```yaml
                    landing_page:
                        template: full/landing_page.html.twig
                        match:
                            Identifier\ContentType: landing_page
```

After adding this template you can check the new page. The part between menu and footer should be empty, because you haven't added any content to it yet.

![Empty Page](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_empty_page.png)
