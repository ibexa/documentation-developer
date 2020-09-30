# Step 3b - Adding an edit button

In this step you will add an edit button to the content list. The following tutorial is requires the completed [Step 2 - Creating a top menu item](2_creating_a_content_list.md).

## Modify the controller

Introduce changes to `src/Controller/AllContentListController.php`, so that it enables content editing from the content list.

First, inject the `EzSystems\EzPlatformAdminUi\Form\Factory\FormFactory` service into your controller.

To do so, add the new `FormFactory $formFactory` parameter and the `$this->formFactory = $formFactory;` argument to the `__construct` function:

```php hl_lines="4 8"
public function __construct(
    SearchService $searchService,
    ContentTypeService $contentTypeService,
    FormFactory $formFactory
) {
    $this->searchService = $searchService;
    $this->contentTypeService = $contentTypeService;
    $this->formFactory = $formFactory;
}
```

Next, provide a new use statement for `FormFactory` parameter:

```php
use EzSystems\EzPlatformAdminUi\Form\Factory\FormFactory;
```

Create an underlying form for handling requests for content editing.
Add the following code line after e.g. the lines setting the `$paginator` parameters:

```php
$editForm = $this->formFactory->contentEdit();
```

Finally, provide the new parameter to `$this->render`. It can be added after e.g. `articles`:

``` php
'form_edit' => $editForm->createView(),
```

??? tip "Complete controller code"

    ```php hl_lines="6 20 25 30 45 49"
    <?php
    
    namespace App\Controller;
    
    use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
    use EzSystems\EzPlatformAdminUi\Form\Factory\FormFactory;
    use eZ\Publish\API\Repository\SearchService;
    use eZ\Publish\API\Repository\ContentTypeService;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
    use eZ\Publish\API\Repository\Values\Content\LocationQuery;
    use eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter;
    use Pagerfanta\Pagerfanta;
    
    class AllContentListController extends Controller
    {
        private $searchService;
    
        private $contentTypeService;
    
        private $formFactory;
    
        public function __construct(
            SearchService $searchService,
            ContentTypeService $contentTypeService,
            FormFactory $formFactory
        )
        {
            $this->searchService = $searchService;
            $this->contentTypeService = $contentTypeService;
            $this->formFactory = $formFactory;
        }
    
        public function listAction($page = 1)
        {
            $query = new LocationQuery();
            $criterions = [
                new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            ];
            $query->query = new Criterion\LogicalAnd($criterions);
            $paginator = new Pagerfanta(
                new LocationSearchAdapter($query, $this->searchService)
            );
            $paginator->setMaxPerPage(8);
            $paginator->setCurrentPage($page);
            $editForm = $this->formFactory->contentEdit();
            return $this->render('list/all_content_list.html.twig', [
                'totalCount' => $paginator->getNbResults(),
                'articles' => $paginator,
                'form_edit' => $editForm->createView(),
            ]);
        }
    }
    ```

## Change the template

The last thing to do is to add the edit button to the content list template.
All the code blocks below should be added to `templates/list/all_content_list.html.twig`.

First, add a `<th>{{ 'Edit'|trans }}</th>` header to the content list table inside `<section class="container my-4">`:

```html+twig  hl_lines="8"
<table class="table">
    <thead>
    <tr>
        <th>{{ 'Content name'|trans }}</th>
        <th>{{ 'Content Type'|trans }}</th>
        <th>{{ 'Modified'|trans }}</th>
        <th>{{ 'Published'|trans }}</th>
        <th>{{ 'Edit'|trans }}</th>
    </tr>
    </thead>
```

Next, add the edit button as a new `<td>` tag inside `<section class="container my-4">`:

```html+twig
<td>
    <button class="btn btn-icon mx-2 ez-btn--content-edit"
            title="{{ 'dashboard.table.all.content.edit'|trans|desc('Edit Content') }}"
            data-content-id="{{ article.contentInfo.id }}"
            data-version-no="{{ article.contentInfo.currentVersionNo }}"
            data-language-code="{{ article.contentInfo.mainLanguageCode }}">
        <svg class="ez-icon ez-icon-edit">
            <use xlink:href="{{ asset('bundles/ezplatformadminui/img/ez-icons.svg') }}#edit"></use>
        </svg>
    </button>
</td>
```

