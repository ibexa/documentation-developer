---
description: Use existing controllers to render recommendations outside the Page Builder.
month_change: false
---

# Custom recommendation rendering

You can use existing controllers to render [recommendations](recommendation_blocks.md) outside the Page Builder.
The controllers responsible for rendering block recommendations on the front-end are independent and can be used to render recommendations for specific strategies.

Each controller can be used to retrieve and display recommendations within a Twig template as follows:

``` html+twig
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

|Block name| Controller                                                                                  |Parameters|Recommendation item type|
|----------|---------------------------------------------------------------------------------------------|----------|------------------------|
|[Content that have been seen along with the item category]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#content-that-has-been-seen-along-with-the-item-category-block)| <nobr>`ContentBasedOnProductCategoryBlockController`</nobr><br><nobr>`::showAction()`</nobr> |<nobr>`categoryId` (integer),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Content|
|[Items associated with the given Content]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#items-associated-with-the-given-content-block)| <nobr>`ItemsBasedOnContentBlockController`</nobr><br><nobr>`::showAction()`</nobr> |<nobr>`contentId` (integer),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Items of Customized Feeds sorted by personal preferences and popularity or trendiness]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#items-of-customized-feeds-sorted-by-personal-preferences-and-popularity-or-trendiness)| <nobr>`MerchandisingItemsBlockController`</nobr><br><nobr>`::showAction()`</nobr> |<nobr>`merchandisingCampaignId` (string),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Merchandising content sorted by personal preferences and popularity]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#merchandising-content-sorted-by-personal-preferences-and-popularity)| <nobr>`MerchandisingContentBlockController`</nobr><br><nobr>`::showAction()`</nobr> |<nobr>`merchandisingCampaignId` (string),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Content|
|[Most popular content]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#most-popular-content-block)| <nobr>`PopularContentBlockController`</nobr><br><nobr>`::showAction()`</nobr>                                  |<nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Content|
|[Most popular products]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#most-popular-products-block)| <nobr>`PopularItemsBlockController`</nobr><br><nobr>`::showAction()`</nobr>                                    |<nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Most popular products in category]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#most-popular-products-in-category-block)| <nobr>`PopularItemsInCategoryBlockController`</nobr><br><nobr>`::showAction()`</nobr>                          |<nobr>`categoryId` (integer),</nobr><br><nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Other customers have also seen]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-block)| <nobr>`SimilarItemsBlockController`</nobr><br><nobr>`::showAction()`</nobr>                                    |<nobr>`productCode` (string),</nobr><br><nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Other customers have also seen this content]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-this-content-block)| <nobr>`SimilarContentBlockController`</nobr><br><nobr>`::showAction()`</nobr>                                  |<nobr>`contentId` (integer),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Content|
|[Other Customers Have also Purchased block]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-purchased-block)| <nobr>`OtherCustomersAlsoPurchasedBlockController`</nobr><br><nobr>`::showAction()`</nobr>                     |<nobr>`productCode` (string),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[Personalized content recommendations]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#personalized-content-recommendations-block)| <nobr>`UserContentRecommendationsBlockController`</nobr><br><nobr>`::showAction()`</nobr>                      |<nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Content|
|[The Personal Shopping Assistant]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#the-personal-shopping-assistant-block)| <nobr>`UserItemRecommendationsBlockController`</nobr><br><nobr>`::showAction()`</nobr>                         |<nobr>`productCode` (string),</nobr><br><nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[The Personal Shopping Assistant (additional sales)]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#the-personal-shopping-assistant-additional-sales-block)| <nobr>`UserCrossSellingBlockController`</nobr><br><nobr>`::showAction()`</nobr>                         |<nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[The Personal Shopping Assistant (conversion)]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#the-personal-shopping-assistant-conversion-block)| <nobr>`UserCrossSellingBlockController`</nobr><br><nobr>`::showAction()`</nobr>                         |<nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|
|[User's item history]([[= user_doc =]]/recommendations/raptor_integration/raptor_recommendation_blocks/#users-item-history-block)| <nobr>`UserItemHistoryBlockController`</nobr><br><nobr>`::showAction()`</nobr>                                 |<nobr>`showInStock` (boolean),</nobr><br><nobr>`limit` (integer),</nobr><br><nobr>`template` (string)</nobr>|Product|

Each template receives a `recommendations` Twig variable, which is a list with either [`Ibexa\Contracts\ProductCatalog\Values\ProductInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html) instances for product recommendations or [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) instances for content recommendations.

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

- `@ibexadesign/ibexa/recommendations/_product_list.html.twig` for products:

``` html+twig
{% if recommendations is not empty %}
    <ul>
        {% for product in recommendations %}
            <li><a href="{{ ibexa_path(product) }}">{{ product.name }}</a></li>
        {% endfor %}
    </ul>
{% endif %}
```

To fetch recommendations for the remaining modules, you need to [create a custom controller](controllers.md) and use a method from [`Ibexa\Contracts\ConnectorRaptor\Recommendations\RecommendationsServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Recommendations-RecommendationsServiceInterface.html).

Use this method to display recommendations on any page, for example, on a specific product page, as shown below:

![Custom rendering](custom_rendering.png)
