# Adding search form

You can add a search form to selected parts of your front page
and configure which parts of the form, such as filters, are rendered.

This example shows how to add a basic search bar to the top of every page
and to configure search form and result rendering.

## Add a search bar

First, include a search bar template in your general layout,
for example, in the `pagelayout.html.twig` for your theme.
This example uses the default `standard` theme.

``` html+twig hl_lines="1"
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/pagelayout.html.twig', 19, 22) =]]
```

Make sure that `pagelayout.html.twig` is included in your view configuration:

``` yaml
[[= include_file('code_samples/front/search/search_bar/config/packages/views.yaml', 0, 5) =]]
```

The `parts/search_bar.html.twig` template uses the built-in `SearchController` to manage the search:

``` html+twig
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/parts/search_bar.html.twig') =]]
```

You can now go to the front page of your installation.
An unstyled search bar appears at the top of the page.

## Search result page

Search results are shown using the `/search` route.
You can go directly to `<yourdomain>/search` to view a full search page.

Select the template that is used on this page with the following configuration:

``` yaml
[[= include_file('code_samples/front/search/search_bar/config/packages/views.yaml') =]]
```

Now, add the `full/search.html.twig` template:

``` html+twig hl_lines="5"
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/full/search.html.twig') =]]
```

This template replaces the default table displaying search results with a simple unnumbered list.

## Search form

In line 5 the template above includes a separate template for the search form.
Create this file in `parts/search_form.html.twig`:

``` html+twig
[[= include_file('code_samples/front/search/search_bar/templates/themes/standard/parts/search_form.html.twig') =]]
```

This template renders only the basic query field and a submit button.
`'render_rest': false` ensures that the fields you do not explicitly add to the template are not rendered
(in this case, date selection, Content Type, and so on).
