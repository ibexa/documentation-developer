---
description: Use existing controllers to render recommendations outside the Page Builder.
month_change: true
---

## Custom recommendation rendering

You can use existing controllers to render recommendations outside the Page Builder.

|Block name|Controller|Parameters|Recommendation item type|
|----------|----------|----------|------------------------|
|Other customers have also seen this content|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\SimilarContentBlockController::showAction`|`contentId` (integer), `limit` (integer), `template` (string)|Content|
|Most popular content|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularContentBlockController::showAction`|`limit` (integer), `template` (string)|Content|
|Personalized content recommendations|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserContentRecommendationsBlockController::showAction`|`limit` (integer), `template` (string)|Content|
|Most popular products in category|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularItemsInCategoryBlockController::showAction`|`categoryId` (numeric), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|Most popular products|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\PopularItemsBlockController::showAction`|`showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|Other customers have also seen|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\SimilarItemsBlockController::showAction`|`productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|Other Customers Have also Purchased|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\OtherCustomersAlsoPurchasedBlockController::showAction`|`productCode` (string), `limit` (integer), `template` (string)|Product|
|The Personal Shopping Assistant|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserItemRecommendationsBlockController::showAction`|`productCode` (string), `showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|User's item history|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\UserItemHistoryBlockController::showAction`|`showInStock` (boolean), `limit` (integer), `template` (string)|Product|
|Content that have been seen along with the item category|`Ibexa\\Bundle\\ConnectorRaptor\\Controller\\Block\\ContentBasedOnProductCategoryBlockController::showAction`|`categoryId` (integer), `limit` (integer), `template` (string)|Content|
