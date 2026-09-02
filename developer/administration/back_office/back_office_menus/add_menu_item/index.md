# Add menu item

Create a custom menu in the back office.

To add a new menu entry in the back office, you need to use an event subscriber and subscribe to [one of the events](../back_office_menus/index.md#menu-events) dispatched when building menus.

The following example shows how to add a "Content list" item to the main top menu and list all content items there, with a shortcut button to edit them.

## Create event subscriber

First, create an event subscriber in `src/EventSubscriber/MyMenuSubscriber.php`:

```php
<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Ibexa\AdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyMenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMainMenuConfigure', 0],
        ];
    }

    public function onMainMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $customMenuItem = $menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
            'main__content__custom_menu',
            [
                'extras' => [
                    'orderNumber' => 100,
                ],
            ],
        );

        $customMenuItem->addChild(
            'all_content_list',
            [
                'label' => 'Content List',
                'route' => 'all_content_list.list',
                'attributes' => [
                    'class' => 'custom-menu-item',
                ],
                'linkAttributes' => [
                    'class' => 'custom-menu-item-link',
                ],
            ]
        );
    }
}
```

This subscriber subscribes to the `ConfigureMenuEvent::MAIN_MENU` event (see line 14). It creates a subitem with the identifier `main__content__custom_menu` (lines 22-23). Then, under this subitem, it creates an `all_content_list` menu item (lines 31-32).

## Add route

Next, configure the route that the menu item leads to:

```yaml
all_content_list.list:
    path: /all_content_list/{page}
    defaults:
        page: 1
        _controller: App\Controller\AllContentListController::listAction
```

## Create controller

The route indicates a controller that fetches all visible content items and renders the view.

Create the following controller file in `src/Controller/AllContentListController.php`:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\AdminUi\Form\Factory\FormFactory;
use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class AllContentListController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly FormFactory $formFactory
    ) {
    }

    public function listAction(int $page = 1): Response
    {
        $query = new LocationQuery();

        $query->query = new Criterion\Visibility(Criterion\Visibility::VISIBLE);

        $paginator = new Pagerfanta(
            new LocationSearchAdapter($query, $this->searchService)
        );
        $paginator->setMaxPerPage(8);
        $paginator->setCurrentPage($page);
        $editForm = $this->formFactory->contentEdit();

        return $this->render('@ibexadesign/all_content_list.html.twig', [
            'totalCount' => $paginator->getNbResults(),
            'articles' => $paginator,
            'form_edit' => $editForm,
        ]);
    }
}
```

## Add template

Finally, create the `templates/themes/admin/list/all_content_list.html.twig` file indicated in line 37 in the controller:

```html+twig
{% extends '@ibexadesign/ui/layout.html.twig' %}

{% block title %}{{ 'Content List'|trans }}{% endblock %}

{%- block breadcrumbs -%}
    {% include '@ibexadesign/ui/breadcrumbs.html.twig' with { items: [
        { value: 'breadcrumb.admin'|trans(domain='messages')|desc('Admin') },
        { value: 'url.list'|trans|desc('Content List') }
    ]} %}
{%- endblock -%}

{%- block header -%}
    {% include '@ibexadesign/ui/page_title.html.twig' with {
        title: 'url.list'|trans|desc('Content List'),
    } %}
{%- endblock -%}

{%- block content -%}
    <section class="container ibexa-container">
        {% set body_rows = [] %}
        {% for article in articles.currentPageResults %}

            {% set col_edit %}
                <button class="btn ibexa-btn ibexa-btn--ghost ibexa-btn--content-edit"
                        title="{{ 'dashboard.table.all.content.edit'|trans|desc('Edit Content') }}"
                        data-content-id="{{ article.contentInfo.id }}"
                        data-version-no="{{ article.contentInfo.currentVersionNo }}"
                        data-language-code="{{ article.contentInfo.mainLanguageCode }}">
                    <svg class="ibexa-icon ibexa-icon--small ibexa-icon--edit">
                        <use xlink:href="{{ ibexa_icon_path('edit') }}"></use>
                    </svg>
                </button>
            {% endset %}

            {% set body_rows = body_rows|merge([{
                cols: [
                    { content: article.contentInfo.name },
                    { content: article.contentInfo.contentType.name },
                    { content: article.contentInfo.modificationDate|ibexa_full_datetime },
                    { content: article.contentInfo.publishedDate|ibexa_full_datetime },
                    { content: col_edit, raw: true },
                ],
            }]) %}
        {% endfor %}

        {% include '@ibexadesign/ui/component/table/table.html.twig' with {
            headline: 'Content List',
            head_cols: [
                { content: 'Content name'|trans },
                { content: 'Content type'|trans },
                { content: 'Modified'|trans },
                { content: 'Published'|trans },
                { content: '' },
            ],
            class: 'ibexa-table',
            body_rows
        } %}

        {% if articles.haveToPaginate %}
            {% include '@ibexadesign/ui/pagination.html.twig' with {
                'pager': articles
            } %}
        {% endif %}
    </section>
    {{ form_start(form_edit, {
        'action': path('ibexa.content.edit'),
        'attr':
        { 'class': 'ibexa-edit-content-form'}
    }) }}
    {{ form_widget(form_edit.language, {'attr': {'hidden': 'hidden', 'class': 'language-input'}}) }}
    {{ form_end(form_edit) }}
    {% include '@ibexadesign/content/modal/version_conflict.html.twig' %}
{%- endblock -%}

{% block javascripts %}
    {{ encore_entry_script_tags('ibexa-admin-ui-dashboard-js', null, 'ibexa') }}
{%- endblock -%}
```

This template uses the [reusable table template](../../back_office_elements/reusable_components/index.md#tables) to render a table that fits the style of the back office.

You can configure the columns of the table in the `head_cols` variable and the regular table rows in `body_rows`. In this case, `body_rows` contains information about the content item provided by the controller, and an edit button.