After that, add a hidden form for redirecting to the content edit page by adding the following code block inside `{%- block content -%}`, right under `<section class="container my-4">`:

```html+twig
{{ form_start(form_edit, {
    'action': path('ezplatform.content.edit'),
    'attr':
    { 'class': 'ez-edit-content-form'}
}) }}
{{ form_widget(form_edit.language, {'attr': {'hidden': 'hidden', 'class': 'language-input'}}) }}
{{ form_end(form_edit) }}
{% include '@ezdesign/content/modal/version_conflict.html.twig' %}
```

Finally, add a JavaScript block with js listeners at the end of the twig file:

```html+twig
{% block javascripts %}
    {{ encore_entry_script_tags('ezplatform-admin-ui-dashboard-js', null, 'ezplatform') }}
{%- endblock -%}

```

??? tip "Complete template code"

    ``` html+twig hl_lines="30 40 41 42 43 44 45 46 47 48 49 50 57 58 59 60 61 62 63 64 67 68 69"
    {% extends '@ezdesign/ui/layout.html.twig' %}
    
    {% block title %}{{ 'Content List'|trans }}{% endblock %}
    
    {%- block breadcrumbs -%}
        {% include '@ezdesign/ui/breadcrumbs.html.twig' with { items: [
            { value: 'url.list'|trans|desc('Content List') }
        ]} %}
    {%- endblock -%}
    
    {%- block page_title -%}
        {% include '@ezdesign/ui/page_title.html.twig' with {
            title: 'url.list'|trans|desc('Content List'),
            icon_name: 'article'
        } %}
    {%- endblock -%}
    
    {%- block content -%}
        <section class="container my-4">
            <div class="ez-table-header">
                <div class="ez-table-header__headline">{{ "Content List"|trans }}</div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ 'Content name'|trans }}</th>
                    <th>{{ 'Content Type'|trans }}</th>
                    <th>{{ 'Modified'|trans }}</th>
                    <th>{{ 'Published'|trans }}</th>
                    <th>{{ 'Edit'|trans }}</th>
                </tr>
                </thead>
                <tbody>
                {% for article in articles %}
                    <tr>
                        <td><a href={{ez_path(article)}}>{{ ez_content_name(article.contentInfo) }}</a></td>
                        <td>{{ article.contentInfo.contentTypeId }}</td>
                        <td>{{ article.contentInfo.modificationDate|ez_full_datetime }}</td>
                        <td>{{ article.contentInfo.publishedDate|ez_full_datetime }}</td>
                        <td>
                            <button class="btn btn-icon mx-2 ez-btn--content-edit"
                                    title="{{ 'dashboard.table.all.content.edit'|trans|desc('Edit Content') }}"
                                    data-content-id="{{ article.contentInfo.id }}"
                                    data-version-no="{{ article.contentInfo.currentVersionNo }}"
                                    data-language-code="{{ article.contentInfo.mainLanguageCode }}">
                                <svg class="ez-icon ez-icon-edit">
                                    <use xlink:href="{{ asset('bundles/ezplatformadminui/img/ez-icons.svg') }}#edit"></use>
                                </svg>
                            </button>
                        </td>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
            {{ pagerfanta(articles, 'ez') }}
        </section>    
        {{ form_start(form_edit, {
            'action': path('ezplatform.content.edit'),
            'attr':
            { 'class': 'ez-edit-content-form'}
        }) }}
        {{ form_widget(form_edit.language, {'attr': {'hidden': 'hidden', 'class': 'language-input'}}) }}
        {{ form_end(form_edit) }}
        {% include '@ezdesign/content/modal/version_conflict.html.twig' %}
    {%- endblock -%}
    
    {% block javascripts %}
        {{ encore_entry_script_tags('ezplatform-admin-ui-dashboard-js', null, 'ezplatform') }}
    {%- endblock -%}
    ```

## Check results

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

At this point you should see the edit button beside each Content item in the content list.
Select the edit button to change your Content items.

![Edit button in content list](img/content_list_edit.png "Edit button in content list")
