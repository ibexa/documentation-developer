---
description: Use existing controllers to render recommendations outside the Page Builder.
month_change: true
---

## Custom recommendation rendering

You can use existing controllers to render recommendations outside the Page Builder.

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

