# Custom recommendation rendering

Use existing controllers to render recommendations outside the Page Builder.

You can use existing controllers to render [recommendations](../recommendation_blocks/index.md) outside the Page Builder. The controllers responsible for rendering block recommendations on the front-end are independent and can be used to render recommendations for specific strategies.

Each controller can be used to retrieve and display recommendations within a Twig template as follows:

```html+twig
{{ render(controller('<Controller name>', {
    'limit': limit,
    'template': '@ibexadesign/<your_template_path>.html.twig',
    '<another_parameter>': parameter_value
})) }}
```

The controllers are placed in the `Ibexa\Bundle\ConnectorRaptor\Controller\Block` namespace.

Each controller always requires these two parameters:

- **limit** – the number of recommendations to render
- **template** – the path to the template

Any other required parameters are specific to each controller and are detailed in the **Parameters** column of the table below:

| Block name                                                                                                                                                                                                                                                                                     | Controller                                                      | Parameters                                                                              | Recommendation item type |
| ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------- | --------------------------------------------------------------------------------------- | ------------------------ |
| [Content that have been seen along with the item category](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#content-that-has-been-seen-along-with-the-item-category-block)                                                      | `ContentBasedOnProductCategoryBlockController` `::showAction()` | `categoryId` (integer), `limit` (integer), `template` (string)                          | Content                  |
| [Items associated with the given Content](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#items-associated-with-the-given-content-block)                                                                                       | `ItemsBasedOnContentBlockController` `::showAction()`           | `contentId` (integer), `limit` (integer), `template` (string)                           | Product                  |
| [Items of Customized Feeds sorted by personal preferences and popularity or trendiness](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#items-of-customized-feeds-sorted-by-personal-preferences-and-popularity-or-trendiness) | `MerchandisingItemsBlockController` `::showAction()`            | `merchandisingCampaignId` (string), `limit` (integer), `template` (string)              | Product                  |
| [Merchandising content sorted by personal preferences and popularity](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#merchandising-content-sorted-by-personal-preferences-and-popularity)                                     | `MerchandisingContentBlockController` `::showAction()`          | `merchandisingCampaignId` (string), `limit` (integer), `template` (string)              | Content                  |
| [Most popular content](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#most-popular-content-block)                                                                                                                             | `PopularContentBlockController` `::showAction()`                | `limit` (integer), `template` (string)                                                  | Content                  |
| [Most popular products](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#most-popular-products-block)                                                                                                                           | `PopularItemsBlockController` `::showAction()`                  | `showInStock` (boolean), `limit` (integer), `template` (string)                         | Product                  |
| [Most popular products in category](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#most-popular-products-in-category-block)                                                                                                   | `PopularItemsInCategoryBlockController` `::showAction()`        | `categoryId` (integer), `showInStock` (boolean), `limit` (integer), `template` (string) | Product                  |
| [Other customers have also seen](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#other-customers-have-also-seen-block)                                                                                                         | `SimilarItemsBlockController` `::showAction()`                  | `productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string) | Product                  |
| [Other customers have also seen this content](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#other-customers-have-also-seen-this-content-block)                                                                               | `SimilarContentBlockController` `::showAction()`                | `contentId` (integer), `limit` (integer), `template` (string)                           | Content                  |
| [Other Customers Have also Purchased block](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#other-customers-have-also-purchased-block)                                                                                         | `OtherCustomersAlsoPurchasedBlockController` `::showAction()`   | `productCode` (string), `limit` (integer), `template` (string)                          | Product                  |
| [Personalized content recommendations](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#personalized-content-recommendations-block)                                                                                             | `UserContentRecommendationsBlockController` `::showAction()`    | `limit` (integer), `template` (string)                                                  | Content                  |
| [The Personal Shopping Assistant](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#the-personal-shopping-assistant-block)                                                                                                       | `UserItemRecommendationsBlockController` `::showAction()`       | `productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string) | Product                  |
| [The Personal Shopping Assistant (additional sales)](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#the-personal-shopping-assistant-additional-sales-block)                                                                   | `UserCrossSellingBlockController` `::showAction()`              | `showInStock` (boolean), `limit` (integer), `template` (string)                         | Product                  |
| [The Personal Shopping Assistant (conversion)](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#the-personal-shopping-assistant-conversion-block)                                                                               | `UserCrossSellingBlockController` `::showAction()`              | `showInStock` (boolean), `limit` (integer), `template` (string)                         | Product                  |
| [User's item history](../../../../user/recommendations/raptor_integration/raptor_recommendation_blocks/index.md#users-item-history-block)                                                                                                                                | `UserItemHistoryBlockController` `::showAction()`               | `showInStock` (boolean), `limit` (integer), `template` (string)                         | Product                  |

Each template receives a `recommendations` Twig variable, which is a list with either [`Ibexa\Contracts\ProductCatalog\Values\ProductInterface`](../../../../../../ibexa/product-catalog/src/contracts/Values/ProductInterface.php) instances for product recommendations or [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) instances for content recommendations.

Two generic templates are provided and can be used in `./templates/themes/<theme>` directory:

- `@ibexadesign/ibexa/recommendations/_content_list.html.twig` for content items:

```html+twig
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

- `@ibexadesign/ibexa/recommendations/_product_list.html.twig` for products:

```html+twig
{% if recommendations is not empty %}
    <ul>
        {% for product in recommendations %}
            <li><a href="{{ ibexa_path(product) }}">{{ product.name }}</a></li>
        {% endfor %}
    </ul>
{% endif %}
```

To fetch recommendations for the remaining modules, you need to [create a custom controller](../../../templating/queries_and_controllers/controllers/index.md) and use a method from [`Ibexa\Contracts\ConnectorRaptor\Recommendations\RecommendationsServiceInterface`](../../../../../../ibexa/connector-raptor/src/contracts/Recommendations/RecommendationsServiceInterface.php).

Use this method to display recommendations on any page, for example, on a specific product page, as shown below:

![Custom rendering](https://doc.ibexa.co/en/5.0/recommendations/raptor_integration/img/custom_rendering.png)
