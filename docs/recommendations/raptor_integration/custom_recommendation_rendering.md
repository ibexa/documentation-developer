---
description: Use existing controllers to render recommendations outside the Page Builder.
month_change: true
---

## Custom recommendation rendering

You can use existing controllers to render [recommendations](recommendation_blocks.md) outside the Page Builder.
The controllers responsible for rendering block recommendations on the front-end are independent, can they be used to render recommendations for specific strategies.

Each controller can be used to retrieve and display recommendations within a Twig template as follows:

``` html+twig
{{ render(controller('<Controller name>', {
    'limit': limit,
    'template': '@ibexadesign/<your_template_path>.html.twig',
    '<another_parameter>': parameter_value
})) }}
```

Each controller always requires these two parameters:

- **limit** – the number of recommendations to render
- **template** – the path to the template

Any other required parameters are specific to each controller and are detailed in the **Parameters** column of the table below:

|Block name|Controller|Parameters|Recommendation item type|
|----------|----------|----------|------------------------|
|[Content that have been seen along with the item category]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#content-that-have-been-seen-along-with-the-item-category-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\ContentBasedOnProductCategoryBlockController::showAction`|`categoryId` (integer), `limit` (integer), `template` (string)|Content|
|[Most popular content]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-content-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularContentBlockController::showAction`|`limit` (integer), `template` (string)|Content|
|[Most popular products]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-products-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularItemsBlockController::showAction`|`showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|[Most popular products in category]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-products-in-category-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularItemsInCategoryBlockController::showAction`|`categoryId` (numeric), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|[Other customers have also seen]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\SimilarItemsBlockController::showAction`|`productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|[Other customers have also seen this content]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-this-content-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\SimilarContentBlockController::showAction`|`contentId` (integer), `limit` (integer), `template` (string)|Content|
|[Other Customers Have also Purchased block]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-purchased-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\OtherCustomersAlsoPurchasedBlockController::showAction`|`productCode` (string), `limit` (integer), `template` (string)|Product|
|[Personalized content recommendations]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#personalized-content-recommendations-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserContentRecommendationsBlockController::showAction`|`limit` (integer), `template` (string)|Content|
|[The Personal Shopping Assistant]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#the-personal-shopping-assistant-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserItemRecommendationsBlockController::showAction`|`productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|[User's item history]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#users-item-history-block)|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserItemHistoryBlockController::showAction`|`showInStock` (boolean), `limit` (integer), `template` (string)|Product|

Each template receives a `recommendations` Twig variable, which is a list containing either `\Ibexa\Contracts\ProductCatalog\Values\ProductInterface` instances for product recommendations or `\Ibexa\Contracts\ProductCatalog\Values\ProductInterface` instances for content recommendations.
The exact type depends on the controller and its associated strategy being used.

Two generic templates are provided and can be used in `./templates/themes/<theme>` directory:

- `@ibexadesign/ibexa/recommendations/_content_list.html.twig` for content items:

``` html+twig
{% if recommendations is not empty %}
    {% for content in recommendations %}
        {% set location = content.contentInfo.mainLocation %}
        {% if location %}
            <p><a href="{{ ibexa_path(location) }}">{{ ibexa_content_name(content) }}</a></p>
        {% else %}
            <p>{{ ibexa_content_name(content) }}</p>
        {% endif %}
    {% endfor %}
{% endif %}
```

- `@ibexadesign/ibexa/recommendations/_product_list.html.twig` for product items:

``` html+twig
{% if recommendations is not empty %}
    <ul>
        {% for product in recommendations %}
            <li><a href="{{ ibexa_path(product) }}">{{ product.name }}</a></li>
        {% endfor %}
    </ul>
{% endif %}
```

To fetch recommendations for the remaining modules, you need to [create a custom controller](../../templating/queries_and_controllers/controllers.md) and use a method from `\Ibexa\Contracts\ConnectorRaptor\Recommendations\RecommendationsServiceInterface`.

Using this method, recommendations can be displayed on any page, for example on a specific product page, as shown below:

![Custom rendering](custom_rendering.png)
