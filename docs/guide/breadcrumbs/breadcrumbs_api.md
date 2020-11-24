# Breadcrumb API [[% include 'snippets/commerce_badge.md' %]]

The controller method `BreadcrumbsController::renderBreadcrumbsAction()` uses the `BreadcrumbsAggregateGenerator` to render the breadcrumbs from the controller.

`BreadcrumbsAggregateGenerator` collects all generators that generate breadcrumbs. 
A compiler pass gets all services that are tagged with `siso_core.breadcrumbs_generator`.
The aggregate generator loops through all collected generators to check which generator can render breadcrumbs.

The first generator, in order of priority, that returns true from `canRenderBreadcrumbs()` is used to render the breadcrumbs.

|Method|Description|
|--- |--- |
|`canRenderBreadcrumbs(Request $request)`|Verifies whether the generator should render breadcrumbs for the current request.|
|`renderBreadcrumbs(Request $request)`|Renders breadcrumbs for the current request.|

## Breadcrumb generators

|Name|Description|
|--- |--- |
|`PostSilverModuleBreadcrumbsGenerator`|Renders breadcrumbs for a silver.module element which processes the controller of the previous silver.module. silver.modules themselves are standard Content items and their breadcrumbs are handled solely by the parent of the `EzContentBreadcrumbsGenerator` class.|
|`EzContentBreadcrumbsGenerator`|Handles breadcrumbs for a Content item. Renders all elements of the path of the currently displayed Location as breadcrumbs, up to the content root.|
|`CatalogBreadcrumbsGenerator`|Renders breadcrumbs for a catalog element. Uses the `CatalogDataProvider` to fetch all catalog parent elements up to the catalog root element for the last half of the breadcrumbs. As the catalog root is part of the Content Tree, it fetches the parent Locations of this element as the first half of the breadcrumbs and prepends them.|
|`RoutesBreadcrumbsGenerator`|Renders breadcrumbs if the route for the action contains the `breadcrumb_path` and `breadcrumb_names` keys. This generator must be registered with the lowest priority and functions as a fallback.|
