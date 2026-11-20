# Add search form to front page

Add a search bar and customize the search form in your site front end.

You can add a search form to selected parts of your front page and decide which parts of the form, such as filters, are rendered.

This example shows how to add a basic search bar to the top of every page and to configure search form and result rendering.

## Add a search bar

First, prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file, and include a search bar in this template:

```html+twig
{% include '@ibexadesign/parts/search_bar.html.twig' %}
{% block content %}
{% endblock %}
```

Then, make sure that `pagelayout.html.twig` is included in your view configuration:

```yaml
ibexa:
    system:
        site_group:
            page_layout: '@ibexadesign/pagelayout.html.twig'
            search_view:
```

The `parts/search_bar.html.twig` template uses the built-in `SearchController` to manage the search:

```html+twig
<div class="search-bar">
    {{ render(controller('Ibexa\\Bundle\\Search\\Controller\\SearchController::searchAction')) }}
</div>
```

You can now go to the front page of your installation. An unstyled search bar appears at the top of the page.

## Customize search result page

Search results are shown in the `/search` route. You can go directly to `<yourdomain>/search` to view a full search page.

Select the template that is used on this page with the following configuration:

```yaml
ibexa:
    system:
        site_group:
            page_layout: '@ibexadesign/pagelayout.html.twig'
            search_view:
                full:
                    default:
                        template: "@ibexadesign/full/search.html.twig"
                        match: [ ]
```

Now, add the `full/search.html.twig` template:

```html+twig
{% block content %}
    <div>
        <div>
            <section>
                {% include '@ibexadesign/parts/search_form.html.twig' with { form: form } %}

                {% if results is defined %}
                    <div>
                        <div>{{ 'search.header'|trans({'%total%': pager.nbResults})|desc('%total% search result(s):') }}</div>
                    </div>

                    {% if results is empty %}
                        <div>
                            <table>
                                <tr>
                                    <td colspan="4">
                                        <span>{{ 'search.no_result'|trans({'%query%': form.vars.value.query})|desc('No results found for "%query%".') }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    {% else %}
                        <h2>{{ 'search.name'|trans|desc('Name') }}</h2>
                        <ul>
                            {% for row in results %}
                                <li>
                                    <a href="{{ path('ibexa.content.view', {
                                        'contentId': row.contentId,
                                        'languageCode': row.translation_language_code,
                                    }) }}">{{ row.name }}</a>
                                </li>
                            {% endfor %}
                        </ul>

                        {% if pager.haveToPaginate %}
                            <div>
                                {{ pagerfanta(pager, '', {'pageParameter': '[search][page]'}) }}
                            </div>
                        {% endif %}
                    {% endif %}
                {% endif %}
            </section>
        </div>
    </div>
{% endblock %}
```

This template replaces the default table that displays search results with an unnumbered list.

## Render search form

In the template above, line 5 includes a separate template for the search form. Create the `parts/search_form.html.twig` file:

```html+twig
{{ form_start(form) }}

<div>
    {{ form_row(form.query) }}
    <button type="submit">
        {{ 'search.search'|trans|desc('Search') }}
    </button>
</div>

{{ form_end(form, {'render_rest': false}) }}
```

This template renders only a basic query field and a submit button. `'render_rest': false` ensures that the fields you don't explicitly add to the template aren't rendered (in this case, date selection, content type, and more).
