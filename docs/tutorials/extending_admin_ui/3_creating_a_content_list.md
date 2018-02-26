# Creating a content list

The next thing you will extend in this tutorial is the top menu.

TODO SCREENSHOT

You will add a "Content list" item under "Content". It will list all Content items existing in the Repository.
You will be able to filter the list by Content Types using a drop-down menu.

## Add an event listener

The first step is to add an event listener.

To register the listener as a service, add the following block to `src/EzSystems/ExtendingTutorialBundle/Resources/config/services.yml`:

``` yaml
EzSystems\ExtendingTutorialBundle\EventListener\:
    resource: '../../EventListener/*'
    autowire: true
    autoconfigure: true
    public: true
    tags:
        - { name: kernel.event_subscriber }
```

Then create a `MyMenuListener.php` file in `src/EzSystems/ExtendingTutorialBundle/EventListener`:

``` php hl_lines="12 26"
<?php

namespace EzSystems\ExtendingTutorialBundle\EventListener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyMenuListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMenuConfigure', 0],
        ];
    }

    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $factory = $event->getFactory();
        $options = $event->getOptions();

        $menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
            'all_content_list',
            [
                'label' => 'Content List',
                'route' => 'ezsystems_extending_tutorial.all_content_list.list',
            ]
        );
    }
}
```

This listener subscribes to the `ConfigureMenuEvent::MAIN_MENU` event (see line 12).

Line 26 points to the new route that you need to add to the routing file.

## Add routing

Add the following block to `src/EzSystems/ExtendingTutorialBundle/Resources/config/routing.yml`:

``` yaml hl_lines="4"
ezsystems_extending_tutorial.all_content_list.list:
    path: /all_content_list
    defaults:
        _controller: 'EzSystemsExtendingTutorialBundle:AllContentList:list'
```

## Create a controller

As you can see in the code above, the next step is creating a controller that will take care of the article list view.

Firs, ensure that the controller is configured in `services.yml`.
Add the following block to that file:

``` yaml
EzSystems\ExtendingTutorialBundle\Controller\:
    resource: "../../Controller/*"
    autowire: true
    autoconfigure: true
    public: false
    exclude: "../../Controller/{Controller}"
```

Then, in `src/EzSystems/ExtendingTutorialBundle/Controller` create a `AllContentListController.php` file:

```php hl_lines="31"
<?php

namespace EzSystems\ExtendingTutorialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;

class AllContentListController extends Controller
{
    private $searchService;

    private $contentTypeService;

    public function __construct(SearchService $searchService, ContentTypeService $contentTypeService)
    {
        $this->searchService = $searchService;
        $this->contentTypeService = $contentTypeService;
    }

    public function listAction()
    {
        $query = new LocationQuery();

        $query->query = new Criterion\LogicalAnd([
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
        ]);

        $results = $this->searchService->findLocations($query);

        return $this->render('@EzSystemsExtendingTutorial/list/all_content_list.html.twig', [
            'articles' => $results,
        ]);
    }
}
```

The highlighted line 31 indicates the template that will be used to display the list.

## Add a template

Finally, create an `all_content_list.html.twig` file in `src/EzSystems/ExtendingTutorialBundle/Resources/views/list`:

``` twig
{% extends 'EzPlatformAdminUiBundle::layout.html.twig' %}

{% block title %}{{ 'Content List'|trans }}{% endblock %}

{%- block breadcrumbs -%}
    {% include '@EzPlatformAdminUi/parts/breadcrumbs.html.twig' with { items: [
        { value: 'url.list'|trans|desc('Content List') }
    ]} %}
{%- endblock -%}

{%- block page_title -%}
    {% include '@EzPlatformAdminUi/parts/page_title.html.twig' with {
        title: 'url.list'|trans|desc('Content List'),
        iconName: 'article'
    } %}
{%- endblock -%}

{%- block content -%}
    <section class="container mt-4">
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
                </tr>
            </thead>
            <tbody>
            {% for article in articles.searchHits %}
                <tr>
                    <td><a href={{path('ez_urlalias', {'contentId': article.valueObject.contentInfo.id})}}>{{ ez_content_name(article.valueObject.contentInfo) }}</a></td>
                    <td>{{ article.valueObject.contentInfo.contentTypeId }}</td>
                    <td>{{ article.valueObject.contentInfo.modificationDate|localizeddate( 'short', 'medium' ) }}</td>
                    <td>{{ article.valueObject.contentInfo.publishedDate|localizeddate( 'short', 'medium' ) }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </section>
{%- endblock -%}
```

## Check results

At this point you can go to the Back Office and under "Content" you will see the new "Content list" item.
Select it and you will see the list of all Content items in the Repository.

TODO SCREENSHOT
