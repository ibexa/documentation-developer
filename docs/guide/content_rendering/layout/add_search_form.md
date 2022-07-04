---
description: Add a search bar and customize the search form in your site front end.
---

# Add search form to front page

You can add a search form to selected parts of your front page
and decide which parts of the form, such as filters, are rendered.

This example shows how to add a basic search bar to the top of every page
and to configure search form and result rendering.

## Add a search bar

First, prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file, 
and include a search bar in this template:

``` html+twig hl_lines="1"
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/pagelayout.html.twig', 19, 22) =]]
```

Then, make sure that `pagelayout.html.twig` is included in your view configuration:

``` yaml
[[= include_file('code_samples/front/search/search_bar/config/packages/views.yaml', 0, 5) =]]
```

The `parts/search_bar.html.twig` template uses the built-in `SearchController` to manage the search:

``` html+twig
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/parts/search_bar.html.twig') =]]
```

You can now go to the front page of your installation.
An unstyled search bar appears at the top of the page.

## Customize search result page

Search results are shown in the `/search` route.
You can go directly to `<yourdomain>/search` to view a full search page.

Select the template that is used on this page with the following configuration:

``` yaml
[[= include_file('code_samples/front/search/search_bar/config/packages/views.yaml') =]]
```

Now, add the `full/search.html.twig` template:

``` html+twig hl_lines="5"
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/full/search.html.twig') =]]
```

This template replaces the default table that displays search results with a simple unnumbered list.

## Render search form

In the template above, line 5 includes a separate template for the search form.
Create the `parts/search_form.html.twig` file:

``` html+twig
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/parts/search_form.html.twig') =]]
```

This template renders only a basic query field and a submit button.
`'render_rest': false` ensures that the fields you do not explicitly add to the template are not rendered
(in this case, date selection, Content Type, and so on).
